<?php

namespace hubot\generic;

use hubot\message;

abstract class driver {
    
    public function getInputMessage(){
        throw new \Exception('Driver not implement getInput function');
    }
    
    public function send(message $outputMessage){
        throw new \Exception('Driver not implement send function');
    }
    
    public function startSession(message $inputMessage){
        if($inputMessage->sid){
           $sessionFactory = new \hubert\extension\session\factory();
           $sessionManager = $sessionFactory->getSessionManager();
           
           if(!$sessionManager->sessionExists()){
               $sessionManager->setId($inputMessage->sid);
           }
       }
       
       $this->session()->count = $this->session()->count ? $this->session()->count + 1 : 1;
    }
    
    public function isNewCommunication(message $inputMessage){
        return $this->session()->count && $this->session()->count == 1 ? true : false;
    }

    public function session(){
        return hubert()->session(get_class($this));
    }
    
    public function getSid(){
        $sessionFactory = new \hubert\extension\session\factory();
        $sessionManager = $sessionFactory->getSessionManager();
        
        return $sessionManager->getId();
    }
}
