<?php

namespace src\interaction;

use hubot\message;
use hubot\bot;

class notUnderstand extends \hubot\generic\interaction {
    
    public function getOutputMessage(message $inputMessage, bot $bot){
        $outputMessage = new message();
        $outputMessage->text = "I dont understand you. Please ask me other.";
        
        return $outputMessage;
    }
    
}
