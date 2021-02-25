<?php namespace Framework\Handlers;

use Contracts\Template\TemplateInterface;
use League\Route\Http\Exception\HttpExceptionInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ErrorResponseHandler implements ErrorHandlerInterface
{
    /** @var ResponseFactoryInterface */
    private $factory;

    /** @var TemplateInterface */
    private $engine;

    public function __construct(ResponseFactoryInterface $factory, TemplateInterface $engine)
    {
        $this->factory = $factory;
        $this->engine = $engine;
    }

    public function handle(Throwable $error): ResponseInterface
    {
        $code = $error instanceof HttpExceptionInterface ? $error->getStatusCode() : $error->getCode();
        $code = $code >= 100 && in_array($code, [404, 405]) ? $code : 500;

        $response = $this->factory->createResponse($code);
        $template = $this->engine->render($code);

        $response->getBody()->write($template);

        return $response->withStatus($code, strtok($error->getMessage(), "\n"));
    }
}