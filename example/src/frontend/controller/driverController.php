<?php

namespace src\frontend\controller;


class driverController extends \hubert\generic\controller {
    
    public function indexAction($args){
        $botName = $args["bot"];
        $driverName = $args["driver"];
        
        if(!isset(hubert()->config()->bot[$args["bot"]])){
             throw new \Exception('bot ot found');
        }
        
        $botClass = hubert()->config()->bots["botClass"];
        $bot = new $botClass(hubert()->config()->bot[$args["bot"]]);
        
        $bot->loadDriver($driverName);
        $bot->handle();
    }
    
}