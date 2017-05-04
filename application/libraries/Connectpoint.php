<?php

class Connectpoint {

  // Connection url for Web service
  public $connectionUrl = "";
  //Connection Username
  public $connectionUsername = "";
  //Connection Password
  public $connectionPassword = "";
  // Connection method to Post
  public $connectionMethod = "POST";
  //Check the Session existing or not
  public $connectionSession = "";
  public $authenticationEnable = false;
  public $logApiEnable = false;

  public function __construct($config = array()) {

    $this->ci = &get_instance();

    if (isset($config['connectionUrl']) && !empty($config['connectionUrl'])) {
      $this->connectionUrl = trim($config['connectionUrl']);
    } elseif (trim($this->ci->config->item('point.connectionUrl')) != '') {
      $this->connectionUrl = trim($this->ci->config->item('point.connectionUrl'));
    }

    if (isset($config['connectionUsername']) && !empty($config['connectionUsername'])) {
      $this->connectionUsername = trim($config['connectionUsername']);
    } elseif (trim($this->ci->config->item('point.connectionUsername')) != '') {
      $this->connectionUsername = trim($this->ci->config->item('point.connectionUsername'));
    }

    if (isset($config['connectionPassword']) && !empty($config['connectionPassword'])) {
      $this->connectionPassword = trim($config['connectionPassword']);
    } elseif (trim($this->ci->config->item('point.connectionPassword')) != '') {
      $this->connectionPassword = trim($this->ci->config->item('point.connectionPassword'));
    }

    if (isset($config['connectionMethod']) && !empty($config['connectionMethod'])) {
      $this->connectionMethod = trim($config['connectionMethod']);
    }

    if (isset($config['authenticationEnable'])) {
      $this->authenticationEnable = $config['authenticationEnable'];
    } elseif ($this->ci->config->item('point.authenticationEnable') === true) {
      $this->authenticationEnable = true;
    }

    if (isset($_SESSION['connectionSession']) && !empty($_SESSION['connectionSession'])) {
      $this->connectionSession = $_SESSION['connectionSession'];
    }

    if (isset($config['logApiEnable'])) {
      $this->logApiEnable = $config['logApiEnable'];
    } elseif ($this->ci->config->item('point.logApiEnable') === true) {
      $this->logApiEnable = true;
    }
  }

  /**
   * login Function
   *
   * Function for Login into the Web-services
   * Fetch the key for calling action in web services
   */
  function login() {
    $actioncall = "set_login_api_call_default";

    $webServiceUrl = $this->connectionUrl . $actioncall;

    // add additional parameter required for login like timezone, location, language
    $post_parameters = array(
        "userName" => $this->connectionUsername,
        "password" => $this->connectionPassword
    );

    $wsdata = $this->CallAPI($this->connectionMethod, $webServiceUrl, $post_parameters);
    //pr($wsdata); die();

    if ($wsdata['code'] != 0) {
      $wsdata['error'] = $wsdata['code'];
    } else {
      $this->connectionSession = $wsdata['token'];
      $_SESSION['connectionSession'] = $this->connectionSession;
    }
    return $wsdata;
  }

  /**
   * callAction Function
   * Function for Call Web-services Action
   * @param $actionName= Action name [string], $parameters = parameter array [Array]
   * @return Response
   */
  public function callAction($actionName = "", $parameters = array(), $method = '') {


    //Check connection exist or not
    if ($this->authenticationEnable == true) {

      if (!isset($this->connectionSession) || $this->connectionSession == "") {
        $this->login();
        $this->callAction($actionName, $parameters);
      }

      //pr($this->connectionSession); die;
      $parameters['key'] = $this->connectionSession;
    }


    if ($actionName != "") {

      $webServiceUrl = $this->connectionUrl . $actionName;
      //pr(json_encode($parameters));
      //pr($webServiceUrl);exit;

      $callingMethod = $this->connectionMethod;
      if ($method != '') {
        $callingMethod = strtoupper(trim($method));
      }

      $wsdata = $this->CallAPI($callingMethod, $webServiceUrl, $parameters);
      //pr($wsdata);

      if ($this->authenticationEnable == true) {
        if (isset($wsdata['code']) && (int) $wsdata['code'] == (int) 40002) {
          $this->login();
          $wsdata = $this->callAction($actionName, $parameters);
          return $wsdata;
        }
      }

      return $wsdata;
    } else {
      $wsdata['code'] = "00010";
      $wsdata['status'] = FALSE;
      $wsdata['message'] = "Action name cannot be blank";
      return $wsdata;
    }
  }

  /**
   * CallAPI Function
   * Function for Call Web-services with CURL
   * @param $method = Method [post], $url= Action name [string], $data = parameter array [Array]
   * @return Response
   */
  public function CallAPI($method, $url, $data) {


    //pr($method);
    //pr($url);
    //pr($data); die();
    //====api log add======
    if ($this->logApiEnable == true) {
      $api_type = 'hangman';
      //$log_id = logApiCall($api_type, $method, $url, $data);
    }
    //====api log add======

    try {





      $curl = curl_init();

      switch ($method) {
        case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
          if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, count($data));
            $data = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          }
          break;
        case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          curl_setopt($curl, CURLOPT_PUT, 1);
          //$data = json_encode($data);
          //curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));

          if (!empty($data)) {
            $url = sprintf("%s?%s", $url, http_build_query($data));
          }
          break;
        default:
          if (!empty($data)) {
            $url = sprintf("%s?%s", $url, http_build_query($data));
          }
      }
      //echo $url; die;
      curl_setopt($curl, CURLOPT_URL, $url);

      // Optional Authentication:
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Type: application/x-www-form-urlencoded'));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($curl);
      //echo 'Curl error: ' . curl_error($curl);
      $info = curl_getinfo($curl);

      /* pr(curl_error($curl));
        pr(curl_getinfo($curl));
        pr(curl_getinfo($curl, CURLINFO_HTTP_CODE));

        pr($response);
        die; */


      log_message('error', "----CURL received data----" . $response);


      //====api log update status======
      if ($this->logApiEnable == true) {
        if (curl_error($curl) != '') {

          $api_status = -1;


          $response[] = curl_error($curl);
          $response[] = curl_getinfo($curl);
          $response[] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        } else {
          $api_status = 1;
        }


        //logUpdateCall($log_id, $api_status, $response, $info);
      }
      //====api log update status======

      $res = json_decode($response, true);

      //pr($res);

      if (empty($res)) {

        $res['code'] = 100010;
        $res['status'] = FALSE;
        $res['message'] = 'Webservice is temporary unavailable. Please try again.';
      }
    } catch (Error $e) {
      $res['code'] = 100010;
      $res['status'] = FALSE;
      $res['message'] = $e->getMessage();
    } catch (Exception $e) {
      $res['code'] = 100010;
      $res['status'] = FALSE;
      $res['message'] = $e->getMessage();
    }

    return $res;
  }

}
