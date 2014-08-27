#WeatherWidgetBundle

Twig extension to display a widget with the current wheater and temperature using openweathermap and cmfcmf/OpenWeatherMap-PHP-Api

## Installation 
* add dependencie in your composer.json :
```
"require": {
	[...],
    "infinitedevelopers/weatherwidget-bundle": "dev-master"
}
```

* add package in AppKernel.php
```
$bundles = array(
	[...],
    new InfiniteDevelopers\WeatherWidgetBundle\InfiniteDevelopersWeatherWidgetBundle()
);
```

## Configuration

add this in your config.yml
```
infinite_developers_weather_widget: 
    owm_key: your_open_weather_map_api_key #default null
    owm_units: metric #or imperial (°F), default metric (°C)
```

## Usage

Use it in a twig template like this
```
{{ weather_widget('query') }}

```

*query* is an open weather map query exemple for current weather in Lyon, french city :

```
{{ weather_widget('Lyon, France') }}

```

## Roadmap

Coming soon
* caching open weather map request
* serveral images for different weather conditions

Suggestion
* we're currenlyt using internal base64 converter twig extension for displaying images, we may change it

## Licence
Code is under MIT licence, image are free to use.
