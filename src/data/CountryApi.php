<?php

namespace App\data;

class CountryApi
{
    private const COUNTRY_FILENAME = __DIR__ . "/countries.json";
    private const STATE_FILENAME = __DIR__ . "/states.json";
    private const CITY_FILENAME = __DIR__ . "/cities.json";

    public static function getCountries()
    {
        $JSONFile = fopen(self::COUNTRY_FILENAME, "r") or die("Unable to open file! " . self::COUNTRY_FILENAME);
        $data = fread($JSONFile, filesize(self::COUNTRY_FILENAME));
        fclose($JSONFile);
        return $data;
    }

    public static function getStates()
    {
        $JSONFile = fopen(self::STATE_FILENAME, "r") or die("Unable to open file! " . self::STATE_FILENAME);
        $data = fread($JSONFile, filesize(self::STATE_FILENAME));
        fclose($JSONFile);
        return $data;
    }

    public static function getCities()
    {
        $JSONFile = fopen(self::CITY_FILENAME, "r") or die("Unable to open file! " . self::CITY_FILENAME);
        $data = fread($JSONFile, filesize(self::CITY_FILENAME));
        fclose($JSONFile);
        return $data;
    }
}
