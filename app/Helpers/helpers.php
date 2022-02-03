<?php

use Illuminate\Support\Carbon;

if (!function_exists("now")) {
    /**
     * @return Carbon
     */
    function now(): Carbon
    {
        return Carbon::now();
    }
}

if (!function_exists("subMinutes")) {
    /**
     * @param $value
     * @return Carbon
     */
    function subMinutes($value): Carbon
    {
        return now()->subMinutes($value);
    }
}

if (!function_exists("subDays")) {
    /**
     * @param $value
     * @return Carbon
     */
    function subDays($value): Carbon
    {
        return now()->subDays($value);
    }
}

if (!function_exists("dateParse")) {
    /**
     * @param $value
     * @return Carbon
     */
    function dateParse($value): Carbon
    {
        if ($value instanceof Carbon) {
            return $value;
        }

        return Carbon::parse($value);
    }
}

if (!function_exists("dateLessThan")) {
    /**
     * Tarih geçmiş mi?
     * @param $date
     * @param int $minutes
     * @return bool
     */
    function dateLessThan($date, int $minutes = 0): bool
    {
        $date = dateParse($date);

        return $date->addMinutes($minutes)->lessThan(now());
    }
}

if (!function_exists("dateGreaterThan")) {
    /**
     * Tarih geçmemiş mi?
     * @param $date
     * @param int $minutes
     * @return bool
     */
    function dateGreaterThan($date, int $minutes = 0): bool
    {
        $date = dateParse($date);

        return $date->addMinutes($minutes)->greaterThan(now());
    }
}
