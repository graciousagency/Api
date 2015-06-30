<?php


namespace Robin\Api\Traits;


use Carbon\Carbon;

trait DateFormatter
{
    public static function formatDate($date, $delimiter = "-")
    {
        $format = "Y" . $delimiter . "m" . $delimiter . "d";
        return Carbon::createFromFormat("Y-m-d\\TH:i:sP", $date)->format($format);
    }
}