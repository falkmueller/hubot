<?php

return array(
  "factories" => array(
        "session" => array(hubert\extension\session\factory::class, 'get'),
   ),
    
  "config" => array(
       "session" => array(
            'remember_me_seconds' => 60 * 60,
            'validate_user_agend' => false,
            'validate_remote_addr' => false,
            'cookie_httponly' => true
        )
  ) ,
);


