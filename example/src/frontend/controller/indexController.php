<?php

namespace src\frontend\controller;


class indexController extends \hubert\generic\controller {
    
    public function indexAction(){
        $bot_url = hubert()->router->get("bot", ["bot" => hubert()->config()->bots["default_bot"]]);
        return $this->responseRedirect($bot_url);
    }
    
    public function botAction($args){
        
        if(!isset(hubert()->config()->bot[$args["bot"]])){
            return $this->indexAction();
        }
        
        $bot = hubert()->config()->bot[$args["bot"]];
        $driver_url = hubert()->router->get("driver", ["bot" => $args["bot"], "driver" => "web"]);
        
        return $this->responseTemplate("bot", ["bot_id" => $args["bot"], "bot" => $bot, "driver_url" => $driver_url]);
    }
    
}
    
