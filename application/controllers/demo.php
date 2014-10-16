<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Demo extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    $pic = Picture::find ('one', array ('conditions' => array ('id = 1')));
    if ($pic->comments)
      foreach ($pic->comments as $comment)
        echo $comment->text . '<hr/>';
  }

  public function c () {
    $this->load->helper ('directory');
    $this->load->library ("migration");
    if (!$this->migration->latest ())
      if (!$this->migration->current ())
        show_error ($this->migration->error_string ());

    clean_cell ();
    delete_files (FCPATH . config ('model_config', 'uploader', 'bucket', 'local', 'base_directory'), true);
    $this->cache->file->clean ();
    if ($models = array_map (function ($file) { return pathinfo ($file, PATHINFO_FILENAME); }, array_filter (get_filenames (FCPATH . APPPATH . 'models'), function ($file) { return !in_array (pathinfo ($file, PATHINFO_FILENAME), array ('OaModel', 'OaDeleteModel', 'ActiveRecordModel')) && (pathinfo ($file, PATHINFO_EXTENSION) == 'php'); })))
      foreach ($models as $model)
        $model::query ('TRUNCATE TABLE ' . $model::table ()->table . ';');
    $this->g0 ();
  }

  public function g0 () {
    $this->load->library ('phpQuery');
    for ($i = 0; $i < 10; $i++)
      if ($get_html_str = str_replace ('&amp;', '&', urldecode (file_get_contents ('http://style.fashionguide.com.tw/users/' . $i)))) {
        $php_query = phpQuery::newDocument ($get_html_str);
        $blocks = pq (".block-figure .user-name", $php_query);
        $img = pq (".block-figure .avatar", $php_query);
        
        $name = $blocks->eq (0)->text ();
        $src = str_replace ('thumb_big_', '', $img->eq (0)->attr ('src'));
        if ($user = User::create (
                  array ('uid' => 0, 'name' => $name, 'email' => '',
                    'register_from' => 'local', 'avatar' => '', 'banner' => '', 'to_picture_comments_count' => 0, 'pictures_count' => 0, 'sign_in_at' => date ('Y-m-d H:i:s'), 'sign_in_count' => rand (10, 100))))
          if (!$user->avatar->put_url ($src))
            $user->recycle ();
      }
    $this->g2 ();
  }

  public function g2 () {
    $this->load->library ('phpQuery');
    $urls = array ('http://style.fashionguide.com.tw/?page=3',
                   'http://style.fashionguide.com.tw/?page=2',
                   'http://style.fashionguide.com.tw/');
    if ($urls && ($rang = (User::count () - 1)))
      foreach ($urls as $url) {
        $get_html_str = str_replace ('&amp;', '&', urldecode (file_get_contents ($url)));

        $php_query = phpQuery::newDocument ($get_html_str);
        $blocks = pq ("#masonry .box", $php_query);

        for ($i = 0; $i < $blocks->length; $i++) { 
          $block = $blocks->eq ($i);
          $src = str_replace ('thumb_middle_', '', ($block->find ('.box-img img')->attr ('src')));
          $tag = trim (preg_replace ('/\s*(.*)\s*/', '$1', $block->find ('.user-name')->text ()));
          $tag = trim (preg_replace ('/(.*)分享到(.*)的(.*)/', '$3', $tag));
          $text = preg_replace ('/\s*(.*)\s*/', '$1', $block->find ('.message')->text ());
          $user = User::find ('one', array ('select' => 'id', 'order' => 'RAND()', 'conditions' => array ()));
          
          $pic = Picture::create (array ('user_id' => $user->id, 'is_sync' => '0', 'pageview' => 0, 'text' => $text, 'file_name' => ''));
          if (!$pic->file_name->put_url ($src)) {
            $pic->recycle ();
          } else {
            // UserActive::create_active ($user, 'po_picture', get_class ($pic), $pic->id);

            if ($tag && !($pic_tag = PictureTag::find ('one', array ('conditions' => array ('name = ?', strip_tags ($tag)))))) {
              $pic_tag = PictureTag::create (array ('name' => strip_tags ($tag), 'picture_count' => '0'));
            }

            if (isset ($pic_tag)) {
              PictureTagMapping::create (array ('picture_id' => $pic->id, 'picture_tag_id' => $pic_tag->id));
            }
          }
        }

        if ($pts = PictureTag::find ('all'))
          foreach ($pts as $pt) {
            $pt->picture_count = PictureTagMapping::count (array ('conditions' => array ('picture_tag_id = ?', $pt->id)));
            $pt->save ();
          }
      }

    if ($pic_tags = PictureTag::find ('all', array ('limit' => config ('main_controller_config', 'block9s_count'), 'order' => 'picture_count DESC', 'conditions' => array ('picture_count > ?', 9))))
      foreach ($pic_tags as $pic_tag)
        $tag_category = TagCategory::create (array ('name' => $pic_tag->name, 'kind' => 'block9', 'file_name' => '', 'memo' => ''));
    
    if ($pic_tags = PictureTag::find ('all', array ('limit' => 8, 'order' => 'picture_count DESC')))
      foreach ($pic_tags as $pic_tag)
        $tag_category = TagCategory::create (array ('name' => $pic_tag->name, 'kind' => 'top', 'file_name' => '', 'memo' => ''));
    $this->g3 ();
  }

  public function g3 () {
    if ($pics = Picture::find ('all', array ('limit' => 6, 'order' => 'LENGTH(text) DESC'))) {
      foreach ($pics as $i => $pic) {
        $promo = Promo::create (array ('title' => mb_strimwidth ($pic->text, 0, 120, '…', 'UTF-8'), 'text' => $pic->text, 'file_name' => '', 'link' => base_url (array ('pictures', $pic->id)), 'kind' => 'promo' . ($i + 1)));
        $promo->file_name->put_url ($pic->file_name->url ());
      }
    }
    $this->g5 ();
  }
public function g4 () {
    $this->load->library ('phpQuery');
   // http://style.fashionguide.com.tw/tag/
    if (($tag_categories = TagCategory::find ('all', array ('conditions' => array ('kind = ?', 'top')))) && ($rang = (User::count () - 1)))
      foreach ($tag_categories as $tag_category) {
        if ($tags = $tag_category->tags ()) {
          // echo 'http://style.fashionguide.com.tw/tag/' . (implode (' ', $tags));
          // echo urldecode ('http://style.fashionguide.com.tw/tag/' . (implode ('%20', (array_map (function ($tag) { return urlencode (str_replace ("&", ' ', $tag)); }, $tags))))) . '<hr/>';
          $get_html_str = str_replace ('&amp;', '&', urldecode (file_get_contents ('http://style.fashionguide.com.tw/tag/' . (implode ('%20', (array_map (function ($tag) { return urlencode (str_replace ("&", '', $tag)); }, $tags)))))));

          $php_query = phpQuery::newDocument ($get_html_str);
          $blocks = pq ("#masonry .box", $php_query);

          for ($i = 0; $i < $blocks->length; $i++) { 
            $block = $blocks->eq ($i);
            $src = str_replace ('thumb_middle_', '', ($block->find ('.box-img img')->attr ('src')));
            $tag = trim (preg_replace ('/\s*(.*)\s*/', '$1', $block->find ('.user-name')->text ()));
            $tag = trim (preg_replace ('/(.*)分享到(.*)的(.*)/', '$3', $tag));
            $text = preg_replace ('/\s*(.*)\s*/', '$1', $block->find ('.message')->text ());

            $pic = Picture::create (array ('user_id' => rand (1, $rang), 'pageview' => 0, 'score' => 0, 'text' => $text, 'file_name' => ''));
            $pic->file_name->put_url ($src);

            if ($tag && !($pic_tag = PictureTag::find ('one', array ('conditions' => array ('name = ?', $tag))))) {
              $pic_tag = PictureTag::create (array ('name' => $tag, 'picture_count' => '0'));
            }

            if (isset ($pic_tag)) {
              PictureTagMapping::create (array ('picture_id' => $pic->id, 'picture_tag_id' => $pic_tag->id));
            }
          }

          if ($pts = PictureTag::find ('all'))
            foreach ($pts as $pt) {
              $pt->picture_count = PictureTagMapping::count (array ('conditions' => array ('picture_tag_id = ?', $pt->id)));
              $pt->save ();
            }
        }
      }
    $this->g5 ();
  }

  public function g5 () {
    if ($users = User::find ('all', array ('select' => 'id, pictures_count, updated_at'))) {
      foreach ($users as $user) {
        $user->pictures_count = Picture::count (array ('conditions' => array ('user_id = ?', $user->id)));
        $user->save ();
      }
    }
    $this->g6 ();
  }

  public function g6 () {
    if ($pics = Picture::find ('all', array ('select' => 'id, user_id'))) 
      foreach ($pics as $pic) 
        UserActive::create_active ($pic->user_id, 'po_picture', get_class ($pic), $pic->id);
    $this->g7 ();
  }
  public function g7 () {
    $comment_items = array ('gooood', 'XDDDDDDDD', 'I like!', '水喔！', '哈哈哈', '酷喔', ': )', '好漂亮！', '我也要>"<', '咦？');

    if (($pictures = Picture::find ('all', array ('select' => 'id'))) && ($user_count = User::count ())) {
      foreach ($pictures as $picture) {
        if ($users = User::find ('all', array ('select' => 'id', 'order' => 'RAND()', 'limit' => rand (1, $user_count), 'conditions' => array ()))) {
          foreach ($users as $user) {
            if ($comment = PictureComment::create (array ('user_id' => $user->id, 'picture_id' => $picture->id, 'text' => $comment_items[rand (0, count ($comment_items) - 1)]))) {
              UserActive::create_active ($user, 'add_picture_comment', get_class ($comment), $comment->id);
            }
          }
        }
      }
    }
    $this->g8 ();
  }
  public function g8 () {
    if ($pictures = Picture::find ('all', array ('select' => 'id, comments_count, updated_at')))
      foreach ($pictures as $picture)
        if ($picture_comment = PictureComment::find ('one', array ('select' => 'COUNT(id) AS count', 'conditions' => array ('picture_id = ?', $picture->id)))) {
          $picture->comments_count = $picture_comment->count;
          $picture->save ();
        }
    $this->g9 ();
  }

  public function g9 () {
    if ($users = User::find ('all', array ('select' => 'id, banner, updated_at')))
      foreach ($users as $user)
        if ($user->rand_picture)
          $user->banner->put_url ($user->rand_picture->file_name->url ());
    $this->g10 ();
  }

  public function g10 () {
    if ($users = User::find ('all', array ('select' => 'id, to_picture_comments_count, updated_at'))) {
      foreach ($users as $user) {
        $user->to_picture_comments_count = PictureComment::count (array ('conditions' => array ('user_id = ?', $user->id)));
        $user->save ();
      }
    }
    $this->g11 ();
  }
  public function g11 () {
    $count = User::count ();
    if (($users = User::find ('all', array ('select' => 'id'))) && ($count = User::count ())) {
      foreach ($users as $user) {
        if ($be_user_ids = field_array (User::find ('all', array ('select' => 'id', 'order' => 'RAND()', 'limit' => floor ($count / rand (2, 4)), 'conditions' => array ('id NOT IN (?)', array ($user->id)))), 'id')) {
          foreach ($be_user_ids as $be_user_id) {
            $follow = Follow::create (array ('user_id' => $user->id, 'be_user_id' => $be_user_id));
            delay_job ('user_actives', 'create_actives', array ('user_id' => $follow->user_id, 'kind' => 'to_follow', 'model_name' => get_class ($follow), 'model_id' => $follow->be_user_id));
            delay_job ('user_actives', 'create_actives', array ('user_id' => $follow->be_user_id, 'kind' => 'be_follow', 'model_name' => get_class ($follow), 'model_id' => $follow->user_id));
            delay_job ('users', 'update_follows_count', array ('user_id' => $follow->user_id, 'be_user_id' => $follow->be_user_id));
          }
        }
      }
    }
    $this->g12 ();
  }
  public function g12 () {
    if ($users = User::find ('all'))
      foreach ($users as $user)
        $user->score_set ();
  }

}
