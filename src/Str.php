<?php

namespace Sideso\SpanishFormatters;

use Illuminate\Support\Str as BaseStr;

class Str
{
    /**
     * Normalize a string
     * 
     * @param string $string String to normalize
     * @param bool $toUpper Convert to uppercase
     * @param bool $applyPregReplace Apply preg_replace
     * @param string $pregReplacePattern Pattern to delete special characters
     * 
     * @return string
     */
    public static function toNormalize($string, bool $toUpper = true, bool $applyPregReplace = true, string $pregReplacePattern = '/[^a-zA-Z0-9]/')
    {
        // Replace accented characters
        $string = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ü'],
            ['a', 'e', 'i', 'o', 'u', 'n', 'u', 'A', 'E', 'I', 'O', 'U', 'N', 'U'],
            $string
        );

        if ($applyPregReplace) {
            // Delete special characters
            $string = preg_replace($pregReplacePattern, '', $string);
        }

        if ($toUpper) {
            // Convertir a mayúsculas
            $string = strtoupper($string);
        }

        return $string;
    }

    /**
     * Split a full name into first name, second name, last name and mother's last name
     * 
     * @param string $full_name Full name to split
     * 
     * @return array
     */
    public static function splitFullName(string $full_name)
    {
        /* Convertir a mayúsculas */
        $full_name = BaseStr::upper($full_name);

        /* Separar el nombre completo por espacios */
        $tokens = BaseStr::of($full_name)->trim()->explode(' ');

        /* Arreglo donde se guardan las "palabras" del nombre */
        $names = array();

        /* Palabras para apellidos (y nombres) compuestos */
        $special_tokens = array('DA', 'DE', 'DEL', 'LA', 'LAS', 'LOS', 'MAC', 'MC', 'VAN', 'VON', 'Y', 'I', 'SAN', 'SANTA');

        $prev = "";
        foreach ($tokens as $token) {
            $_token = $token;
            if (in_array($_token, $special_tokens)) {
                $prev .= "$token ";
            } else {
                $names[] = $prev . $token;
                $prev = "";
            }
        }

        // Eliminar espacios en blanco
        $names = collect($names)->map(fn($name) => trim($name))->filter()->values()->toArray();

        $last_name = '';
        $second_last_name = '';
        $first_name = '';
        $middle_name = '';

        $num_names = count($names);

        switch ($num_names) {
            case 0:
                break;
            case 1:
                $first_name = $names[0];
                break;
            case 2:
                $first_name = $names[0];
                $last_name = $names[1];
                break;
            case 3:
                $first_name = $names[0];
                $last_name = $names[1];
                $second_last_name = $names[2];
                break;
            case 4:
                $first_name = $names[0];
                $middle_name = $names[1];
                $last_name = $names[2];
                $second_last_name = $names[3];
                break;
            default:
                $first_name = "{$names[0]} {$names[1]}";
                $middle_name = $names[2];
                $last_name = $names[3];

                unset($names[0], $names[1], $names[2], $names[3]);
                $second_last_name = implode(' ', $names);
                break;
        }

        return [
            'last_name' => $last_name,
            'second_last_name' => $second_last_name,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
        ];
    }
}
