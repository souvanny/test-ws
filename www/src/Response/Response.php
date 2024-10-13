<?php

namespace App\Response;

class Response
{
    protected $statusCode;
    protected $data;

    public function __construct($data = [], $statusCode = 200)
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function send()
    {
        http_response_code($this->statusCode);

        header('Content-Type: text/html');

        echo json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }
}
