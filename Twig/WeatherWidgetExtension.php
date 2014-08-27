<?php

namespace InfiniteDevelopers\WeatherWidgetBundle\Twig;

use Symfony\Component\HttpFoundation\File\File;

class WeatherWidgetExtension extends \Twig_Extension
{
    private $_owm;
    private $_environment;

    public function __construct($owm)
    {
        $this->_owm = $owm;
    }


    public function initRuntime(\Twig_Environment $environment)
    {
        $this->_environment = $environment;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('weather_widget', array($this, 'renderWidget'), array('is_safe' => array('html')))
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

        $type = 'cloud';

        return $this->_environment->render('InfiniteDevelopersWeatherWidgetBundle::widget.html.twig',
            array(
                'weather' => $resp,
                'type' => $type,
                'unit' =>$unit
            )
        );
    }

    public function getName()
    {
        return 'weather_widget';
    }
}