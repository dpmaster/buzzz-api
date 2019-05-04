<?php

namespace Buzzz\Api;

class Parser {
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function checkUrl($url)
    {
        $uri_data = explode("/", $url);
        $pattern_data =  explode('/', $this->config->getPattern());
        for ($i = 0; $i < count($pattern_data); $i++) {
            $url_param = isset($uri_data[$i]) ? $uri_data[$i] : "";
            if (!preg_match("/:(.*)/ui", $pattern_data[$i]) && $pattern_data[$i] != $url_param  && $pattern_data[$i]) {
                return false;
            }
        }
        return true;
    }

    public function parseUrl($url)
    {
        $uri_data = explode("/", $url);
        $pattern_data =  explode('/', $this->config->getPattern());
        $data = [];

        for ($i = 0; $i < count($uri_data); $i++) {
            if (!isset($pattern_data[$i])) {
                $data['params'][] = $uri_data[$i];
                continue;
            }
            if (preg_match("/:(.*)/ui", $pattern_data[$i], $matches)) {
                $data[$matches[1]] = $uri_data[$i] ?: null;
            }
        }

        $class = ucfirst(isset($data['controller']) ? $data['controller'] : "index") . $this->config->getControllerSuffix();
        $data['class'] = $this->config->getControllerNamespace() . $class;
        $data['method'] = ucfirst(isset($data['action']) ? $data['action'] : "index") . $this->config->getActionSuffix();
        return $data;
    }

}