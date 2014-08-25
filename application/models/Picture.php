<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Picture extends OaModel {

  static $table_name = 'pictures';

  static $belongs_to = array (
    array ('user', 'class_name' => 'User'),
  );
  
  static $before_create = array ('add_year_week');

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

    OrmImageUploader::bind ('file_name');
  }

  public function add_year_week () { return !$this->year_week ? $this->year_week = date ('YW') : $this->year_week; }
}