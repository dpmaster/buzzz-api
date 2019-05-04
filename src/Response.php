<?php

namespace Buzzz\Api;

class Response {

    public function __construct($data, $code = "200")
    {

        if (isset($data["error"]) && $data["error"]) {
            $code = 404;
        }

        if (is_null($data)) {
            $code = 500;
        }

        http_response_code($code);
        header('Content-Type: application/json');
        die(json_encode($data));
    }
}