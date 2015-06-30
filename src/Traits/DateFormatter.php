<?php


namespace Robin\Api\Traits;


use Carbon\Carbon;

trait DateFormatter
{
    public static function formatDate(Carbon $date, $delimiter = "-")
    {
        $format = "Y" . $delimiter . "m" . $delimiter . "d";
        return $date->format($format);
    }
}