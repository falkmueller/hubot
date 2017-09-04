<?php

namespace hubot\driver;

use hubot\message;

class web extends \hubot\generic\driver {
    
    public function getInputMessage(){
        $input = json_decode(file_get_contents('php://input'), true);
        
        $inputMessage = new message();
        if($input && is_array($input) && isset($input["text"])){
           $inputMessage->text = $input["text"];
        } else {
           $inputMessage->text = file_get_contents('php://input');
        }
        
        return $inputMessage;
    }
    
    public function send(message $message){
        echo json_encode($message);
    }
    
}
