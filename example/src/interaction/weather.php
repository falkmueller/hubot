<?php

namespace src\interaction;

use hubot\message;
use hubot\bot;

class weather extends \hubot\generic\interaction {
    
    protected $_needReply = false;
    
    public function check(message $inputMessage)
    {
          if (preg_match('/weather/',$inputMessage->text)){
             return $this;
        }
        
        return null;
    }
    
    public function getOutputMessage(message $inputMessage, bot $bot){
        $outputMessage = new message();
        
         if($bot->driver->session()->wheater_ask_place) {
            $bot->driver->session()->user_place = $inputMessage->text;
            $bot->driver->session()->wheater_ask_place = null;
        } elseif(empty($bot->driver->session()->user_place)){
            $outputMessage->text = "Where are you from?";
            $bot->driver->session()->wheater_ask_place = true;
            $this->_needReply = true;
        }
        
        if($bot->driver->session()->user_place){
            $place_response = $this->exec("https://www.metaweather.com/api/location/search/?query=".urlencode($bot->driver->session()->user_place));
            
            if($place_response && is_array($place_response) && count($place_response) > 0){
                $place_id = $place_response[0]["woeid"];
                
                $weather_response = $this->exec("https://www.metaweather.com/api/location/{$place_id}/");
                
                if($weather_response && is_array($weather_response) && isset($weather_response["consolidated_weather"][0])){
                    $outputMessage->text = $weather_response["consolidated_weather"][0]["weather_state_name"].' by '.intval($weather_response["consolidated_weather"][0]["the_temp"]).'°C';
                } else {
                    $outputMessage->text = "Sorry, i Dont know it."; 
                }
                
                
            } else {
                $outputMessage->text = "Is your place right? Where are you from?";
                $bot->driver->session()->wheater_ask_place = true;
                $bot->driver->session()->user_place = null;
                $this->_needReply = true;
            }
            
        }
        
        
        return $outputMessage;
    }
    
    public function needReply(){
        return $this->_needReply;
    }
    
    private function exec($url){
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }
}

