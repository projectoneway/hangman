<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Site Front ActiveTemplate
 *
 * @access	public
 * @param	string	current theme folder name
 * @return	string
 */
function getThemeName() {

  $defaultThemeName = $themeName = 'default';


  if (is_dir(VIEWPATH . $themeName)) {
    return $themeName;
  } else {
    return $defaultThemeName;
  }
}

/* end of file */