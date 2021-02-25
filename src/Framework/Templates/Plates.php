<?php namespace Framework\Templates;

use Contracts\Template\TemplateInterface;
use League\Plates\Engine;

class Plates implements TemplateInterface
{
    /** @var Engine  */
    private $engine;

    public function __construct($path, $extension = 'php')
    {
        $this->engine = new Engine($path, $extension);
    }

    public function render($name, array $params = []): string
    {
        return $this->engine->make($name)->render($params);
    }
}
