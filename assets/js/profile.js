/*
Profile JavasScript
*/

var Profile = {
  init: function(id) {
    if(id) {
      this.id = id.toLowerCase();
    }
    this.bind();
  },
  bind: function() {
    $('#content').on('click', '.follow', this.follow.start)
                 .on('click', '.unfollow', this.unfollow.start)
                 .on('mouseover', '.unfollow', this.unfollow.mousein)
                 .on('mouseout', '.unfollow', this.unfollow.mouseout);
  },
  follow: {
    start: function() {
      var id = $(this).data('id');
      var btn = $(this);
      btn.prop('disabled',true);
      $.post(Alp.config.base+'people/action/follow/'+id, function(data) {
        // Ajax callback function, pass data and button object
        Profile.follow.ajaxCallback(data, btn, id);
      });
    },
    ajaxCallback: function(data, btn, id) {
      btn.prop('disabled',false);
      if(!data.success) {
        Alp.bar(data.error);
        return false;
      }

      var username = btn.data('username');
      //Alp.bar('You are now following '+username+'!', 'success');
      $('.count.followers').text(parseInt($('.count.followers').text())+1);

      btn.removeClass('follow')
         .addClass('unfollow btn-primary')
         .text('Following');
      $('.follower-count[data-id='+id+']').text()
    }
  },
  unfollow: {
    mousein: function() {
      $(this).text('Unfollow').removeClass('btn-primary').addClass('btn-danger');
    },
    mouseout: function() {
      $(this).text('Following').addClass('btn-primary').removeClass('btn-danger');
    },
    start: function() {
      var id = $(this).data('id');
      var btn = $(this);
      btn.prop('disabled',true);
      $.post(Alp.config.base+'people/action/unfollow/'+id, function(data) {
        // Ajax callback function, pass data and button object
        Profile.unfollow.ajaxCallback(data, btn);
      });
    },
    ajaxCallback: function(data, btn) {
      btn.prop('disabled',false);
      if(!data.success) {
        alert(data.error);
        return false;
      }

      var username = btn.data('username');
      //Alp.bar('You are no longer following '+username+'.', 'warning');
      $('.count.followers').text(parseInt($('.count.followers').text())-1);

      btn.removeClass('unfollow btn-danger btn-primary')
         .addClass('follow btn-default')
         .text('Follow');
    }
  }
};