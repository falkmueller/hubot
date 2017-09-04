<?php 

return array(
    "config" => array(
       "controller_namespace" => "src\\frontend\\controller"
    ),

    "routes" => array(
            "home" => array(
                "route" => "/", 
                "method" => "GET", 
                "target" => array("controller" => "index", "action" => "index")
            ),
            "bot" => array(
                "route" => "/[:bot][/]?", 
                "method" => "GET|POST", 
                "target" => array("controller" => "index", "action" => "bot")
            ),
            "driver" => array(
                "route" => "/[:bot]/[:driver][/]?", 
                "method" => "GET|POST", 
                "target" => array("controller" => "driver", "action" => "index")
            ),
        )
);

