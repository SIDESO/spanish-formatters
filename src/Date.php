<?php

namespace Sideso\SpanishFormatters;

use Carbon\Carbon;

class Date
{
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
}