<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curl extends Model
{
    //


    public static function createAuthString() {
        $apiKey = '0d5bda1e93e0b13a1367a581370092c5';
        $authToken = '721892b2c44086b1a347619168d60f1e4c2a4010fc27332d379e10bbdcdadd0c';
        $authString = "?key=". $apiKey ."&token=" . $authToken;
        return $authString;
    }

    // Reusable Curl function, put in url and get data
    public static function useCurl($url){
        
        // Create curl instance 
        $ch = curl_init();  
        
        //Returns the contents of the page
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 5); 
        
        // Add the target URL to the variable
        curl_setopt($ch, CURLOPT_URL, $url); 
        
        // Results
        $result = curl_exec($ch); 

        // Encode the results
        $data = json_decode($result);  
        
        // Return encoded results
        return $data;

    }

    public static function getBoards(){
        $authString = Curl::createAuthString();
        $url = 'https://api.trello.com/1/members/me/boards' . $authString;

        $data = Curl::useCurl($url);
        return $data;
    }

    public static function getItem($board_id, $item){
        $authString = Curl::createAuthString();
        $url = 'https://api.trello.com/1/boards/' . $board_id . '/' . $item . '/' . $authString;
        
        $data = Curl::useCurl($url);
        return $data;
    }


}
