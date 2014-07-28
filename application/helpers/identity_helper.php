<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

include_once ('path_helper.php');

if (!function_exists ('identity')) {
  function identity () {
    $CI =& get_instance ();
    if (!isset ($CI->identity)) $CI->load->library ('identity');
    return $CI->identity;
  }
}
