<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_groups extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `groups` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `main_id` int(11) NOT NULL DEFAULT '0',
              `tag_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);

    $sql = "CREATE TABLE `delete_groups` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `main_id` int(11) NOT NULL DEFAULT '0',
              `tag_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
  }
}