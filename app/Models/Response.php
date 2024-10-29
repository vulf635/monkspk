<?php
namespace App\Models;

class Response
{
    public $message;
    public $params;
    public $status;

    public function __construct(int $status,string $message = '', array $params = [])
    {
        $this->message = $message;
        $this->params = $params;
        $this->status = $status;
    }

    public function json() {
        http_response_code($this->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this);;
    }
}