<?php

namespace Buzzz\Api;

class Api
{
    private $config = [];

    public function add(Array $config) {
        $this->config[] = new Config($config);
    }

    public function run($di = null) {

        Controller::setDi($di);

        if (!count($this->config)) {
            // default config
            $this->config[] = new Config();
        }

        /** @var Config  $config */
        foreach ($this->config as $config) {
            $parser = new Parser($config);
            if ($parser->checkUrl($_SERVER['REQUEST_URI'])) {
                $data = $parser->parseUrl($_SERVER['REQUEST_URI']);
                $params = isset($data['params']) ? $data['params'] :[];
                try {
                    $result = $this->execute($data['class'], $data['method'], $this->getRequestData(), $params, $config);
                    return new Response($result);
                } catch (\Throwable $e) {
                    return new Response(['error' => $e->getMessage()]);
                } catch (\Exception $e) {
                    return new Response(['error' => $e->getMessage()]);
                }
                break;
            }
        }

        return new Response(['error' => 'Undefined controller']);
    }

    private function execute($class_name, $method_name, $request_data = null, $params = [], Config $config = null) {
        if (!$request_data) $request_data = [];
        $instance = new $class_name();

        if($config) {
            //Test get, post, put ... actions
            $request_method = substr($method_name,0, -strlen($config->getActionSuffix())) . ucfirst(strtolower($_SERVER['REQUEST_METHOD'])) . $config->getActionSuffix();

            if(method_exists($instance, $request_method)) {
                $method_name = $request_method;
            }
        }

        if (!method_exists($instance, $method_name)) {
            throw new \Exception('Undefined action');
        }
        return call_user_func_array(array($instance, $method_name), array($request_data, $params));
    }

    private function getRequestData() {
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data, true) ?: $_REQUEST;
        return $dataJsonDecode;
    }
}
