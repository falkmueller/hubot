<?php

return array(
  "config" => array(
        "bootstrap" => src\bootstrap::class,
        "basedir" => dirname(__dir__),
        "display_errors" => false,    
  ) ,
    
  "namespace" => array(
      "src" => dirname(__dir__)."/src/"
  )
);

