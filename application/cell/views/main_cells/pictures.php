      <div class='picture'>
        <div class='picture_pic'>
          <img src='<?php echo $picture->file_name->url ('228xW');?>' />
        </div>
        <div class='picture_not_pic'>
          <div class='picture_user_name'>
            <?php echo $picture->user->name;?>
          </div>
          <div class='picture_text'>
            即將要入秋了~ 但感覺台灣還是會熱一陣子! 小露肚皮的時光也不多惹~嘻嘻！
          </div>
          <div class='picture_info row'>
            <div class='col-md-6 left'>
              <i class='icon-love'></i> <span>100000</span>
            </div>
            <div class='col-md-6 right timeago' data-time='<?php echo $picture->created_at;?>'></div>
          </div>
          <div class='picture_user_avatar'>
            <img src='http://front-pic.style.fashionguide.com.tw/uploads/share/picture/915981/thumb_middle_share_picture_53e11150e8bf1.jpg' />
          </div>
        </div>
      </div>