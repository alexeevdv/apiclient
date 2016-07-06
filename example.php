<?php

$client = new Client([
    'useStaging' => true,   // remove or set false to use production server
    'apiKey' => '',         // insert provided api key here
]);

// regarding required fields and validations please refer to api doc
$response = $client->sendLead([
    'first_name'                     => 'Test',
    'last_name'                      => 'Test',
    'loan_sum'                       => 600,
    'loan_period'                    => 30,
    'phone'                          => '123456789',
    'email'                          => 'test123@mailinator.com',
    'bank_account_number'            => 'ES4121908330288997950070',
    'personal_id'                    => '45483947K',
    'birth_date'                     => '1990-05-01',
    'gender'                         => Client::GENDER_MALE,
    'education'                      => Client::EDUCATION_BASIC_SCHOOL,
    'marital_status'                 => Client::MARITAL_STATUS_MARRIED,
    'dependant_count'                => 3,
    'street'                         => 'Test st',
    'house_number'                   => '50',
    'city'                           => 'Madrid',
    'postal_index'                   => '12345',
    'housing_type'                   => Client::HOUSING_TYPE_RENTED_ROOM,
    'housing_type_lived_months'      => '2',
    'housing_type_lived_years'       => '1',
    'occupation'                     => Client::OCCUPATION_OTHER,
    'industry'                       => Client::INDUSTRY_MILITARY,
    'employer'                       => 'Credy',
    'employer_phone'                 => '123456789',
    'current_employment_months'      => '11',
    'current_employment_years'       => '2',
    'neto_income'                    => 1000,
    'monthly_expenses'               => 500,
    'remuneration_frequency'         => Client::REMUNERATION_FREQUENCY_MONTHLY,
    'remuneration_deadline'          => '2016-09-01',
    'ip_address'                     => '127.0.0.1',
    'agree_electronic_services'      => '1',
    'agree_personal_data_protection' => '1',
    'agree_data_sharing'             => '1',
    'lives_at_registered_address'    => '1',
    'nationality'                    => 'Spain',
    'bad_credit_history'             => 0,
]);

if ($response->status == 'under_investigation') {
    // all good
    echo 'sent!';
} else {
    // something went wrong
    var_dump($response);
}
