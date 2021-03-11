<?php namespace App\Extensions\Traits;

trait Dom
{
    public static function addLoner($tag, array $attr = [])
    {
        return '<'.$tag.self::attributes($attr).'/>';
    }

    public static function addContainer($tag, $content = '', array $attr = [])
    {
        return '<'.$tag.self::attributes($attr).'>'.$content.'</'.$tag.'>';
    }

    private static function attributes(array $attributes = [])
    {
        if (null !== $attributes)
        {
            $data = [];

            foreach ($attributes as $name => $value)
            {
                if(is_null($value)) continue;

                $data[] = ' '.htmlspecialchars($name).'="'.htmlspecialchars($value).'"';
            }

            return implode('', $data);
        }

        return false;
    }
}
