<?php

namespace App\Extensions;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class Containers
 * @package App\Extensions
 * @method string h1(string $content, array $attr = null)
 * @method string h2(string $content, array $attr = null)
 * @method string h3(string $content, array $attr = null)
 * @method string h4(string $content, array $attr = null)
 * @method string h5(string $content, array $attr = null)
 */
class Containers implements ExtensionInterface
{
    use Traits\Dom;

    const headings = ['h1', 'h2', 'h3', 'h4', 'h5'];

    public function register(Engine $engine)
    {
        foreach(self::headings as $heading) $engine->registerFunction($heading, [$this, $heading]);

        $engine->registerFunction('container', __CLASS__.'::container');
        $engine->registerFunction('loner', __CLASS__.'::loner');
    }

    public function __call($name, $arguments)
    {
        if(!in_array($name, self::headings)) return null; array_unshift($arguments, $name); return self::container(...$arguments);
    }
}
