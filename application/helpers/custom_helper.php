<?php


function getFileModifiedDateTime($file) {

  if (file_exists($file)) {
    return date("YmdHis", filemtime($file));
  } else {
    echo $file . "=====NOT FOUND"; // die;
  }
}


function pr($array = array()) {
  echo "<pre>";
  print_r($array);
  echo "</pre>";
}

function br2nl($text) {
  return preg_replace('/<br\\s*?\/??>/i', '', $text);
}

/**
 * @return string
 */
function getCurrentUrl($remove_param = '') {
  if (isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on") {
    $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
  } else {
    $pageURL = "http://";
  }

  if ($_SERVER["SERVER_PORT"] != "80") {
    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
  } else {
    $pageURL .= $_SERVER["SERVER_NAME"];
  }


  if ($_SERVER['REQUEST_URI'] != '') {
    if ($_SERVER['QUERY_STRING'] != '') {
      $pageURL .= str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
    } else {
      $pageURL .= $_SERVER['REQUEST_URI'];
    }
  }

  if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
    $query_string = trim(strip_tags($_SERVER['QUERY_STRING']));

    if (isset($query_string) && !empty($query_string)) {
      $parse_url = parse_url($query_string);

      $parse_str = parse_str(trim($parse_url['path']), $get_query_param);

      if (isset($get_query_param) && !empty($get_query_param)) {

        if ($remove_param != '') {
          if (array_key_exists($remove_param, $get_query_param)) {
            unset($get_query_param[$remove_param]);
          }
        }
        if (isset($get_query_param) && !empty($get_query_param)) {
          $pageURL .= '?' . http_build_query($get_query_param);
        }
      }
    }
  }


  return $pageURL;
}

/**
 * @param $url
 * @return string
 */
function addhttp($url) {
  if ($url != '') {
    return (substr($url, 0, 7) == 'http://' || substr($url, 0, 8) == 'https://') ? $url : 'http://' . $url;
  } else {
    return '';
  }
}

/* * ** get domain name from url
 * @param $url
 * @return mixed
 */

function getDomainName($url) {

  $matches = parse_url($url);

  if (isset($matches['host'])) {

    $domain = $matches['host'];

    $domain = str_replace(array('www.'), '', $domain);

    return $domain;
  }

  return $url;
}

/*
  Function name :SecurePostData()
  Parameter : string
  Return : secure string
  Use : all input post or get data wil be purify for sql injection and cross scripting
 */

/**
 * @param string $string
 * @return array|mixed|string
 */
function securePostData($string = '') {
  $CI = &get_instance();
  $string = html_purify($CI->db->escape_str($string));
  $string = preg_replace('/(\r\n\r\n)$/', '', $string);
  $string = preg_replace("/\n+/", "", $string);
  $string = str_replace("\n", "<br>", $string);
  $string = str_replace("\r", "", $string);
  // $string = strip_slashes($string);
  $string = str_replace(PHP_EOL, null, $string);

  return $string;
}

/*
  Function name :secureShowData()
  Parameter : string
  Return : secure string
  Use : all input post or get data wil be purify for sql injection and cross scripting
 */

/**
 * @param string $string
 * @return string
 */
function secureShowData($string = '') {
  $string = nl2br($string);
  $string = stripslashes($string);

  return $string;
}

/*
  Function name :first_and_last_day()
  Parameter : date
  Return : return week_first_day and week_last_day fo week

 */

/**
 * @return array
 */
function timeZoneList() {
  $zones_array = array();
  $timestamp = time();
  foreach (timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
    $zones_array[$key]['zone'] = $zone;
    $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
  }
  return $zones_array;
}

/**
 * generate random code
 *
 * @return    string
 */
function randomAlphaNumericCode() {

  $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";

  $pass = array();
  for ($i = 0; $i < 12; $i++) {
    $n = rand(0, strlen($alphabet) - 1); //use strlen instead of count
    $pass[$i] = $alphabet[$n];
  }
  return implode($pass); //turn the array into a string
}

/**
 * @param int $length
 * @return string
 */
function getRandomCode($length = 12) {

  $code = '';
  //Ascii Code for number, lowercase, uppercase and special characters
  $no = range(48, 57);
  $lo = range(97, 122);
  $up = range(65, 90);
  //exclude character I, l, 1, 0, O
  $eno = array(48, 49);
  $elo = array(108);
  $eup = array(73, 79);
  $no = array_diff($no, $eno);
  $lo = array_diff($lo, $elo);
  $up = array_diff($up, $eup);
  $chr = array_merge($no, $lo, $up);
  for ($i = 1; $i <= $length; $i++) {
    $code .= chr($chr[rand(0, count($chr) - 1)]);
  }
  return $code;
}

/**
 * @param DateTime $date A given date
 * @internal param int $firstDay 0-6, Sun-Sat respectively
 * @return DateTime
 */
function getFirstDayOfWeek($date) {
  $day_of_week = date('N', strtotime($date));
  $week_first_day = date('Y-m-d', strtotime($date . " - " . ($day_of_week - 1) . " days"));
  return $week_first_day;
}

/**
 * @param $date
 * @return bool|string
 */
function getLastDayOfWeek($date) {

  $day_of_week = date('N', strtotime($date));
  $week_last_day = date('Y-m-d', strtotime($date . " + " . (7 - $day_of_week) . " days"));
  return $week_last_day;
}

/* * ** create seo friendly url
 * var string $text
 * @param $text
 * @return mixed|string
 */

function cleanUrl($text) {
  $text = strtolower($text);
  $code_entities_match = array('&quot;', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '', ';', "'", ',', '.', '_', '/', '*', '+', '~', '`', '=', ' ', '---', '--', '--', '�');
  $code_entities_replace = array('', '-', '-', '', '', '', '-', '-', '', '', '', '', '', '', '', '-', '', '', '', '', '', '', '', '', '', '-', '', '-', '-', '', '', '', '', '', '-', '-', '-', '-');
  $text = str_replace($code_entities_match, $code_entities_replace, $text);
  return $text;
}

/* * ******get original client ip
 * * return ip string
 * * */

function getRealIP() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}




?>
