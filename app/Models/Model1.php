<?php

/*namespace App\Models;

use Vendor\LessQL\Database1;

class Model1 extends Database1 {

    protected $pdo;
    public static $pdo_instance;
    public function __construct() {
        $db = require App.'config/db_sql_sqerver.php';
        $dsn = $db['DB_TYPE'].':server='.$db['DB_HOST'].'; Database='.$db['DB_NAME'];
        try {
            if (!isset(self::$pdo_instance)) {
                self::$pdo_instance = new \PDO($dsn, $db['DB_USER'], $db['DB_PASS'], $db['DB_PERSISTENT']);
            }
            $this->pdo = self::$pdo_instance;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            exit("Error:".$e->getMessage(). ". Code:".$e->getCode());
        }
    }
}*/
