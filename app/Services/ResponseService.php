<?php

namespace App\Services;

class ResponseService
{

    private int $code = 200;

    private bool $success = true;

    private string $message = '';

    private array $data = [];


    protected function success()
    {

    }

    protected function error()
    {

    }
}
