<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class PictureScore extends OaModel {

  static  $table_name = 'picture_scores';

  static $validates_uniqueness_of = array (
    array (array ('picture_id', 'user_id'), 'message' => 'picture_id + user_id repeated!')
  );
  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
}
