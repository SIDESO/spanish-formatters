<?php

namespace Sideso\SpanishFormatters;

use Carbon\Carbon;

class Date
{
    /**
     * Get days in spanish.
     * 
     * @param bool $short Return short names
     * 
     * @return array
     */
    public static function getDays(bool $short = false): array
    {
        if ($short) {
            return ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        }

        return ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    }

    /**
     * Get day name in spanish.
     * 
     * @param Carbon $date Date to get day name
     * @param bool $short Return short name
     * 
     * @return string
     */
    public static function getDay(Carbon $date, bool $short = false): string
    {
        return self::getDays($short)[$date->dayOfWeek];
    }

    /**
     * Get months in spanish.
     * 
     * @param bool $short Return short names
     * 
     * @return array
     */
    public static function getMonths(bool $short = false): array
    {
        if ($short) {
            return ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        }

        return ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    }

    /**
     * Get month name in spanish.
     * 
     * @param Carbon $date Date to get month name
     * @param bool $short Return short name
     * 
     * @return string
     */
    public static function getMonth(Carbon $date, bool $short = false): string
    {
        return self::getMonths($short)[$date->month - 1];
    }

    /**
     * Get date in spanish format for documents.
     * 
     * @param Carbon $date Date to format
     * @param bool $longText Return long text
     * 
     * @return string
     */
    public static function toDocument(Carbon $date, bool $longText = true): string
    {
        if(! $longText){
            return $date->day.' de '.self::getMonth($date).' del '.$date->year;
        }

        return 'a los '.$date->day.' días del mes de '.self::getMonth($date).' del '.$date->year;
    }

    /**
     * Get date in spanish format for localized.
     * 
     * @param Carbon $date Date to format
     * @param bool $longText Return long text
     * 
     * @return string
     */
    public static function toLocalized(Carbon $date, string $format = '%a %d de %b de %Y', bool $longText = true): string
    {
        $day = $date->day;
        $dayOfWeek = self::getDay($date, !$longText);
        $month = self::getMonth($date, !$longText);
        $year = $date->year;

        $dateFormatted = str_replace('%a', $dayOfWeek, $format);
        $dateFormatted = str_replace('%d', $day, $dateFormatted);
        $dateFormatted = str_replace('%b', $month, $dateFormatted);
        $dateFormatted = str_replace('%Y', $year, $dateFormatted);

        return $dateFormatted;
    }
}