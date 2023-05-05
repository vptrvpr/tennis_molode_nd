<?php

namespace App\Helpers;

/**
 * Class StringHelper
 *
 * @package App\String
 */
class StringHelper
{
    /**
     * Рандомный набор символов
     *
     * @param int $length
     *
     * @return string
     */
    public static function strRandom( $length = 10 )
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen( $characters );
        $randomString     = '';
        for( $i = 0; $i < $length; $i++ ) {
            $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
        }

        return $randomString;
    }


    /**
     * Рандомный набор чисео
     *
     * @param int $length
     *
     * @return string
     */
    public static function strRandomNumbers( $length = 10 )
    {
        $characters       = '0123456789';
        $charactersLength = strlen( $characters );
        $randomString     = '';
        for( $i = 0; $i < $length; $i++ ) {
            $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
        }

        return $randomString;
    }


    /**
     * проверяем все ли буквы в верхнем регистре
     *
     * @param string $str
     *
     * @return bool
     */
    public static function isOnlyUpperCase( string $str )
    {
        return preg_match( '~^\p{Lu}~u', $str ) ? TRUE : FALSE;
    }


    /**
     * транслит на латиницу
     *
     * @param $s
     *
     * @return string
     */
    public static function translit( $s )
    {
        $s = (string)$s; // преобразуем в строковое значение
        $s = str_replace( ' ', '_', $s ); // убираем пробелы в начале и конце строки
        $s = function_exists( 'mb_strtolower' ) ? mb_strtolower( $s ) : strtolower( $s ); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr( $s, [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh',
            'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => '',
        ] );

        return $s; // возвращаем результат
    }


    public static function translateToLatin( $s )
    {
        $from        = mb_str_split( 'абвгдеёзийклмнопрстуфхцэыяшщючьжАБВГДЕЁЗИЙКЛМНОПРСТУФХЦЭЫЯШЩЮЧЬЖ' );
        $to          = mb_str_split( 'abvgdeezijklmnoprstufхceyassychgABVGDEEZIJKLMNOPRSTUFХCEYASSYCHG' );
        $strReplaces = [];

        foreach( $from as $key => $fromSymbol ) {
            $strReplaces[ $fromSymbol ] = $to[ $key ];
        }

        $s = (string)$s; // преобразуем в строковое значение
        $s = str_replace( ' ', '_', $s ); // убираем пробелы в начале и конце строки
        $s = function_exists( 'mb_strtolower' ) ? mb_strtolower( $s ) : strtolower( $s ); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr( $s, $strReplaces );

        return mb_strtoupper( $s );
    }

}
