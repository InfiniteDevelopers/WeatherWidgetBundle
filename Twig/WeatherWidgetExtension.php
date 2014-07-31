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
            new \Twig_SimpleFunction('weather_widget', array($this, 'renderWidget'), array('is_safe' => array('html'))),

            // prefixed image64 to avoid conflic in user's projects,
            // it's not goal of this bundle to provide base64 encoding,
            // we may think about transforming images differently in next commits
            new \Twig_SimpleFunction('w_image64', array($this, 'image64'))
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

    /**
     * Transform image to base 64
     * @param  string $path relative path to image from bundle directory
     * @return string       base64 encoded image
     */
    public function image64($path)
    {
        $path = __DIR__.'/../'.$path;
        
        $file = new File($path, false);
        
        if (!$file->isFile() || 0 !== strpos($file->getMimeType(), 'image/')) {
            return;
        }
        
        $binary = file_get_contents($path);
        
        return sprintf('data:image/%s;base64,%s', $file->guessExtension(), base64_encode($binary));
    }

    public function getName()
    {
        return 'weather_widget';
    }
}