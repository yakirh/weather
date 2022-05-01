<?php

namespace MyApp\Model;

class WeatherModel {

	private int $id;
	private string $city;
	private int $day_timestamp;
	private int $temp_celsius;

	public function __construct(array $values)
	{
		if (isset($values['id']))
			$this->setId($values['id']);

		if (isset($values['city']))
			$this->setCity($values['city']);

		if (isset($values['day_timestamp']))
			$this->setDayTimestamp($values['day_timestamp']);

		if (isset($values['temp_celsius']))
			$this->setTempCelsius($values['temp_celsius']);
	}

	public function toArray(): array
	{
		return [
			'id'            => $this->getId(),
			'city'          => $this->getCity(),
			'day_timestamp' => $this->getDayTimestamp(),
			'temp_celsius'  => $this->getTempCelsius(),
		];
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getCity()
	{
		return $this->city;
	}

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function getDayTimestamp()
	{
		return $this->day_timestamp;
	}

	public function setDayTimestamp($dayTimestamp)
	{
		$this->day_timestamp = $dayTimestamp;
	}

	public function getTempCelsius()
	{
		return $this->temp_celsius;
	}

	public function setTempCelsius($tempCelsius)
	{
		$this->temp_celsius = $tempCelsius;
	}
}