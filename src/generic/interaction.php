<?php

namespace hubot\generic;

use hubot\message;
use hubot\generic\driver;
use hubot\bot;

abstract class interaction {
    
    /**
     * Return null or $this (a interaction object)
     * @param message $inputMessage
     * @return type
     */
    public function check(message $inputMessage)
    {
        return null;
    }
    
    public function getOutputMessage(message $inputMessage, bot $bot){
         throw new \Exception('ineraction not implement getOutputMessage function');
    }
    
    public function needReply(){
        return false;
    }
    
}
