<?php

namespace MyApp\Repository;

use PDO;

class MySQL {

	protected static PDO $instance;

	protected function __construct() {}

	public static function getInstance(): PDO
	{

		if ( ! empty(self::$instance))
		{
			return self::$instance;
		}

		$db_info = [
			'db_host'    => 'localhost',
			'db_port'    => '3306',
			'db_user'    => 'root',
			'db_pass'    => '',
			'db_name'    => 'weather',
		];

		self::$instance = new PDO('mysql:host='.$db_info['db_host'].';port='.$db_info['db_port'].';dbname='.$db_info['db_name'], $db_info['db_user'], $db_info['db_pass']);
		self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		self::$instance->query('SET NAMES utf8');
		self::$instance->query('SET CHARACTER SET utf8');

		return self::$instance;
	}
}