<?php

require 'vendor/limonade/lib/limonade.php';
require '../urilze.php';

# POST /
dispatch_post('/', 'new_urlizisation');

function new_urlizisation()
{
  if (!empty($_POST['dirty_url'])) {
      // retrieve path to urlize in $_POST
      $dirty_url = rtrim(trim(stripslashes($_POST['dirty_url'])));

      // TODO: normalize/cleanup/validate data
      $data = array(
        "dirty_url" => $dirty_url,
        "urlized_data" => file_adresse($dirty_url)
      );
      return json_encode($data); 
  }

}

// GO!
run();