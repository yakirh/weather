<?php

namespace MyApp\Provider;

interface WeatherApi {

	public function getTempByCity($city): int;

}