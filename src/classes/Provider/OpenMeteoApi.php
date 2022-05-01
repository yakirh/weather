<?php

namespace MyApp\Provider;

use GuzzleHttp;
use RuntimeException;

class OpenMeteoApi implements WeatherApi {

	/**
	 * @throws GuzzleHttp\Exception\GuzzleException
	 */
	public function getTempByCity($city): int
	{
		list($latitude, $longitude) = $this->getGeoByCity($city);
		return $this->getTempByGeo($latitude, $longitude);
	}

	/**
	 * API Docs: https://open-meteo.com/en/docs/geocoding-api
	 *
	 * Request example:
	 * https://geocoding-api.open-meteo.com/v1/search?name=Jerusalem
	 *
	 * @param string $city
	 * @return float[]
	 * @throws RuntimeException
	 * @throws GuzzleHttp\Exception\GuzzleException
	 */
	private function getGeoByCity(string $city): array
	{
		$guzzleClient = new GuzzleHttp\Client();
		$response = $guzzleClient->request(
			'GET',
			'https://geocoding-api.open-meteo.com/v1/search',
			[
				'query' => [
					'name' => $city
				]
			]
		);

		$responseJson = $response->getBody()->getContents();
		$responsePayload = json_decode($responseJson, TRUE);

		if ($responsePayload === NULL)
			throw new RuntimeException('OpenMeteoApi returned invalid json in response');

		if ( ! isset($responsePayload['results'][0]))
			throw new RuntimeException('OpenMeteoApi - no result for city: '.$city);

		$cityResults = $responsePayload['results'][0];

		return [ $cityResults['latitude'], $cityResults['longitude'] ];
	}

	/**
	 * API Docs: https://open-meteo.com/en/docs
	 *
	 * Request Example:
	 * https://api.open-meteo.com/v1/forecast?latitude=31.7857&longitude=35.2007&hourly=temperature_2m
	 *
	 * @param float $latitude
	 * @param float $longitude
	 * @return int
	 * @throws RuntimeException
	 * @throws GuzzleHttp\Exception\GuzzleException
	 */
	private function getTempByGeo(float $latitude, float $longitude): int
	{
		$guzzleClient = new GuzzleHttp\Client();
		$response = $guzzleClient->request(
			'GET',
			'https://api.open-meteo.com/v1/forecast',
			[
				'query' => [
					'latitude'  => (string) $latitude,
					'longitude' => (string) $longitude,
					'hourly'    => 'temperature_2m',
				]
			]
		);

		$responseJson = $response->getBody()->getContents();
		$responsePayload = json_decode($responseJson, TRUE);

		if ($responsePayload === NULL)
			throw new RuntimeException('OpenMeteoApi returned invalid json in response');

		$temperatureHoursArray = array_filter($responsePayload['hourly']['temperature_2m']);

		// Return the average temperature from the whole day
		return (int) round(
			array_sum($temperatureHoursArray) / count($temperatureHoursArray)
		);
	}
}