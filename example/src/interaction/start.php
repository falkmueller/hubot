<?php

namespace src\interaction;

use hubot\message;
use hubot\generic\driver;
use hubot\bot;

class start extends \hubot\generic\interaction {
    
    protected $_needReply = false;
    
    public function check(message $inputMessage)
    {
        
        if ($inputMessage->text == 'BOT_START'){
             return $this;
        }
        
        return null;
    }
    
    public function getOutputMessage(message $inputMessage, bot $bot){
        $outputMessage = new message();
        
        if(empty($inputMessage->text) || $inputMessage->text == "BOT_START"){
            $outputMessage->text = "Hello, my name is {$bot->values['name']}. Waht is your name?";
            $bot->driver->session()->user_name = null;
            $this->_needReply = true;
        } elseif(empty($bot->driver->session()->user_name)) {
            $outputMessage->text = "Hello, {$inputMessage->text}. Where are you from?";
            $bot->driver->session()->user_name = $inputMessage->text;
            $bot->driver->session()->user_place = null;
            $this->_needReply = true;
        } elseif(empty($bot->driver->session()->user_place)) {
            $bot->driver->session()->user_place = $inputMessage->text;
            $outputMessage->text = "Nice. Ask my for weather.";
        }
        
        
        return $outputMessage;
    }
    
    public function needReply(){
        return $this->_needReply;
    }
    
}
