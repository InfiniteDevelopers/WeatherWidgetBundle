<?php

namespace InfiniteDevelopers\WeatherWidgetBundle\Classes;

use Cmfcmf\OpenWeatherMap;

class OWMWrapper
{
	private $apiKey;
	private $lang;
	private $units;

	public function __construct($apiKey = '', $lang = 'en', $units = 'metric', $cacheDir)
	{
		$this->apiKey = $apiKey;
		$this->lang = $lang;
		$this->units = $units;
		$this->cacheDir = $cacheDir;
	}

	public function getWeather($query)
	{
		$owm = new OpenWeatherMap(null, new WeatherCache($this->cacheDir), 30);
		return $owm->getWeather($query, $this->units, $this->lang, $this->apiKey);
	}

	public function getWeatherForecast($query, $days = 1)
	{
		$owm = new OpenWeatherMap(null, new WeatherCache($this->cacheDir), 30);
		return $owm->getWeatherForecast($query, $this->units, $this->lang, $this->apiKey, $days)	;
	}
	public function getWeatherHistory($query, \DateTime $start, $endOrCount = 1, $type = 'hour')
	{
		$owm = new OpenWeatherMap(null, new WeatherCache($this->cacheDir), 30);
		return $own->getWeatherHistory($query, $start, $endOrCount, $type, $this->units, $this->lang, $this->apiKey);
	}
}