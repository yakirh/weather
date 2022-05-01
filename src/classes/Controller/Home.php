<?php

namespace MyApp\Controller;

use MyApp\Model\WeatherModel;
use MyApp\Repository\WeatherRepo;
use MyApp\Provider\OpenMeteoApi;

class Home {

	public function saveTempByCity($city): WeatherModel
	{
		$openMeteoApi = new OpenMeteoApi();

		$temp_celsius = $openMeteoApi->getTempByCity($city);

		$weatherModel = new WeatherModel([
			'city'          => $city,
			'day_timestamp' => strtotime('today'),
			'temp_celsius'  => $temp_celsius,
		]);

		$weatherRepository = new WeatherRepo();
		return $weatherRepository->create($weatherModel);
	}

	public function getLastTempByCity($city): WeatherModel
	{
		$weatherRepository = new WeatherRepo();

		$lastWeatherModel = $weatherRepository->getLastWeatherByCity($city);

		if ($lastWeatherModel)
			return $lastWeatherModel;

		return $this->saveTempByCity($city);
	}
}