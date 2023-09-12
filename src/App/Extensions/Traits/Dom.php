<?php namespace App\Extensions\Traits;

use Helpers\Corrector;

trait Dom
{
    public static function loner($tag, array $attr = []): string
    {
        return '<'.$tag.self::attributes($attr).'/>';
    }

    public static function container($tag, $content = '', array $attr = []): string
    {
        return '<'.$tag.self::attributes($attr).'>'.$content.'</'.$tag.'>';
    }

    private static function attributes(array $attributes): string
    {
        $data = []; foreach($attributes as $name => $value) $data[] = is_int($name) ? $name : $name.'='.Corrector::Framing($value, '"'); return implode(' ', $data);
    }
}