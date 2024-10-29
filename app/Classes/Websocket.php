<?php
namespace App\Classes;

use Illuminate\Support\Facades\Response;

abstract class Websocket {

    public $connection;
    public $msg;
    public $clients = array();

    public function __construct($msg, $connection, $clients) {
        $this->msg = $this->validateMsg($msg);
        $this->clients = $clients;
        $this->connection = $connection;
    }

    abstract public function execute();

    protected function validateMsg($msg): array {
        $data = $msg;
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON');
        } else {
            if (isset($data['request']) && isset($data['params'])) {
                return $data;
            }
            else
                throw new \Exception('No request, session or params');
        }
    }
}