<?php namespace App\Extensions;

use League\Plates\Engine;
use League\Plates\Extension\Asset;
use League\Plates\Extension\ExtensionInterface;

class AssetRender implements ExtensionInterface
{
    use Traits\Dom;

    /** @var array */
    private $assets = [];

    /** @var Asset */
    private $asset;

    public function __construct(string $path = 'public')
    {
        $this->asset = new Asset($path);
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('group', [$this, 'group']);
        $engine->registerFunction('get', [$this, 'get']);
    }

    public function get(string $url)
    {
        if(!array_key_exists($url, $this->assets)) $this->add($url); return $this->assets[$url];
    }

    private function add(string $url)
    {
        $this->assets[$url] = ([$this, pathinfo($url, PATHINFO_EXTENSION)])($this->asset->cachedAssetUrl($url));
    }

    protected function js(string $url)
    {
        return self::container('script', false, ['type' => 'text/javascript', 'src' => $url]);
    }

    protected function css(string $url)
    {
        return self::loner('link', ['type' => 'text/css', 'rel' => 'stylesheet', 'href' => $url]);
    }

    public function group(array $urls)
    {
        $new = []; foreach($urls as $url) $new[] = $this->get($url); return implode(PHP_EOL, $new);
    }
}