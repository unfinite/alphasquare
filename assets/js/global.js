/**
 * The main Alphasquare JS object.
 * Has common functions and configuration info.
 * @type {Object}
 * @copright Copyright (c) 2014 Alphasquare
 */
        
var Alp = {
  config: {},
  setupConfig: function(config) {
    $.each(config, function(key, val) {
      Alp.config[key] = val;
    });
  },
  setupAjax: function() {
    $.ajaxSetup({
      error: function() {
        //Alp.bar('Sorry, an error occurred. Please try again later.');
      },
      statusCode: {
        401: function() {
          Alp.bar('Oops! You must be signed in to do that.');
        }
      }
    });
  },

  /**
   * Main Init Function
   */
  init: function(config) {
    this.setupConfig(config);
    this.origTitle = document.title;
    this.bind();
    this.setupAjax();
    this.counts.poll.start();
  },

  /** 
   * Bind click events, Slingshot, etc.
   */
  bind: function() {
    
    // Open alerts
    $('.alert-link').click(this.alerts.open);

    $(document).on('click', this.closePopovers);

    $(document).on('click', 'ul.dropdown-menu li a', function() {
      $('[data-toggle="dropdown"]').parent().removeClass('open');
    });

    // Tooltips for navbar icons
    $('.navbar .top-menu a').tooltip({ 
      placement: 'bottom'
    });

    // Mobile search
    $('.search-trigger a').click(function() {
      Alp.mobileSearch(true);
      return false;
    });
    $('#mobile-search-overlay').click(function() {
      Alp.mobileSearch(false);
    });
    $('.bottom-menu li.active').click(function(e) {
      $('.bottom-menu li').removeClass('active');
      $(this).addClass('active');
      Alp.mobileSearch(false);
      e.preventDefault();
    });

    this.slingshot();
    this.bindPlugins();
  },

  /**
   * Bind plugins
   * This is called whenever a modal box is opened
   */
  bindPlugins: function() {
    $("[data-toggle='tooltip']").tooltip();
    $('.autosize').autosize({ 
      append: "" 
    });
    $('a[href="'+this.config.base+'login"]').click(function() {
      var href = $(this).attr('href');
      href += '?next=' + encodeURIComponent(window.location.href);
      window.location.href = href;
      return false;
    });
    this.textSwap.bind();
    this.timeago();
  },

  /**
   * Update the window title
   *
   * @param {string} title The text to change the window title to.
   */ 
  updateTitle: function(title) {
    document.title = title;
  },

  /**
   * Update alerts and messages counts
   * @type {Object}
   */
  counts: {
    count: {
      total: 0,
      alerts: 0,
      messages: 0
    },
    update: function(count, type) {
      if(count.alerts === null) count.alerts = this.count.alerts;
      if(count.messages === null) count.messages = this.count.messages;
      var total = count.alerts+count.messages;
      var alerts = count.alerts > 0 ? count.alerts : '';
      var messages = count.messages > 0 ? count.messages : '';
      count.total = total;
      this.count = count;
      console.log(count);
      if(type == 'all' || type == 'alerts') {
        $('.menu-count.alerts').text(alerts);
      }
      if(type == 'all' || type == 'messages') {
        $('.menu-count.messages').text(messages);
      }
      var newTitle = total > 0 ? '(' + total + ') ' + Alp.origTitle : Alp.origTitle;
      Alp.updateTitle(newTitle);
    },
    /**
     * Update alerts count manually
     * @param  {int} count Number of unread alerts
     * @return {null}
     */
    updateAlerts: function(count) {
      this.update({ alerts: count, messages: null }, 'alerts');
    },
    /**
     * Update messages count manually
     * @param  {int} count Number of unread messages
     * @return {null}
     */
    updateMessages: function(count) {
      this.update({ alerts: null, messages: count}, 'messages');
    },
    /**
     * Poll for new alerts/messages
     */
    poll: {
      interval: 15000,
      /**
       * Start polling for counts
       */
      start: function() {
        // If user is logged in
        if(Alp.config.loggedin) {
          this.ajax();
        }
      },
      /**
       * Send the ajax request
       */
      ajax: function() {
        $.get(Alp.config.base+'dashboard/update_counts')
          .success(Alp.counts.poll.ajaxCallback)
          .always(function() {
            setTimeout(Alp.counts.poll.ajax, Alp.counts.poll.interval);
          }, 'json');
      },
      /**
       * The callback after the ajax request succeeds.
       * @param {array} data The object returned from the ajax request.
       */
      ajaxCallback: function(data) {
        if(!data.success) {
          Alp.bar(data.error);
          return false;
        }
        Alp.counts.update(data.counts, 'all');
      }
    }
  },

  /**
   * Alerts object (aka notifications)
   */
  alerts: {
    /**
     * Open the alerts modal
     */
    open: function() {
      AjaxModal({
        title: 'Alerts',
        url: 'alerts/modal',
        limitToWindowSize: true,
        backdrop: true,
        callback: function() {
          $('.alert-container .delete').click(Alp.alerts.remove.click);
          $('.alert-container .mark-read').click(Alp.alerts.markRead.click);
          $('#alerts-controls .delete-all').click(Alp.alerts.removeall.click);
          $('#alerts-controls .mark-all-read').click(Alp.alerts.markallread.click);
          Alp.counts.updateAlerts(0);
          Alp.mobileSearch(false);
        }
      });
      return false;
    },
    /**
     * Remove an alert
     */
    remove: {
      /**
       * The click event binded to the delete buttons
       */
      click: function() {
        var id = $(this).closest('.alert-container').data('id');
        Alp.alerts.remove.ajax(id);
      },
      /** 
       * Send the AJAX request
       *
       * @param {integer} id The ID of the alert to remove.
       * @return {void}
       */
      ajax: function(id) {
        var data = { id: id };
        $.post(Alp.config.base+'alerts/delete', data, this.ajaxCallback, 'json');
      },
      /**
       * The callback after the ajax request succeeds.
       *
       * @param {array} data The object returned from the ajax request.
       * @return {void}
       */
      ajaxCallback: function(data) {
        if(!data.success) {
          alert(data.error);
          return false;
        }
        // Hide the alert
        $('.alert-container[data-id="'+data.id+'"]').fadeOut(200, function() {
          $(this).remove();
          // If there aren't any alerts left, show the no alerts message
          if($('.alert-container').length < 1) {
            $('#no-alerts').removeClass('hidden');
          }
        });
      }
    },
    /**
     * Delete all the alerts
     */
    removeall: {
        /**
         * The click event binded to the delete all button
         */
        click: function() {
            Alp.alerts.removeall.ajax();
        },
        /**
         * Send the AJAX request
         */
        ajax: function() {
            $.post(Alp.config.base+'alerts/delete_all', null, this.ajaxCallback, 'json');
        },
        /**
         * The callback after the ajax request succeeds.
         * 
         * @param {array} data The object returned from the ajax request.
         * @return {void}
         */
        ajaxCallback: function(data) {
            if (!data.success) {
                alert(data.error);
                return false;
            }
            
            data.ids.forEach(function(id) {
                $('.alert-container[data-id="'+id+'"]').fadeOut(200, function() {
                    $(this).remove();
                });
            });
            
            $('#no-alerts').removeClass('hidden');
        }
    },
    /**
     * Mark a notification as read
     */
    markRead: {
      /**
       * Mark as read click event handler
       * @return {void}
       */
      click: function() {
        var id = $(this).closest('.alert-container').data('id');
        Alp.alerts.markRead.ajax(id);
      },
      /**
       * Sends the ajax request
       *
       * @param {integer} id The ID of the alert to mark as read.
       */
      ajax: function(id) {
        var data = { id: id };
        $.post(Alp.config.base+'alerts/mark_read', data, this.ajaxCallback, 'json');
      },
      /**
       * The callback after the ajax request succeeds.
       * @param {array} data The object returned from the ajax request.
       */
      ajaxCallback: function(data) {
        if(!data.success) {
          alert(data.error);
          return false;
        }
        var alert = $('.alert-container[data-id="'+data.id+'"]');
        alert.toggleClass('clicked not-clicked');
        $('.mark-read',alert).fadeOut();
      }
    },
    /**
     * Mark all notifications as read
     */
    markallread: {
        /**
         * The click event binded to the mark all read button
         */
        click: function() {
            Alp.alerts.markallread.ajax();
        },
        /**
         * Send the AJAX request
         */
        ajax: function() {
            $.post(Alp.config.base+'alerts/mark_all_read', null, this.ajaxCallback, 'json');
        },
        /**
         * The callback after the ajax request succeeds.
         * 
         * @param {array} data The object returned from the ajax request.
         * @return {void}
         */
        ajaxCallback: function(data) {
            if (!data.success) {
                alert(data.error);
                return false;
            }
            
            data.ids.forEach(function(id) {
                var alert = $('.alert-container[data-id="'+id+'"]');
                alert.removeClass('not-clicked');
                $('.mark-read',alert).fadeOut();
            });
        }
    }
  },

  /**
   * Apply timeago plugin to elements with timeago class
   */
  timeago: function() {
    $('.timeago').timeago();
  },

  /**
   * Notify/alert bar.
   * @param {string} message The message to show in the bar.
   * @param {string} className
   */
  bar: function(message, className) {
    if(!className) className = 'error';
    if(!message) message = 'An unknown error occurred.';
    $.notifyBar({
      html: message,
      cssClass: className
    });
  },

  closePopovers: function(e) {
    if (!$(e.target).is('.popover-trigger, .popover-title, .popover-content')) {
      $('.popover-trigger').popover('hide');
    }
  },

  /**
   * Text swapping on hover
   */
  textSwap: {
    bind: function() {
      $('[data-text-swap]').hover(this.mousein, this.mouseout);
    },
    mousein: function() {
      var ele = $(this);
      ele.data('text-orig', ele.html());
      ele.html($(this).data('text-swap'));
      if(ele.data('class-swap')) {
        ele.addClass(ele.data('class-swap'));
      }
    },
    mouseout: function() {
      var ele = $(this);
      ele.html(ele.data('text-orig'));
      if(ele.data('class-swap')) {
        ele.removeClass(ele.data('class-swap'));
      }
    }
  },

  slingshot: function() {
    $('.navbar.logged-in .popover-trigger').popover({
      placement: 'bottom',
      html: true,
      container: 'body',
      template: '<div class="popover" id="slingshot"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
      content: $('#slingshot-container').html()
    })
    .click(function(e) {
      e.preventDefault();
      //$(this).popup('hide');
      //$(this).popover('toggle');
    });
  },

  alertBox: function(text, type, ele) {
    $('.alert-box-js', ele).remove();
    $('<div/>').addClass('alert alert-box-js alert-'+type)
               .html(text)
               .prependTo(ele);
  },

  mobileSearch: function(show) {
    var content = $('#content');
    var search = $('#mobile-search, #mobile-search-overlay');
    var input = $('input',search);
    $('.bottom-menu li.active')
      .removeClass('active')
      .not('.search-trigger')
      .addClass('was-active');
    if(show) {
      search.addClass('in').removeClass('hide');
      input.focus();
      $('.search-trigger').addClass('active');
      $('body').bind('touchmove', function(e){e.preventDefault()});
    }
    else {
      search.removeClass('in').addClass('hide');
      $('.bottom-menu li.was-active').addClass('active');
      $('body').unbind('touchmove');
    }
  }

};

/** 
 * Custom AJAX Modal (Bootstrap modals)
 *
 * Example:
 *
 *  AjaxModal({
 *   title: 'Hey there',
 *   url: 'path/to/modal',
 *   buttons: {
 *     close: {
 *       label: 'Close',
 *       className: 'btn-default'
 *     },
 *     main: {
 *       label: 'Save',
 *       className: 'btn-primary'
 *     }
 *   }
 *  });
 *
 * @uses bootbox
 * @author Nathan Johnson
 * @param {object} options An object of options for the modal box.
 */

var AjaxModal = function(options) {
  // Hide any currently open bootbox modals
  bootbox.hideAll();

  // Error Messages
  var errors = {
    optionsNotObject: 'AjaxModal requires an options object as its first [and only] parameter.',
    couldNotLoad: 'Sorry, we were unable to load the content you requested. Please try again later.'
  };

  if(typeof options !== 'object') {
    throw new Error(errors.optionsNotObject);
  }

  // Default options
  var defaults = {
    title: 'Modal',
    prependBaseUrl: true,
    animate: false,
    size: 'normal',
    limitToWindowSize: false
  };

  var options = $.extend(defaults, options);

  // Loading modal HTML
  var loadingImg = Alp.config.base+'assets/img/spinner.gif';
  var loadingHtml = '<div class="text-center" id="modal-loading">' +
                      '<img src="'+loadingImg+'" style="width:20px;" />' +
                      '&nbsp; Loading, please wait...' +
                    '</div>';

  // Options for loading modal
  var loadingOptions = {
    title: options.title || 'Modal',
    message: loadingHtml,
    size: options.size || 'small',
    closeButton: true,
    backdrop: true,
    animate: false
  };

  // Open loading modal
  bootbox.dialog(loadingOptions);

  // Prepend base to URL
  if(options.prependBaseUrl) {
    var url = Alp.config.base + options.url;
  }
  else {
    var url = options.url;
  }

  // Success callback
  var success = function(data) {
    if(data === '') {
      data = 'Nothing to show.';
    }
    // Hide loading modal
    bootbox.hideAll();
    // Set message
    options.message = data;
    // Open the modal
    bootbox.dialog(options);
    // Limit size if option is set
    if(options.limitToWindowSize) {
      $('.modal-body').css({
        'max-height': $(window).height()*0.8,
        'overflow': 'auto'
      });
    }
    // Re-bind plugins
    Alp.bindPlugins();
    // Callback
    if(typeof options.callback === 'function') {
      options.callback();
    }
  };

  // Failure callback
  var fail = function() {
    // Hide loading modal
    bootbox.hideAll();
    // Open an error dialog
    bootbox.dialog({
      title: options.title,
      message: errors.couldNotLoad,
      buttons: {
        main: {
          label: 'Close'
        }
      },
      size: 'small',
      animate: false,
      backdrop: true
    });
  };

  // Do the AJAX request
  $.ajax({
    type: 'GET',
    url: url,
    success: success,
    error: fail
  });

};
