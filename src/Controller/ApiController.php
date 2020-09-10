<?php
namespace Controller;

use App\DB;

class ApiController {
    function getUser($user_email){
        json_response( DB::who($user_email) );
    }

    function getPapers(){
        json_response( 
            array_map(function($paper){
                $paper->hash_tags = json_decode($paper->hash_tags);
                return $paper;
            },DB::fetchAll("SELECT P.*, user_name company_name
                                FROM papers P
                                LEFT JOIN users U ON P.uid = U.id"))
        );
    }
}