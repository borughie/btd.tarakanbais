<?php

namespace App\Helpers;

use Carbon\CarbonInterface;

class DateHelper
{
    private static array $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    public static function formatIndonesian(CarbonInterface $date): string
    {
        $day = $date->format('d');
        $month = self::$months[(int) $date->format('n')];
        $year = $date->format('Y');
        $hour = (int) $date->format('G');
        $minute = $date->format('i');

        if ($hour < 6) {
            $period = 'Pagi';
        } elseif ($hour < 12) {
            $period = 'Siang';
        } elseif ($hour < 18) {
            $period = 'Sore';
        } else {
            $period = 'Malam';
        }

        $hour12 = $hour > 12 ? $hour - 12 : ($hour === 0 ? 12 : $hour);

        return "{$day} {$month} {$year} - {$hour12}:{$minute} {$period}";
    }
}
