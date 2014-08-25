<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_picture_comments extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `picture_comments` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `picture_id` int(11) NOT NULL,
              `text` text,
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `picture_id_index` (`picture_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
    
    $sql = "CREATE TABLE `delete_picture_comments` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `origin_id` int(11) NOT NULL,
              `user_id` int(11) NOT NULL,
              `picture_id` int(11) NOT NULL,
              `text` text,
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `picture_id_index` (`picture_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
  }
}
