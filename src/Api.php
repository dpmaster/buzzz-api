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

        /** @var Config  $config */
        foreach ($this->config as $config) {
            $parser = new Parser($config);
            if ($parser->checkUrl($_SERVER['REQUEST_URI'])) {
                $data = $parser->parseUrl($_SERVER['REQUEST_URI']);

                try {
                    $result = $this->execute($data['class'], $data['method'], $this->getRequestData());
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

    private function execute($class_name, $method_name, $request_data = null) {
        if (!$request_data) $request_data = new stdClass();
        $instance = new $class_name();
        if (!method_exists($instance, $method_name)) {
            throw new \Exception('Undefined action');
        }
        return call_user_func_array(array($instance, $method_name), array($request_data));
    }

    private function getRequestData() {
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data) ?: (object) $_REQUEST;
        return $dataJsonDecode;
    }
}
