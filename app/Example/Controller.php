<?php

namespace App\Example;

class Controller {

	public function helloName($name) {
		return 'Hello, ' . $name;
	}

	public static function md5($string, $times) {
		$result = [];
		for ($i = 1; $i <= $times; $i++) {
			$string       = md5($string);
			$result[ $i ] = $string;
		}

		return $result;
	}

}