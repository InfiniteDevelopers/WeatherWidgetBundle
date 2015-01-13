<?php

namespace InfiniteDevelopers\WeatherWidgetBundle\Twig;

use Symfony\Component\HttpFoundation\File\File;

class WeatherWidgetExtension extends \Twig_Extension
{
    private $_owm;
    private $_environment;
    private $icon_config;

    public function __construct($owm)
    {
        $this->_owm = $owm;
        $this->icon_config = array(
            '01d' => 'day_sun',
            '02d' => 'day_sun',
            '03d' => 'day_cloud',
            '04d' => 'day_cloud',
            '09d' => 'day_rain',
            '10d' => 'day_rain',
            '11d' => 'day_storm',
            '13d' => 'day_snow',
            '50d' => 'day_cloud',
            '01n' => 'night_clear',
            '02n' => 'night_clear',
            '03n' => 'night_cloud',
            '04n' => 'night_cloud',
            '09n' => 'night_rain',
            '10n' => 'night_rain',
            '11n' => 'night_storm',
            '13n' => 'night_snow',
            '50n' => 'night_cloud'
        );
    }


    public function initRuntime(\Twig_Environment $environment)
    {
        $this->_environment = $environment;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('weather_widget', array($this, 'renderWidget'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('ww_r2p', array($this, 'ressourceToPath'))
        );
    }

    /**
     * get current weather and render a widget
     * @param  string $query query for open weather map api
     * @return string        rendered widget
     */
    public function renderWidget($query)
    {
        $resp = $this->_owm->getWeather($query);
        $unit = $resp->temperature->getUnit() == 'F' ? 'F' : 'C';

        $type = $this->icon_config[$resp->weather->icon];

        return $this->_environment->render('InfiniteDevelopersWeatherWidgetBundle::widget.html.twig',
            array(
                'weather' => $resp,
                'type' => $type,
                'unit' => $unit
            )
        );
    }
    /**
     * Transform local ressource string to absolute file path
     * @param  string $path relative path to image from bundle directory
     * @return string       absolute path to image
     */
    public function ressourceToPath($path)
    {
        return __DIR__.'/../'.$path;
    }

    public function getName()
    {
        return 'weather_widget';
    }
}