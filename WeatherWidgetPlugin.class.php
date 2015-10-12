<?php

/**
 * WeatherWidgetPlugin.class.php
 *
 * Widget that shows you the Weather
 *
 * @author  Florian Bieringer <florian.bieringer@uni-passau.de>
 * @version 1.0
 */
class WeatherWidgetPlugin extends StudIPPlugin implements PortalPlugin {

    const APIKEY = '02f7c0bdaae418cfad0f061298b3f8c3';
    const URL = "http://api.openweathermap.org/data/2.5/weather?q=";
    const FORECAST_URL = "http://api.openweathermap.org/data/2.5/forecast/daily?q=";
    const LOCATION = "passau";
    const CACHENAME = "plugin/weatherwidget";

    public static $weather;
    public static $forecast;

    public function getWeather() {

        // Check class cache
        if (self::$weather != null) {
            return json_decode(self::$weather);
        }

        // Check application cache
        $cache = StudipCacheFactory::getCache();
        if (!$data = $cache->read(self::CACHENAME . "/current")) {
            ini_set('default_socket_timeout', 2);
            $handle = fopen(self::URL . self::LOCATION . '&APPID=' . self::APIKEY, "r");
            if ($handle) {
                $data = fgets($handle);
            }
            if ($data) {
                $cache->write(self::CACHENAME . "/current", $data, 300);
                self::$weather = $data;
            }
        }
        return json_decode($data);
    }

    public function getForecast() {

        // Check class cache
        if (self::$forecast != null) {
            return json_decode(self::$forecast);
        }

        // Check application cache
        $cache = StudipCacheFactory::getCache();
        if (!$data = $cache->read(self::CACHENAME . "/forecast")) {
            ini_set('default_socket_timeout', 2);
            $handle = fopen(self::FORECAST_URL . self::LOCATION . '&APPID=' . self::APIKEY, "r");
            if ($handle) {
                $data = fgets($handle);
            }
            if ($data) {
                $cache->write(self::CACHENAME . "/forecast", $data, 300);
                self::$weather = $data;
            }
        }
        return json_decode($data);
    }

    public function getPluginName() {
        return _('Wetter in') . ' ' . self::getWeather()->name;
    }

    public function getPortalTemplate() {
        $templatefactory = new Flexi_TemplateFactory(__DIR__ . "/templates");
        $template = $templatefactory->open("index.php");

        $template->set_attribute("data", self::getWeather());
        $template->set_attribute("forecast", self::getForecast());
        $template->set_attribute("iconUrl", $this->getPluginURL() . '/icons/');
        return $template;
    }

}
