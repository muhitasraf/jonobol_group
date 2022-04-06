<?php

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
return [
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'dev_hr_rupganj',
    'DB_USER' => 'root',
    'DB_PASS' => '',
    /*'DB_USER' => 'moj',
    'DB_PASS' => 'moj@123',*/
    'DB_CHARSET' => 'utf8',
    'DB_COLLATE' => 'utf8_general_ci',
    'DB_PERSISTENT' => [\PDO::ATTR_PERSISTENT=> false]
];