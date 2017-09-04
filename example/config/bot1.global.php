<?php
return array(
   "config" => array(
       "bot" => array(
           "bot1" => array(
               "config" => array(
                   "driver_namespace" => "src\\driver",
                    "interaction_namespace" => "src\\interaction",
                    "start_interaction" => "start",
                    "noMatch_interaction" => "notUnderstand",
                ),
               
               "values" => array(
                   "name" => "Hubot",
                   "from" => "the internet",
                   "age" => "21"
               ),
               
               "interactions" => array(
                   "weather",
                   "start"
               )
           ),
       )
   ),
);

