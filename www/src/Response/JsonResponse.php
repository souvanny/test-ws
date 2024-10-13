<?php

namespace App\Response;

class JsonResponse extends Response
{
    public function send()
    {
        http_response_code($this->statusCode);

        header('Content-Type: application/json');

        echo json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }
}
