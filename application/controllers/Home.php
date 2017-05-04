<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

  public function __construct() {
    parent:: __construct();
  }

  /**
   * @desc Default home page open where user add email address to start game
   * @param string $msg - the message to be displayed
   * @return render view file
   */
  public function index($msg = '') {
    $data = array();

    $data['error'] = '';
    $data['email'] = '';

    if ($msg == 'notfound') {
      $data['error'] = 'Please start with new game....';
    } elseif ($msg == 'inactive') {
      $data['error'] = 'Game is finished. Please start with new game....';
    }

    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

    if ($this->form_validation->run() === FALSE) {

      if (validation_errors()) {
        $data['error'] = validation_errors();
      }

      $data['email'] = $this->input->post('email');
    } else {

      $email = $this->input->post('email', true);
      /*
       * Call API to get gameId
       */
      $apiData = array('email' => $email);

      $this->load->library('connectpoint');
      $wsdata = $this->connectpoint->callAction('games', $apiData, 'POST');

      if (isset($wsdata['gameId']) && !empty($wsdata['gameId'])) {
        /*
         * Uset session for already used character
         */
        $this->session->unset_userdata('usedChar');
        /*
         * Successful response redirect user to play page with gameId
         */
        redirect('home/playgame/' . $wsdata['gameId']);
      }
    }


    $metaTitle = __d('meta.home.title');
    $metaDescription = __d('meta.home.description');
    $this->template->write('metaTitle', $metaTitle, TRUE);
    $this->template->write('metaDescription', $metaDescription, TRUE);
    $this->template->front_write_view('header', 'common/header', $data, true);
    $this->template->front_write_view('content', 'home/index', $data, true);
    $this->template->front_write_view('footer', 'common/footer', $data, true);
    $this->template->render();
  }

  /**
   * @desc Play page where user guess character for given blanks
   * @param string $gameId - gameId receive from API
   * @return render view file
   */
  public function playgame($gameId = '') {

    $data = array();
    $data['error'] = '';
    $data['msg'] = '';

    /*
     * If blank gameId then redirect back to home page
     */
    if ($gameId == '') {
      redirect('home/index/notfound');
    }

    $apiData = array();

    $this->load->library('connectpoint');


    /*
     * Check game status if inactive then redirect to home page
     */
    $wsdata = $this->connectpoint->callAction('games/' . $gameId, $apiData, 'GET');


    if (isset($wsdata['gameId']) && !empty($wsdata['gameId'])) {
      if (isset($wsdata['status']) && strtolower($wsdata['status']) == 'inactive') {
        if (isset($_GET['char']) && !empty($_GET['char'])) {

        } else {
          redirect('home/index/inactive');
        }
      }
    } else {
      if (isset($wsdata['error']) && !empty($wsdata['error'])) {
        $data['error'] = $wsdata['error'];
      } else {
        redirect('home/index/notfound');
      }
    }

    $data["gameId"] = $wsdata['gameId'];
    $data["word"] = $wsdata['word'];
    $data["guessesLeft"] = $wsdata['guessesLeft'];
    $data["status"] = $wsdata['status'];

    /*
     * Used to store already applied character for saving extra call
     */
    $alreadyUsed = $this->session->userdata('usedChar');
    if (isset($_GET['char']) && !empty($_GET['char'])) {

      $char = strtolower($_GET['char']);

      if (!empty($alreadyUsed)) {
        $alreadyUsed[] = $char;
      } else {
        $alreadyUsed[] = $char;
      }
      $this->session->set_userdata('usedChar', $alreadyUsed);

      /*
       * Submit new guess to API
       */

      $apiData = array('char' => $char);
      $wsdata = $this->connectpoint->callAction('games/' . $gameId . '/guesses', $apiData, 'POST');


      if (isset($wsdata['gameId']) && !empty($wsdata['gameId'])) {

        $data["gameId"] = $wsdata['gameId'];
        $data["word"] = $wsdata['word'];
        $data["guessesLeft"] = $wsdata['guessesLeft'];
        $data["status"] = $wsdata['status'];
        $data['msg'] = $wsdata['msg'];
      } else {
        if (isset($wsdata['error']) && !empty($wsdata['error'])) {
          $data['error'] = $wsdata['error'];
        } else {
          redirect('home/index/notfound');
        }
      }
    }

    $data['alreadyUsed'] = $alreadyUsed;

    $metaTitle = __d('meta.home.title');
    $metaDescription = __d('meta.home.description');
    $this->template->write('metaTitle', $metaTitle, TRUE);
    $this->template->write('metaDescription', $metaDescription, TRUE);
    $this->template->front_write_view('header', 'common/header', $data, true);
    $this->template->front_write_view('content', 'home/game', $data, true);
    $this->template->front_write_view('footer', 'common/footer', $data, true);
    $this->template->render();
  }

  /**
   * @desc Default 404 page
   * @return render view file
   */
  public function error404() {
    $data = array();

    $metaTitle = __d('meta.error404.title');
    $metaDescription = __d('meta.error404.description');
    $this->template->write('metaTitle', $metaTitle, TRUE);
    $this->template->write('metaDescription', $metaDescription, TRUE);
    $this->template->front_write_view('header', 'common/header', $data, true);
    $this->template->front_write_view('content', 'common/error_page', $data, true);
    $this->template->front_write_view('footer', 'common/footer', $data, true);
    $this->template->render();
  }

}
