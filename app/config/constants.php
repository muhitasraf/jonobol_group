<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Constants
    |--------------------------------------------------------------------------
    |
    | This file is for storing the constants for this application
    |
    */
    'saluation' => [
        '' => '-- Select --',
        1=> 'Mr.',
        2=> 'Mrs.'
    ],
    'gender' => [
        '' => '-- Select --',
        1 => 'Male',
        2 => 'Female'
    ],

    'religion' => [
        '' => '-- Select --',
        1 => 'Islam',
        2 => 'Hindu',
        3 => 'Buddhism',
        4 => 'Christianity',
        5 => 'Secular',
        6 => 'Other'
    ],

    'maritial' => [
        '' => '-- Select --',
        0 =>'',
        1 => 'Unmarried',
        2 => 'Married',
        3 => 'Single',
        4 => 'Divorced',
        5 => 'Widow'
    ],

    'blood' => [
        'en' => [
            '' => '-- Select --',
            0 =>'',
            1 => 'A+',
            2 => 'O+',
            3 => 'B+',
            4 => 'AB+',
            5 => 'A-',
            6 => 'O-',
            7 => 'B-',
            8 => 'AB-'
        ],
        'bn' => [
            '' => '-- Select --',
            0 =>'',
            1 => 'এ+',
            2 => 'ও+',
            3 => 'বি+',
            4 => 'এবি+',
            5 => 'এ-',
            6 => 'ও-',
            7 => 'বি-',
            8 => 'এবি-'
        ]
    ],

    'employment_nature' => [
        'en' => [
            '' => '-- Select --',
            1 => 'Permanent',
            2 => 'Contractual',
            3 => 'Trainee',
            4 => 'Temporary',
            5 => 'Owner',
            6 => 'Part Time'
        ],
        'bn' => [
            '' => '-- Select --',
            1 => 'স্থায়ী',
            2 => 'চুক্তিভিত্তিক',
            3 => 'শিক্ষানবিস',
            4 => 'অস্থায়ী',
            5 => 'মালিক',
            6 => 'খন্ডকালীন'
        ]
    ],

    'employee_type' => [
        '' => '-- Select --',
            1 => 'Permanent',
            2 => 'Provisional',
            3 => 'Daily',
            4 => 'Temporary',
    ],

    'status' => [
        0 => 'Active',
        1 => 'Inactive'
    ],
    'provision_period'=>[
        '0' => '-- Select --',
        '3' => '3 Months',
        '6' => '6 Months',
        '9' => '9 Months',
        '12' => '12 Months',
    ],
    'training_period'=>[
        '0' => '-- Select --',
        '3' => '3 Months',
        '6' => '6 Months',
        '9' => '9 Months',
        '12' => '12 Months',
    ],
    'posting_place'=>[        
        '' => '-- Select --',
        '1' => 'Head Office',
        '2' => 'Factory',
    ]
];
