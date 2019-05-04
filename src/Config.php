<?php

namespace Buzzz\Api;

class Config {

    private $pattern = "/api/:controller/:action/";
    private $controller_namespace = "\\App\\Controller\\";
    private $controller_suffix = "Controller";
    private $action_suffix = "Action";

    public function __construct($config)
    {
        if (isset($config['pattern'])) $this->pattern = $config['pattern'];
        if (isset($config['controller_namespace'])) $this->controller_namespace = $config['controller_namespace'];
        if (isset($config['controller_suffix'])) $this->controller_suffix = $config['controller_suffix'];
        if (isset($config['action_suffix'])) $this->action_suffix = $config['action_suffix'];
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     * @return Config
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @return string
     */
    public function getControllerNamespace()
    {
        return $this->controller_namespace;
    }

    /**
     * @param string $controller_namespace
     * @return Config
     */
    public function setControllerNamespace($controller_namespace)
    {
        $this->controller_namespace = $controller_namespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getControllerSuffix()
    {
        return $this->controller_suffix;
    }

    /**
     * @param string $controller_suffix
     * @return Config
     */
    public function setControllerSuffix($controller_suffix)
    {
        $this->controller_suffix = $controller_suffix;
        return $this;
    }

    /**
     * @return string
     */
    public function getActionSuffix()
    {
        return $this->action_suffix;
    }

    /**
     * @param string $action_suffix
     * @return Config
     */
    public function setActionSuffix($action_suffix)
    {
        $this->action_suffix = $action_suffix;
        return $this;
    }


}