<?php

namespace Sideso\SpanishFormatters;

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
}
