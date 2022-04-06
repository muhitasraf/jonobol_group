<?php
    
    namespace App\Controllers;
    class HomeController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index(){
            echo "Welcome to you at HomeController@index.";
        }
        public function test($params){
            //get parameter
            var_dump($params);
            
            //get query string
            var_dump($_GET['ids']);
            echo "Welcome to you at HomeController@test";
        }
        
    }