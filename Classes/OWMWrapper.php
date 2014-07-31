<?php

namespace InfiniteDevelopers\WeatherWidgetBundle\Classes;

use Cmfcmf\OpenWeatherMap;

class OWMWrapper
{
	private $apiKey;
	private $lang;
	private $units;

	public function __construct($apiKey = '', $lang = 'en', $units = 'metric')
	{
		$this->apiKey = $apiKey;
		$this->lang = $lang;
		$this->units = $units;
	}

	public function getWeather($query)
	{
		$owm = new OpenWeatherMap();
		return $weather = $owm->getWeather($query, $this->units, $this->lang, $this->apiKey);
	}

	public function getWeatherForecast($query, $days = 1)
	{
		$owm = new OpenWeatherMap();
		return $owm->getWeatherForecast($query, $this->units, $this->lang, $this->apiKey, $days)	;
	}
	public function getWeatherHistory($query, \DateTime $start, $endOrCount = 1, $type = 'hour')
	{
		$owm = new OpenWeatherMap();
		return $own->getWeatherHistory($query, $start, $endOrCount, $type, $this->units, $this->lang, $this->apiKey);
	}
}