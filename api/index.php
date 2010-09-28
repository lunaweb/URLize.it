<?php

require 'vendor/limonade/lib/limonade.php';
require '../urlize.php';

# POST /
dispatch_post('/', 'new_urlizisation');

function new_urlizisation()
{
  if (!empty($_POST['dirty_url'])) {
      // retrieve path to urlize in $_POST
      $dirty_url = rtrim(trim(stripslashes(htmlspecialchars($_POST['dirty_url']))));
      
      // Separator : Defaulting to dashes
      $dashes_or_underscores = !empty($_POST['underscores']) ? '_' : '-';

      // TODO: normalize/cleanup/validate data
      $data = array(
        "dirty_url" => $dirty_url,
        "urlized_data" => urlize($dirty_url, true, true, $dashes_or_underscores)
      );
      return json_encode($data); 
  }

}

// GO!
run();