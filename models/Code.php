<?php


namespace app\models;


class Code
{
    public static function form_dict()
    {
        $dict = [
            'а', 'б', 'в', 'г', 'ґ', 'д', 'е', 'є', 'ж', 'з', 'и',
            'і', 'ї', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с',
            'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ь', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Ґ', 'Д', 'Е', 'Є', 'Ж', 'З', 'И',
            'І', 'Ї', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С',
            'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ь', 'Ю', 'Я',
            'ё', 'ъ', 'ы', 'Ё', 'Ъ', 'Ы',
        ];

        for ($i = 32; $i < 128; $i++)
        {
            $dict[] = chr($i);
        }

        return $dict;
    }

    private static function encode_val($word)
    {
        $list_code = [];
        $lent      = strlen($word);
        $dict      = self::form_dict();
        $word      = preg_split('//u', $word, null, PREG_SPLIT_NO_EMPTY);

        for ($i = 0; $i < $lent; $i++)
        {
            foreach ($dict as $key => $val)
            {
                if ($word[$i] == $val) $list_code[] = $key;
            }
        }

        return $list_code;
    }

    private static function comparator($value, $key)
    {
        $value = self::encode_val($value);
        $key   = self::encode_val($key);

        $len_key = count($key);
        $dict    = [];
        $iter    = 0;

        foreach ($value as $v)
        {
            $dict[] = [$v, $key[$iter]];
            $iter++;

            if ($iter >= $len_key) $iter = 0;
        }

        return $dict;
    }

    public static function full_encode($value, $key = 'key')
    {
        $dict = self::comparator($value, $key);
        $list = [];
        $d    = self::form_dict();

        foreach ($dict as $k => $v)
        {
            $go     = ($dict[$k][0] + $dict[$k][1]) % count($d);
            $list[] = $go;
        }

        return self::decode_val($list);
    }

    private static function decode_val($list_in)
    {
        $list_code = [];
        $lent      = count($list_in);
        $d         = self::form_dict();

        for ($i = 0; $i < $lent; $i++)
        {
            foreach ($d as $key => $val)
            {
                if ($list_in[$i] == $key) $list_code[] = $val;
            }
        }

        return implode($list_code);
    }

    public static function full_decode($value, $key = 'key')
    {
        $dict = self::comparator($value, $key);
        $d    = self::form_dict();
        $list = [];

        foreach ($dict as $k => $v)
        {
            $go     = ($dict[$k][0] - $dict[$k][1] + count($d)) % count($d);
            $list[] = $go;
        }

        return self::decode_val($list);
    }
}