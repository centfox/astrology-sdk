<?php
/**
 * (c) Vimal <api@api.prokerala.com>
 *
 * This source file is subject to the MIT license.
 *
 * PHP version 5
 *
 * @category API_SDK
 * @package  Astrology
 * @author   Vimal <api@api.prokerala.com>
 * @license  https://api.prokerala.com/license.txt MIT License
 * @version  GIT: 1.0
 * @link     https://github.com/prokerala/astrology
 * @access   public
 **/
namespace Prokerala\Api\Astrology;

/**
 * Defines
 *
 **/class SunZodiac
{
    public const RASI_MESHA = 0;
    public const RASI_VRISHABHA = 1;
    public const RASI_MITHUNA = 2;
    public const RASI_KARKA = 3;
    public const RASI_SIMHA = 4;
    public const RASI_KANYA = 5;
    public const RASI_TULA = 6;
    public const RASI_VRISCHIKA = 7;
    public const RASI_DHANU = 8;
    public const RASI_MAKARA = 9;
    public const RASI_KUMBHA = 10;
    public const RASI_MEENA = 11;

    public static $arZodiac = ["Mesha", "Vrishabha", "Mithuna", "Karka", "Simha", "Kanya", "Tula", "Vrischika", "Dhanu", "Makara", "Kumbha", "Meena"];

    protected $id;
    protected $name;
    protected $longitude;
    protected $lord;
    /**
     * Init SunZodiac
     *
     * @param array $data SunZodiac details
     **/
    public function __construct($data) 
    {
        $this->id = $data->id;
        $this->name = self::$arZodiac[$data->id];
        $this->longitude = $data->longitude;
        $this->lord = $data->lord;
    }

    /**
     * Function returns the name
     *
     * @return string 
     **/
    public function getName() 
    {
        return $this->name;
    }
    /**
     * Function returns the id
     *
     * @return int 
     **/
    public function getId() 
    {
        return $this->id;
    }

    /**
     * Function returns the starttime
     *
     * @return string in ISO 8601 format 
     **/
    public function getLongitude() 
    {
        return $this->longitude;
    }

    /**
     * Function returns the endtime
     *
     * @return string in ISO 8601 format 
     **/
    public function getLord()
    {
        return $this->lord;
    }

    /**
     * Function returns the list
     *
     * @return array
     **/
    public function getZodiacList()
    {
        return self::$arZodiac;
    }
}