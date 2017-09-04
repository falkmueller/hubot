<?php

namespace hubot;

use hubot\generic\driver;
use hubot\generic\interaction;
use hubot\message;

class bot {
    
    protected $config;
    protected $interactions;
    public $values;
    public $driver;

    public function __construct($data){
        $this->config = $data["config"];
        $this->interactions = $data["interactions"];
        $this->values = $data["values"];
        
    }
    
    public function loadDriver($driverName){
        $driver_namespace = $this->config["driver_namespace"];
        $driverClass = "{$driver_namespace}\\{$driverName}";
        
        if(!class_exists($driverClass)){
             throw new \Exception('Driver not found');
        }
        
        $driver = new $driverClass();
        if(!($driver instanceof driver)){
             throw new \Exception('Driver not implements inherits driver class');
        }
        
        $this->driver = $driver;
    }


    public function handle(){
       $inputMessage = $this->driver->getInputMessage();
       if(!$inputMessage || !($inputMessage instanceof message)){
           throw new \Exception('input message not implements message class');
       }
       
       $this->driver->startSession($inputMessage);
       
       $interaction = $this->getInteraction($inputMessage);
       if(!$interaction || !($interaction instanceof interaction)){
           print_r($interaction); exit;
           throw new \Exception('interaction not implements interaction class');
       }
       
       $outputMessage = $interaction->getOutputMessage($inputMessage, $this);
       if(!$outputMessage || !($outputMessage instanceof message)){
           throw new \Exception('output message not implements message class');
       }
       if($interaction->needReply()){
           $this->driver->session()->waitOfReply = get_class($interaction);
       }
       
       $outputMessage->sid = $this->driver->getSid();
       
       if(@hubert()->config()->bots["log"]){
           $logger = \hubert\extension\logger\factory::getLogger(hubert()->config()->logger["path"], 'bot-'.date("Y-m-d").'-'.$outputMessage->sid.'.log', \Monolog\Logger::INFO);
           $logger->info($inputMessage->text, ["from" => "user"]);
           $logger->info($outputMessage->text, ["from" => "bot"]);
       }
       
       $this->driver->send($outputMessage);
    }
    
    protected function getInteraction(message $inputMessage){
        $interaction_namespace = $this->config["interaction_namespace"];
        
        /*Start interaction*/
        if($this->driver->isNewCommunication($inputMessage) && isset($this->config["start_interaction"])){
            
            $StartInteractionName = $this->config["start_interaction"];
            $interactionClass = "{$interaction_namespace}\\{$StartInteractionName}";
            if(class_exists($interactionClass) && is_subclass_of($interactionClass, "hubot\\generic\\interaction")){
                return new $interactionClass();
            }
        }
       
        if ($this->driver->session()->waitOfReply){
            $replyClass = $this->driver->session()->waitOfReply;
            $this->driver->session()->waitOfReply = null;
            return new $replyClass();
        }
        
        /*match handling*/
        foreach ($this->interactions as $interacionName){
            $interactionClass = "{$interaction_namespace}\\{$interacionName}";
            if(!class_exists($interactionClass) || !is_subclass_of($interactionClass, "hubot\\generic\\interaction")){
                continue;
            }
            
            $interaction = new $interactionClass();
            if($interaction->check($inputMessage)){
                return $interaction;
            }
        }

       
        /*No Match default handling*/
        if(empty($this->config["noMatch_interaction"])){
           return null; 
        }
        
        $noMatchInteractionName = $this->config["noMatch_interaction"];
        $interactionClass = "{$interaction_namespace}\\{$noMatchInteractionName}";

        if(!class_exists($interactionClass) || !is_subclass_of($interactionClass, "hubot\\generic\\interaction")){
            return null;
        }

        return new $interactionClass();
    }
    
}
