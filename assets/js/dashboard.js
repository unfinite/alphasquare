/**
 * Dashboard
 * @type {Object}
 * @copyright (c) 2014 Alphasquare
 */

var Dashboard = {

  init: function() {
    this.bind();
    mixpanel.track("DashObject loaded");
  },

  bind: function() {
    $('#post-bar').submit(this.post.start);
    $('#post-bar textarea').keypress(this.post.keyHandler);
    $('body').on('click', '.post .vote', this.vote.click);
    $('.post section p').readmore({
      maxHeight: 200
    });
    this.comment.bind();
    this.post.poll.begin();
    this.post.loadMore.bind();
    this.post.actions.bind();
  },

  post: {
    bind: function() {
      Alp.timeago();
    },
    keyHandler: function(e) {
      // If key is "enter" (13), submit the form
      if(e.which === 13 && !e.shiftKey) {
        $(this).closest('form').submit();
        e.preventDefault();
        return false;
      }
    },
    start: function(e) {
      var content = $.trim($('textarea', this).val());
      if(content.length < 1) {
        return false;
      }
      Dashboard.post.ajax(content);
      e.preventDefault();
      return false;
    },
    ajax: function(content) {
      var data = { content: content };
      $('#post-bar textarea').prop('disabled', true);
      $.post(
        Alp.config.base+'debate/create',
        data,
        Dashboard.post.ajaxCallback,
        'json'
        );
      mixpanel.track("Post Submit");
    },
    ajaxCallback: function(data) {
      if(!data.success) {
        mixpanel.track("Failed post");
        Alp.bar(data.error);
        return false;
      }
      $('#post-bar textarea')
        .prop('disabled', false)
        .val('')
        .css('height',50);
      $(data.html)
        .css('display','none')
        .prependTo('#posts')
        .delay(100)
        .slideDown(250, Alp.timeago);
    },
    loadMore: {
      bind: function() {
        // If #posts doesn't exist, or there aren't any posts
        if($('#posts').length < 1 || $('#posts article').length < 1) {
          return false;
        }
        // Bind Dashboard.loadMore.scroll to window scroll event
        $(window).scroll(this.scroll);
      },
      scroll: function() {
        // If more posts are currently loading or all have been loaded, return false
        if($('#posts-loading').is(':visible') || $('#posts').hasClass('all-loaded')) {
          return false;
        }
       // if ($(window).scrollTop() >= ( $(document).height() - $(window).height() - 50)) {
        if($(window).scrollTop() >= $('#posts').offset().top + $('#posts').outerHeight() - window.innerHeight + 80) {
          var type = $('#posts').data('type');
          var data = {
            offset: $('#posts article.post').length,
            type: type
          };
          if(type === 'profile') {
            data.user_id = $('#profile-page').data('id');
          }
          $('#posts-loading').show();
          $.get(Alp.config.base+'debate/load_more',
                data,
                Dashboard.post.loadMore.ajaxCallback);
        }
      },
      ajaxCallback: function(data) {
        if(!data.success) {
          Alp.bar('Sorry, we were unable to load more posts.');
          return false;
        }
        $('#posts').append(data.html);
        Dashboard.post.bind();
        if(data.count < 1) {
          $('#posts').addClass('all-loaded');
          $('#posts-loading').html('All of the debates in this feed have been loaded.');
        }
        else {
          $('#posts-loading').hide();
        }
      }
    },
    poll: {
      interval: 15000, // milliseconds
      setIntervalObject: null,
      begin: function() {
        // If #posts container doesn't exist, don't poll
        if($('#posts').length < 1) return false;
        this.setIntervalObject = setTimeout(this.ajax, this.interval);
      },
      ajax: function() {
        mixpanel.track("AlpEngine poll, dashboard");
        var latestId = $('#posts .post').first().data('id');
        var type = $('#posts').data('type');
        var data = { latest_id: latestId, type: type };
        if(type === 'profile') {
          data.user_id = $('#profile-page').data('id');
        }
        $.get(Alp.config.base+'debate/poll', data)
          .success(Dashboard.post.poll.callback)
          .always(function() {
            // Set another timeout for the next poll once ajax request is complete
            // Using setTimeout rather than setInterval so it waits until the last poll is complete
            setTimeout(Dashboard.post.poll.ajax, Dashboard.post.poll.interval);
          });
      },
      callback: function(data) {
        if(!data.success) {
          if(data.error_word === 'login') {
            window.location.href = Alp.config.base + 'login';
            return false;
          }
          Alp.bar('Unable to update the feed. Please reload the page.');
          return false;
        }
        $(data.html).css('display','none')
                    .prependTo('#posts')
                    .slideDown(250, Dashboard.post.bind);
      }
    },
    actions: {
      bind: function() {
        $(document).on('click', '.delete-post', this.remove.modal);
        $(document).on('click', '.report-post', this.report.modal);
      },

      remove: {
        modal: function() {
          var id = $(this).closest('article.post').data('id');
          bootbox.dialog({
            title: 'Delete Post',
            message: 'Do you really want to delete that post?',
            buttons: {
              cancel: {
                label: 'Cancel'
              },
              main: {
                label: 'Yes, delete',
                className: 'btn-danger',
                callback: function() {
                  Dashboard.post.actions.remove.ajax(id);
                  return false;
                }
              }
            },
            size: 'small',
            animate: false
          });
          return false;
        },
        ajax: function(id) {
          var data = { id: id };
          $.post(Alp.config.base+'debate/delete', data, Dashboard.post.actions.remove.ajaxCallback, 'json');
          mixpanel.track("Post deleted");
        },
        ajaxCallback: function(data) {
          if(!data.success) {
            Alp.bar(data.error);
            mixpanel.track("Post deletion failure");
            return false;
          }
          $('.post[data-id='+data.id+'], #comments').slideUp(function() {
            $(this).remove();
            // If on post page
            if($('#post-page').length>0) {
              window.location.href = Alp.config.base+'dashboard';
            }
          });
          bootbox.hideAll();
        }
      },

      report: {
        modal: function() {
          var id = $(this).closest('article.post').data('id');
          AjaxModal({
            title: 'Report Post',
            url: 'debate/report/'+id,
            size: 'small',
            buttons: {
              cancel: {
                label: 'Cancel'
              },
              submit: {
                label: 'Report',
                className: 'btn-warning',
                callback: Dashboard.post.actions.report.submit
              }
            }
          });
          return false;
        },
        submit: function() {
          alert('report');
          return false;
        }
      }

    }
  },


  vote: {
    id: 0,
    click: function() {
      var btn = $(this);
      // Get type from data-type attribute on button
      var type = btn.data('type');
      // Get id from data-id on parent .post element
      var id = btn.closest('.post').data('id');
      // If the button has btn-primary or btn-danger class,
      // then the user has clicked it before and now is removing the vote
      if(btn.hasClass('btn-primary') || btn.hasClass('btn-danger')) {
        type = 'remove';
      }
      Dashboard.vote.id = id;
      Dashboard.vote.start(type);
    },
    start: function(type) {

      // Construct ajax url
      var url = Alp.config.base+'debate/vote/'+type;

      Dashboard.vote.disableButtons();

      // Send post request
      $.post(url, { id: Dashboard.vote.id }, function(data) {
        Dashboard.vote.ajaxCallback(type, data);
      }, 'json')
      .always(Dashboard.vote.enableButtons);

    },
    disableButtons: function() {
      // Disable buttons
      $('.post[data-id='+Dashboard.vote.id+'] .vote').prop('disabled',true);
    },
    enableButtons: function() {
      // Enable buttons
      $('.post[data-id='+Dashboard.vote.id+'] .vote').prop('disabled',false);
    },
    ajaxCallback: function(type, data) {

      var id = Dashboard.vote.id;

      if(!data.success) {
        Alp.bar(data.error, 'error');
        return false;
      }
      var post = $('.post[data-id='+id+']');
      var up = $('.vote[data-type=up]', post);
      var down = $('.vote[data-type=down]', post);

      // Remove both classes from buttons
      $('.vote', post).removeClass('btn-primary btn-danger btn-success');

      // Add appropriate classes to buttons based on type
      switch(type) {
        case 'up':
          up.addClass('btn-primary');
          down.addClass('btn-success');
        break;
        case 'down':
          down.addClass('btn-danger');
          up.addClass('btn-success');
        break;
        case 'remove':
          up.addClass('btn-success');
          down.addClass('btn-success');
        break;
      }

      // Update button counts
      $('.count', up).text(data.up_votes);
      $('.count', down).text(data.down_votes);

    }
  },

  comment: {
    postid: 0,
    viewingAll: false,
    bind: function() {
      Dashboard.comment.postid = $('#post-page').data('id');
      $('#comments').on('click', '.reply', this.reply);
      $('#post-comment').submit(this.submit);
      $('#post-comment textarea').keypress(function(e) {
        // If key is "enter" (13) submit the form
        if(e.which === 13 && !e.shiftKey) {
          $(this).closest('form').submit();
          e.preventDefault();
          return false;
        }
      });
      $('#load-all-comments').click(this.loadAll.click);
    },
    submit: function() {
      var comment = $.trim($('textarea', this).val());
      if(comment.length < 1) {
        return false;
      }
      Dashboard.comment.post(comment);
      return false;
    },
    post: function(comment) {
      var data = { postid: this.postid, content: comment };
      $.post(Alp.config.base+'comments/create', data, this.ajaxCallback, 'json');
      mixpanel.track("Comment posted");
    },
    ajaxCallback: function(data) {
      var id = Dashboard.comment.postid;
      if(!data.success) {
        Alp.bar(data.error);
        mixpanel.track("Comment post failure");
        return false;
      }
      // If load all comments link is present
      if($('#load-all-comments').length > 0) {

        // Update all comments count
        var count = parseInt($('#load-all-comments span').text());
        $('#load-all-comments span').text(count+1);
        // If not viewing all comments, remove first comment
        if(!Dashboard.comment.viewingAll) {
          $('#comments-container .comment').first().slideUp(250, function() {
            $(this).remove();
          });
        }

      }
      // Clear and blur textarea
      $('#post-comment textarea').val('').blur();
      // Show message bar
      // Append comment
      $(data.html).css('display','none')
                  .appendTo('#comments-container')
                  .slideDown(250, Alp.timeago);
    },
    loadAll: {
      click: function(e) {
        var postid = Dashboard.comment.postid;
        var data = { id: postid };
        $('#load-all-comments img').show();
        $.get(
          Alp.config.base+'comments/load_all',
          data,
          Dashboard.comment.loadAll.ajaxCallback
        ).always(function() {
          $('#load-all-comments img').fadeOut();
        });
        e.preventDefault();
        return false;
      },
      ajaxCallback: function(data) {
        $('#load-all-comments').hide(200, function() { $(this).remove(); });
        $('#comments-container').empty();
        $(data.html).css('display','none')
                    .prependTo('#comments-container')
                    .fadeIn(200, Alp.timeago);
      }
    },
    poll: {
      interval: 15000, // milliseconds
      begin: function() {
        setTimeout(this.ajax, this.interval);
      },
      ajax: function() {
        mixpanel.track("AlpEngine comment update");
        var startId = $('#comments-container .comment').last().data('id');
        var data = { startid: startId, postid: Dashboard.comment.postid };
        $.get(Alp.config.base+'comments/poll', data)
          .success(Dashboard.comment.poll.callback)
          .always(function() {
            setTimeout(Dashboard.comment.poll.ajax, Dashboard.comment.poll.interval);
          });
      },
      callback: function(data) {
        if(!data.success) {
          if(data.error_word === 'login') {
            window.location.href = Alp.config.base + 'login';
            return false;
          }
          Alp.bar('Unable to update comments. Please reload the page.');
          return false;
        }
        $(data.html).css('display','none')
                    .appendTo('#comments-container')
                    .slideDown(250, Alp.timeago);
      }
    },
    reply: function(e) {
      var textarea = $('#post-comment textarea');
      var current_text = textarea.val();
      var username = $(this).data('username');
      var append = '';
      if(current_text.match(/@(\w+)\:/)) {
        append = "\n";
      }
      append += "@"+username+": ";
      textarea.focus().val(current_text+append).trigger('autosize.resize');
      e.preventDefault();
    }
  }

};

$(function() {
  Dashboard.init();
});