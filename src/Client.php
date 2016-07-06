<?php

namespace credy\api;

use credy\api\helpers\Configurable;

class Client extends Configurable
{
    const API_URL_STAGING = 'http://52.16.186.127/api/';
    const API_URL_PROD = 'https://credy.eu/api/';

    const GENDER_MALE = 'MALE';
    const GENDER_FEMALE = 'FEMALE';

    public static $genders = [
        self::GENDER_MALE,
        self::GENDER_FEMALE
    ];

    const CAR_NO = 'NO';
    const CAR_LEASING = 'LEASING';
    const CAR_YES = 'YES';
    const CAR_BUSINESS = 'BUSINESS';

    public static $cars = [
        self::CAR_NO,
        self::CAR_LEASING,
        self::CAR_YES,
        self::CAR_BUSINESS,
    ];

    const HOUSING_TYPE_RENTED_ROOM = 'RENTED_ROOM';
    const HOUSING_TYPE_RENTED_APARTMENT_OR_HOUSE = 'RENTED_APARTMENT_OR_HOUSE';
    const HOUSING_TYPE_OWN_HOUSE_OR_APARTMENT = 'OWN_HOUSE_OR_APARTMENT';
    const HOUSING_TYPE_WITH_PARENTS = 'WITH_PARENTS';

    public static $housingTypes = [
        self::HOUSING_TYPE_RENTED_ROOM,
        self::HOUSING_TYPE_RENTED_APARTMENT_OR_HOUSE,
        self::HOUSING_TYPE_OWN_HOUSE_OR_APARTMENT,
        self::HOUSING_TYPE_WITH_PARENTS,
    ];

    const MARITAL_STATUS_SINGLE = 'SINGLE';
    const MARITAL_STATUS_DIVORCED = 'DIVORCED';
    const MARITAL_STATUS_MARRIED = 'MARRIED';
    const MARITAL_STATUS_WITH_PARTNER = 'WITH_PARTNER';
    const MARITAL_STATUS_WIDOW = 'WIDOW';

    public static $maritalStatuses = [
        self::MARITAL_STATUS_SINGLE,
        self::MARITAL_STATUS_DIVORCED,
        self::MARITAL_STATUS_MARRIED,
        self::MARITAL_STATUS_WITH_PARTNER,
        self::MARITAL_STATUS_WIDOW
    ];

    const EDUCATION_NO_EDUCATION = 'NO_EDUCATION';
    const EDUCATION_BASIC_SCHOOL = 'BASIC_SCHOOL';
    const EDUCATION_HIGH_SCHOOL = 'HIGH_SCHOOL';
    const EDUCATION_INDUSTRIAL_SCHOOL = 'INDUSTRIAL_SCHOOL';
    const EDUCATION_BACHELOR = 'BACHELOR';
    const EDUCATION_MASTER = 'MASTER';
    const EDUCATION_PHD = 'PHD';

    public static $educations = [
        self::EDUCATION_NO_EDUCATION,
        self::EDUCATION_BASIC_SCHOOL,
        self::EDUCATION_HIGH_SCHOOL,
        self::EDUCATION_INDUSTRIAL_SCHOOL,
        self::EDUCATION_BACHELOR,
        self::EDUCATION_MASTER,
        self::EDUCATION_PHD,
    ];

    const OCCUPATION_EMPLOYED_INDEFINITE_PERIOD = 'EMPLOYED_INDEFINITE_PERIOD';
    const OCCUPATION_EMPLOYED_SPECIFIED_PERIOD = 'EMPLOYED_SPECIFIED_PERIOD';
    const OCCUPATION_WRITTEN_CONTRACT_OR_ORDER = 'WRITTEN_CONTRACT_OR_ORDER';
    const OCCUPATION_ECONOMIC_ACTIVITY = 'ECONOMIC_ACTIVITY';
    const OCCUPATION_UNEMPLOYED = 'UNEMPLOYED';
    const OCCUPATION_STUDENT = 'STUDENT';
    const OCCUPATION_PENSIONER1 = 'PENSIONER1';
    const OCCUPATION_PENSIONER2 = 'PENSIONER2';
    const OCCUPATION_OTHER = 'OTHER';
    const OCCUPATION_MATERNITY_LEAVE = 'MATERNITY_LEAVE';
    const OCCUPATION_BENEFITS = 'BENEFITS';

    public static $occupations = [
        self::OCCUPATION_EMPLOYED_INDEFINITE_PERIOD,
        self::OCCUPATION_EMPLOYED_SPECIFIED_PERIOD,
        self::OCCUPATION_WRITTEN_CONTRACT_OR_ORDER,
        self::OCCUPATION_ECONOMIC_ACTIVITY,
        self::OCCUPATION_UNEMPLOYED,
        self::OCCUPATION_STUDENT,
        self::OCCUPATION_PENSIONER1,
        self::OCCUPATION_PENSIONER2,
        self::OCCUPATION_OTHER,
        self::OCCUPATION_MATERNITY_LEAVE,
        self::OCCUPATION_BENEFITS,
    ];

    const INDUSTRY_CONSTRUCTION_MANUFACTURING = 'CONSTRUCTION_MANUFACTURING';
    const INDUSTRY_MILITARY = 'MILITARY';
    const INDUSTRY_HEALTHCARE = 'HEALTHCARE';
    const INDUSTRY_BANKING_INSURANCE = 'BANKING_INSURANCE';
    const INDUSTRY_EDUCATION = 'EDUCATION';
    const INDUSTRY_CIVIL_SERVICE = 'CIVIL_SERVICE';
    const INDUSTRY_RETAIL = 'RETAIL';
    const INDUSTRY_UTILITIES_TELECOM = 'UTILITIES_TELECOM';
    const INDUSTRY_HOTEL_RESTAURANT_AND_LEISURE = 'HOTEL_RESTAURANT_AND_LEISURE';
    const INDUSTRY_OTHER_OFFICE_BASED = 'OTHER_OFFICE_BASED';
    const INDUSTRY_OTHER_NON_OFFICE_BASED = 'OTHER_NON_OFFICE_BASED';

    public static $industries = [
        self::INDUSTRY_CONSTRUCTION_MANUFACTURING,
        self::INDUSTRY_MILITARY,
        self::INDUSTRY_HEALTHCARE,
        self::INDUSTRY_BANKING_INSURANCE,
        self::INDUSTRY_EDUCATION,
        self::INDUSTRY_CIVIL_SERVICE,
        self::INDUSTRY_RETAIL,
        self::INDUSTRY_UTILITIES_TELECOM,
        self::INDUSTRY_HOTEL_RESTAURANT_AND_LEISURE,
        self::INDUSTRY_OTHER_OFFICE_BASED,
        self::INDUSTRY_OTHER_NON_OFFICE_BASED,
    ];

    const REMUNERATION_FREQUENCY_WEEKLY = 'WEEKLY';
    const REMUNERATION_FREQUENCY_FORTNIGHTLY = 'FORTNIGHTLY';
    const REMUNERATION_FREQUENCY_FOUR_WEEKLY = 'FOUR_WEEKLY';
    const REMUNERATION_FREQUENCY_MONTHLY = 'MONTHLY';

    public static $remunFrequencies = [
        self::REMUNERATION_FREQUENCY_WEEKLY,
        self::REMUNERATION_FREQUENCY_FORTNIGHTLY,
        self::REMUNERATION_FREQUENCY_FOUR_WEEKLY,
        self::REMUNERATION_FREQUENCY_MONTHLY,
    ];

    const PHONE_PLAN_PREPAID = 'PREPAID';
    const PHONE_PLAN_CONTRACT = 'CONTRACT';

    public static $phonePlans = [
        self::PHONE_PLAN_PREPAID,
        self::PHONE_PLAN_CONTRACT,
    ];


    public $apiKey;
    public $apiUrl = self::API_URL_PROD;
    public $useStaging = false;
    public $guzzleOptions = [];

    protected $client;

    public function init()
    {
        if (empty($this->apiKey)) {
            throw new \Exception('Please set apiKey');
        }
        if ($this->useStaging) {
            $this->apiUrl = self::API_URL_STAGING;
        }

        $this->guzzleOptions['base_uri'] = $this->apiUrl;
    }

    public function sendLead(array $data, $returnArray = false)
    {
        $response = $this->getClient()->post('/lead', [
            'json' => $this->authenticateRequest($data)
        ]);
        return json_decode($response->getBody(), $returnArray);
    }

    public function getLeadStatus($leadId, $returnArray = false)
    {
        $response = $this->getClient()->get('/iframe/check-lead-status', [
            'query' => [
                'leadId' => $leadId,
            ]
        ]);
        return json_decode($response->getBody(), $returnArray);
    }

    public function waitAnswer($leadId, $interval = 5)
    {
        while (true) {
            $response = $this->getLeadStatus($leadId);
            if (in_array($response->status, ['accepted', 'interaction'])) {
                return $response;
            }
            sleep($interval);
        }
    }

    protected function getClient()
    {
        if (!$this->client) {
            $this->client = new \GuzzleHttp\Client($this->guzzleOptions);
        }
        return $this->client;
    }

    protected function authenticateRequest(array $data)
    {
        $time = time();
        $request = [
            'lead' => $data,
            'timestamp' => $time,
            'hash' => $this->generateMac($data, $time),
            'api_key' => $this->apiKey,
        ];

        return $request;
    }

    protected function generateMac(array $data, $time)
    {
        $mac = '';
        foreach ($data as $key => $val) {
            if (is_bool($val)) {
                $val = !$val ? 'false' : 'true';
            }
            $mac .= $key . $val;
        }

        return sha1($mac . $this->apiKey . $time);
    }
}
