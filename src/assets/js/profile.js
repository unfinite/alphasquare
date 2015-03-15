/**
 * Profile JS
 * @type {Object}
 * @copyright Copyright (c) 2014 Alphasquare
 */

var Profile = {
  init: function(data) {

    if(data) {
      for(var prop in data) {
        Profile[prop] = data[prop];
      }
    }

    this.bind();
  },
  bind: function() {
    $('#content').on('click', '.follow', this.follow.start)
                 .on('click', '.unfollow', this.unfollow.start)
                 .on('click', '#about .edit', this.editSection.open)
                 .on('mouseover', '.unfollow', this.unfollow.mousein)
                 .on('mouseout', '.unfollow', this.unfollow.mouseout);
    $('#about .readmore').readmore({
      maxHeight: 70
    });
  },
  follow: {
    start: function() {
      var id = $(this).data('id');
      var btn = $(this);
      btn.prop('disabled',true);
      $.post(Alp.config.base+'people/action/follow/'+id, function(data) {
        // Ajax callback function, pass data and button object
        Profile.follow.ajaxCallback(data, btn, id);
      }).always(function() {
        btn.prop('disabled',false);
      });
    },
    ajaxCallback: function(data, btn, id) {
      if(!data.success) {
        Alp.bar(data.error);
        return false;
      }

      var username = btn.data('username');
      //Alp.bar('You are now following '+username+'!', 'success');
      $('.count.followers[data-id="'+id+'"]').text(parseInt($('.count.followers[data-id="'+id+'"]').text())+1);

      btn.removeClass('follow')
         .addClass('unfollow btn-primary btn-outline')
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
        Profile.unfollow.ajaxCallback(data, btn, id);
      }).always(function() {
        btn.prop('disabled',false);
      });
    },
    ajaxCallback: function(data, btn, id) {
      if(!data.success) {
        alert(data.error);
        return false;
      }

      var username = btn.data('username');
      //Alp.bar('You are no longer following '+username+'.', 'warning');
      $('.count.followers[data-id="'+id+'"]').text(parseInt($('.count.followers[data-id="'+id+'"]').text())-1);

      btn.removeClass('unfollow btn-danger btn-primary')
         .addClass('follow btn-default')
         .text('Follow');
    }
  },

  editSection: {
    type: null,
    open: function() {
      var type = $(this).data('edit');
      var label = $('h3', $(this).closest('.panel')).first().text();
      Profile.editSection.type = type;
      Profile.editSection.label = label;
      Profile.editSection.url = Profile.baseUrl + '/edit/' + Profile.editSection.type;
      Profile.editSection.openModal();
    },
    openModal: function() {
      AjaxModal({
        title: this.label,
        url: this.url,
        prependBaseUrl: false,
        size: 'small',
        buttons: {
          cancel: {
            label: 'Cancel'
          },
          save: {
            label: 'Save',
            className: 'btn-primary save-profile',
            callback: this.save
          }
        }
      });
    },
    save: function() {
      var form = $('#edit-profile-form');
      var data = form.serialize();
      data += '&save=true';
      var btn = $('button.save-profile');
      var url = Profile.editSection.url;
      btn.prop('disabled',true);
      $.post(url, data, Profile.editSection.ajaxCallback).always(function() {
        btn.prop('disabled',false);
      }, 'json');
      return false;
    },
    ajaxCallback: function(data) {
      if(data.success) {
        Alp.bar('Your profile has been updated!', 'success');
        bootbox.hideAll();
        setTimeout(function() {
          window.location.href = data.url;
        }, 500);
      }
      else {
        Alp.alertBox(data.error, 'danger', '#edit-profile-form')
      }
    }
  }

};

/* Capitalizes first letter of a string
 *
 * Example: "hello world".capitalize();
 * Returns: "Hello world"
 *
 * Thanks to:
 * http://stackoverflow.com/a/3291856/507629
 */

String.prototype.capitalize = function() {
  return this.charAt(0).toUpperCase() + this.slice(1);
}