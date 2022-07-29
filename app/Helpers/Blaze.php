<?php

namespace App\Helpers;

use Carbon\Carbon;
use Mockery\Exception;

class Blaze
{
    private $apilink;

    public function __construct()
    {
        $this->apilink = "https://api-v2.blaze.com/roulette_games/recent";
    }

    public function getRecentRolls()
    {

        try {

            $response = file_get_contents($this->apilink);

        } catch (Exception $e){

            $jsonError = $e;

            $this->getRecentRolls();

        }


        $jsonResponse = json_decode($response);

        return $jsonResponse;

    }

    public function getColor($color)
    {

        switch($color){

            case 0:

                return "Branco";

            case 1:

                return "Vermelho";

            case 2:

                return "Preto";

        }

    }

    public static function getDateTime($date, $seconds = null)
    {
        $timeString = ($seconds == 1 ? 'Y-m-d H:i:s' : 'Y-m-d H:i');

        $dateFormat = Carbon::parse($date)->format($timeString);

        return $dateFormat;

    }

    public static function getDateTimeNext($date, $seconds = null)
    {
        $timeString = ($seconds == 1 ? 'Y-m-d H:i:s' : 'Y-m-d H:i');

        $dateFormat = Carbon::parse($date)->addMinute()->format($timeString);

        return $dateFormat;

    }

    public static function getDateTimeZone($date, $baseTimeZone = 'UTC', $newTimeZone = 'America/Sao_Paulo')
    {

        $dateFormat = Carbon::parse($date, $baseTimeZone)->setTimezone($newTimeZone)->format('Y-m-d H:i:s');

        return $dateFormat;

    }

}
