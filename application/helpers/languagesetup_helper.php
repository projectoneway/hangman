<?php

function __d($str, $vars = array()) {
  $CI = &get_instance();

  $translateStr = $CI->lang->line($str);

  if ($translateStr == '') {
    return $str;
  } else {

    if (!empty($vars)) {
      $translateStr = vsprintf($translateStr, (array) $vars);
    }
  }

  return $translateStr;
}

?>