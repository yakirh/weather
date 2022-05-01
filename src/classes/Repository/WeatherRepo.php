<?php

namespace MyApp\Repository;
use MyApp\Model\WeatherModel;
use PDO;

class WeatherRepo {

	public function create(WeatherModel $weatherModel): WeatherModel
	{
		$pdo = MySQL::getInstance();

		$sql = $pdo->prepare("INSERT INTO weather (`city`, `day_timestamp`, `temp_celsius`) VALUES (:city, :day_timestamp, :temp_celsius)");
		$city          = $weatherModel->getCity();
		$day_timestamp = $weatherModel->getDayTimestamp();
		$temp_celsius  = $weatherModel->getTempCelsius();
		$sql->bindParam(':city',          $city);
		$sql->bindParam(':day_timestamp', $day_timestamp, PDO::PARAM_INT);
		$sql->bindParam(':temp_celsius',  $temp_celsius,  PDO::PARAM_INT);
		$sql->execute();

		$weatherModel->setId($pdo->lastInsertId());
		return $weatherModel;
	}

	public function getLastWeatherByCity($city): ?WeatherModel
	{
		$pdo = MySQL::getInstance();

		$sql = $pdo->prepare("SELECT * FROM weather WHERE `city` = :city ORDER BY `day_timestamp` DESC LIMIT 1");
		$sql->bindParam(':city', $city);
		$sql->execute();

		$result = $sql->fetchAll(PDO::FETCH_ASSOC);
		if ( ! $result || ! isset($result[0]))
			return NULL;

		return new WeatherModel($result[0]);
	}
}