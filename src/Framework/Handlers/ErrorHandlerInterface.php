<?php namespace Framework\Handlers;

use Psr\Http\Message\ResponseInterface;
use Throwable;

interface ErrorHandlerInterface
{
    public function handle(Throwable $error): ResponseInterface;
}
