$(function() {
  var $main_img = $('#main_img');
  var scroll_timer = null;

  $main_img.imagesLoaded (function () {
    $main_img.css ({'height': parseFloat ($main_img.find ('img').css ('height')) }).imgLiquid ({horizontalAlign: "top"});
    $(window).scroll (function () {
      clearTimeout (scroll_timer);
      if ($(window).height () + $(window).scrollTop () > $('#comments').height () + $('#comments').offset ().top + 70) {
        scroll_timer = setTimeout (function () { loadComments (); }, 100);
      }
    }).scroll ();
  });


  $('#main_user_avatar').imgLiquid ({horizontalAlign: "center"});
  $('.picture').imgLiquid ({verticalAlign: "top"});
  $('.comment_user_avatar').imgLiquid ({verticalAlign: "center"});
  $('.delete_picture button').click (function () {
     var $that = $(this), id = $that.data ('id');

     $.ajax ({
      url: $('#delete_picture_url').val (),
      data: { id: id },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {
        $that.bs_button ('loading');
      }
    })
    .done (function (result) {
      $that.bs_button ('reset');
      showAlert (result.title, result.message, eval ('(' + result.action + ')'));
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
  });
  var fetchStarDetails = function (id) {
    if (id > 0) {
      var $star_details = null;

      $.ajax ({
        url: $('#fetch_star_details_url').val (),
        data: { id: id },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {
          if (!($star_details = $('.star_details')).length)
            $star_details = $('<div />').addClass ('star_details').css ({'background': 'rgba(255, 255, 255, 1.00) url(data:image/gif;base64,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) no-repeat center center'}).insertAfter ($('#set_score'));
          }
      })
      .done (function (result) {
        $star_details.remove ();  
        if (result.status) {
          $star_details = $(result.star_details).insertAfter ($('#set_score'));
          $('#set_score').empty ().css ({'background': 'rgba(255, 255, 255, 1.00)'}).append ($(result.score_star));
          initSetScoreStar ();
        }
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  }
  var initSetScoreStar = function () {
    $('#set_score').find ('span[class*=icon-star]').mouseenter (function () {
      $(this).siblings ('span').andSelf ().removeClass ().addClass ('icon-star4');
      $(this).prevAll ('span').andSelf ().removeClass ('icon-star4').addClass ('icon-star6').addClass ('select_star');
    }).mouseleave (function () {
      $(this).siblings ('span').andSelf ().each (function () {
        $(this).removeClass ().addClass ($(this).data ('class'))  
      });
    }).click (function () {

      var $set_score = $('#set_score');

      if ($set_score.data ('is_sign_in')) {
        if (!$set_score.data ('is_set_scored')) {
          $.ajax ({
            url: $('#set_score_url').val (),
            data: { id: $set_score.data ('id'), score: $(this).index () + 1 },
            async: true, cache: false, dataType: 'json', type: 'POST',
            beforeSend: function () { 
              $set_score.find ('span[class*=icon-star]').hide ();
              $set_score.css ({'background': 'rgba(255, 255, 255, 1.00) url(data:image/gif;base64,R0lGODlhEAALAPQAANnf6ztamsLL3rvG28vU5D5cmztamldxqIudw3aLt6271VBqpGh/sY+ixXiNubC81VJtpT1bmmqCssnR4sDK3tLZ51x3q8LN39DY5qu4052tzLjD2c7V5QAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCwAAACwAAAAAEAALAAAFLSAgjmRpnqSgCuLKAq5AEIM4zDVw03ve27ifDgfkEYe04kDIDC5zrtYKRa2WQgAh+QQJCwAAACwAAAAAEAALAAAFJGBhGAVgnqhpHIeRvsDawqns0qeN5+y967tYLyicBYE7EYkYAgAh+QQJCwAAACwAAAAAEAALAAAFNiAgjothLOOIJAkiGgxjpGKiKMkbz7SN6zIawJcDwIK9W/HISxGBzdHTuBNOmcJVCyoUlk7CEAAh+QQJCwAAACwAAAAAEAALAAAFNSAgjqQIRRFUAo3jNGIkSdHqPI8Tz3V55zuaDacDyIQ+YrBH+hWPzJFzOQQaeavWi7oqnVIhACH5BAkLAAAALAAAAAAQAAsAAAUyICCOZGme1rJY5kRRk7hI0mJSVUXJtF3iOl7tltsBZsNfUegjAY3I5sgFY55KqdX1GgIAIfkECQsAAAAsAAAAABAACwAABTcgII5kaZ4kcV2EqLJipmnZhWGXaOOitm2aXQ4g7P2Ct2ER4AMul00kj5g0Al8tADY2y6C+4FIIACH5BAkLAAAALAAAAAAQAAsAAAUvICCOZGme5ERRk6iy7qpyHCVStA3gNa/7txxwlwv2isSacYUc+l4tADQGQ1mvpBAAIfkECQsAAAAsAAAAABAACwAABS8gII5kaZ7kRFGTqLLuqnIcJVK0DeA1r/u3HHCXC/aKxJpxhRz6Xi0ANAZDWa+kEAA7AAAAAAAAAAAA) no-repeat center center'});
            }
          })
          .done (function (result) {
            if (result.status) {
              $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
              $set_score.data ('is_set_scored', 1);
              fetchStarDetails ($set_score.data ('id'));
            } else {
              $set_score.find ('span[class*=icon-star]').show ();
              $set_score.css ({'background': 'transparent'});
              showConfirm (result.title, result.message, eval ('(' + result.action + ')'));
            }
          })
          .fail (function (result) { ajaxError (result); })
          .complete (function (result) { });
        } else { $.jGrowl ('你已經評過分數囉!', { theme: 'j_growl', easing: "easeInExpo"}); }
      } else { showConfirm ('提示', '你還沒登入喔！趕快按下確定，就可以輕鬆使用 Facebook 登入評分囉!', function () { window.location.assign ($('#fb_sign_in_url').val ()); }); }
    });
  }
  initSetScoreStar ();

  var setCommentFeature = function ($obj) {
    $obj.find ('.comment_user_avatar').imgLiquid ({verticalAlign: "center"});
    $obj.find ('.timeago').timeago ();
    $obj.find ('.delete_comment button').click (function () {
      var $that = $(this);
      var comment_id = $that.data ('comment_id');

      $.ajax ({
        url: $('#delete_comment_url').val (),
        data: { comment_id: comment_id },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {
          $that.bs_button ('loading');
        }
      })
      .done (function (result) {
        $that.bs_button ('reset');
        if (!result.status)
          $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
        else
          $that.parents (".comment").hide ("blind", function () {$(this).remove ();});
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    });
    return $obj;
  }

  $('#submit_comment').click (function () {
    var $that = $(this);
    var user_id = $that.data ('user_id');
    var id = $that.data ('id');
    var text = $('#to_comment_text').val ();

    if (text.length && (text != '')) {
      $.ajax ({
        url: $('#submit_comment_url').val (),
        data: { id: id, user_id: user_id, text: text },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { 
          $that.bs_button ('loading');
          $('#to_comment_text').hide ();
          $('#comment_loadding').show ();
        }
      })
      .done (function (result) {
        $that.bs_button ('reset');
        $('#comment_loadding').hide ();

        if (result.status)
          $('#to_comment_text').val ('').show ();
        else
          $('#to_comment_text').show ();
        
        if (!result.status)
          $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});

        if (result.status && result.content) {
          var $comment = setCommentFeature ($(result.content)).prependTo ($('#comments')).hide ().show ('blind');
        }
        $("html, body").animate({ scrollTop: '+=115px' }, "slow");
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  });
  

  var loadComments = function () {
    var $comments = $('#comments');
    $.ajax ({
      url: $('#get_comments_url').val (),
      data: { id: $comments.data ('id'), next_id: $comments.data ('next_id') },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {
        $comments.data ('next_id', -1);
      }
    })
    .done (function (result) {
      if (result.status && result.contents) {
        for (var i = 0; i < result.contents.length; i++) {
          $obj = $(result.contents[i]);
          $obj.appendTo ($comments).hide ().show ('blind');
          setCommentFeature ($obj); 
        }
        $comments.data ('next_id', result.next_id);
      }
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
  }

});