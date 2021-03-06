<?php
/**
 * (c) Ennexa <api@prokerala.com>
 *
 * This source file is subject to the MIT license.
 *
 * PHP version 5
 *
 * @category API_SDK
 * @author   Ennexa <api@prokerala.com>
 * @license  https://api.prokerala.com/license.txt MIT License
 * @version  GIT: 1.0
 * @see     https://github.com/prokerala/astrology
 */

namespace Prokerala\Api\Astrology\Service;

use Prokerala\Api\Astrology\AstroTrait;
use Prokerala\Api\Astrology\Profile;
use Prokerala\Common\Api\Client;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;

/**
 * Defines the HoroscopeMatch
 *
 * @property \stdClass result
 */
class HoroscopeMatch
{
    use AstroTrait;

    protected $apiClient;
    protected $slug = 'horoscope-matching';
    protected $ayanamsa = 1;
    public $result;
    public $input;

    /**
     * Function returns HoroscopeMatch details
     *
     * @param Client $client api client object
     */
    public function __construct(Client $client)
    {
        $this->apiClient = $client;
        $this->result = new \stdClass();
    }

    /**
     * Function returns HoroscopeMatch details
     *
     * @param Profile $bride_profile
     * @param Profile $groom_profile
     * @param $system
     * @throws QuotaExceededException
     * @throws RateLimitExceededException
     * @return HoroscopeMatch
     */
    public function process(Profile $bride_profile, Profile $groom_profile, $system)
    {
        $arParameter = [
            'bride_dob' => $bride_profile->getDateTime()->format('Y-m-d\\TH:i:s\\Z'),
            'bride_coordinates' => $bride_profile->getLocation()->getCoordinates(),
            'bridegroom_dob' => $groom_profile->getDateTime()->format('Y-m-d\\TH:i:s\\Z'),
            'bridegroom_coordinates' => $groom_profile->getLocation()->getCoordinates(),
            'system' => $system,
            'ayanamsa' => $this->ayanamsa,
        ];
        $result = $this->apiClient->doGet($this->slug, $arParameter);

        $this->input = $result->request;

        foreach ($result->response as $res_key => $res_value) {
            $this->result->{$res_key} = new \stdClass();
            if (in_array($res_key, [1 => 'bride_details', 'bridegroom_details'])) {
                foreach ($res_value as $res_key1 => $res_value1) {
                    $class = $this->getClassName($res_key1, true);
                    if ($class) {
                        if ('planet_positions' == $res_key1) {
                            foreach ($res_value1 as $planet_positions) {
                                $planet = new $class($planet_positions);
                                $this->result->{$res_key}->{$res_key1}[$planet->getId()] = $planet;
                            }
                        } else {
                            $this->result->{$res_key}->{$res_key1} = new $class($res_value1);
                        }
                    } else {
                        $this->result->{$res_key}->{$res_key1} = $res_value1;
                    }
                }
            } else {
                $this->result->{$res_key} = $res_value;
            }
        }

        return $this;
    }

    /**
     * Function returns panchang details
     *
     * @param object $client client class object
     */
    public function setApiClient(Client $client)
    {
        $this->apiClient = $client;
    }

    /**
     * Function returns panchang details
     *
     * @param object $client   client class object
     * @param mixed  $ayanamsa
     */
    public function setAyanamsa($ayanamsa)
    {
        $this->ayanamsa = $ayanamsa;
    }

    /**
     * Function returns vasara details
     *
     * @return object
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Function returns input details
     *
     * @return object
     */
    public function getInput()
    {
        return $this->input;
    }
}
