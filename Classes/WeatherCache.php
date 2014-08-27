<?php

namespace InfiniteDevelopers\WeatherWidgetBundle\Classes;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\AbstractCache;

/**
 * Example cache implementation.
 *
 * @ignore
 */
class WeatherCache extends AbstractCache
{
    private $cache_dir;

    public function __construct($cache_dir)
    {
        $this->cache_dir = $cache_dir;
    }

    protected function getCacheDir()
    {
        return $this->cache_dir . DIRECTORY_SEPARATOR . "OpenWeatherMapPHPAPI";
    }

    private function urlToPath($url)
    {
        $dir = $this->getCacheDir();
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $path = $dir . DIRECTORY_SEPARATOR . md5($url);

        return $path;
    }

    /**
     * @inheritdoc
     */
    public function isCached($url)
    {
        $path = $this->urlToPath($url);
        if (!file_exists($path) || filectime($path) + $this->seconds < time()) {
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getCached($url)
    {
        return file_get_contents($this->urlToPath($url));
    }

    /**
     * @inheritdoc
     */
    public function setCached($url, $content)
    {
        file_put_contents($this->urlToPath($url), $content);
    }
}