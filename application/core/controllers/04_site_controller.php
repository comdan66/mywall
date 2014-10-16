<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Site_controller extends Oa_controller {
  public function __construct () {
    parent::__construct ();
    $this->load->helper ('facebook');
    $this->load->helper ('identity');

    $this->init_component_lists ('meta', 'css', 'javascript', 'hidden', 'footer')
         ->set_componemt_path ('component', 'site')
         ->set_frame_path ('frame', 'site')
         ->set_content_path ('content', 'site')
         ->set_public_path ('public')
         ->set_title ('MYWALL')

         ->_add_css ()
         ->_add_javascript ()
         ->_add_footer ()
         ->add_hidden (array ('id' => '_fb_sign_in_message', 'value' => identity ()->get_session ('_fb_sign_in_message', true)))
         ->add_hidden (array ('id' => '_current_uri', 'value' => url_parse (current_url (), 'path')))
         ->add_hidden (array ('id' => '_search_url', 'value' => base_url (array ('tags', 'search'))))
         ;
  }

  private function _add_css () {
    return $this->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'bootstrap_v3.0.0', 'bootstrap.css')))
                ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'bootstrap_v3.0.0', 'bootstrap-glyphicons.min.css')))

                ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'icomoon_d20140128', 'icomoon.css')))
                ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'jquery-ui-1.10.3.custom', 'redmond', 'jquery-ui-1.10.3.custom.min.css')))
                ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'OA-ui_v1.3', 'OA-ui.css')))
                ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'timepicker', 'jquery-ui-timepicker-addon.css')))

                ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'fancyBox_v2.1.5', 'jquery.fancybox.css')))
                ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.css')))
                ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.css')))
                ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'jquery.jgrowl', 'jquery.jgrowl.css')))
                ;
  }
  private function _add_javascript () {
    return $this->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'jquery_v1.10.2', 'jquery-1.10.2.min.js')))
                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'jquery-ui-1.10.3.custom', 'jquery-ui-1.10.3.custom.min.js')))

                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'OA-ui_v1.3', 'OA-ui.js')))
                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'bootstrap_v3.0.0', 'bootstrap.min.js')))
                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'imgLiquid_v0.9.944', 'imgLiquid-min.js')))

                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'jquery-timeago_v1.3.1', 'jquery.timeago.js')))
                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'jquery-timeago_v1.3.1', 'locales', 'jquery.timeago.zh-TW.js')))

                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS . 'fancyBox_v2.1.5', 'jquery.fancybox.js')))
                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS . 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.js')))
                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS . 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.js')))
                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS . 'fancyBox_v2.1.5', 'jquery.fancybox-media.js')))

                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS . 'masonry_v3.1.2', 'masonry.pkgd.min.js')))
                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS . 'jquery.jgrowl', 'jquery.jgrowl.js')))
                ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS . 'imagesloaded_v3.1.8', 'imagesloaded.pkgd.min.js')))
                ;
  }
  private function _add_footer () {
    return $this->add_footer ('參考網站', array ('name' => 'STYLEWALL', 'src' => 'http://style.fashionguide.com.tw/'),
                                         array ('name' => 'O SHa\'Re', 'src' => 'http://www.oshare.com.tw/'),
                                         array ('name' => 'Dappei', 'src' => 'http://dappei.com/')
                                         )
         ->add_footer ('特別感謝', array ('name' => 'STYLEWALL', 'src' => 'http://style.fashionguide.com.tw/'))
         ->add_footer ('贊助廠商', array ('name' => 'OA', 'src' => 'https://www.facebook.com/comdan66'))
         ->add_footer ('其他資源', array ('name' => '相關說明', 'src' => base_url ('about', 'info')));
  }
}