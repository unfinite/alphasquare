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

  init: function(config) {
    this.setupConfig(config);
    this.bind();
    this.setupAjax();
  },

  bind: function() {
    $(document).on('click', this.closePopovers);
    $("[data-toggle='tooltip']").tooltip();
    $('.autosize').autosize({ append: "" });
    $('a[href="'+this.config.base+'login"]').click(function() {
      var href = $(this).attr('href');
      href += '?next=' + encodeURIComponent(window.location.href);
      window.location.href = href;
      return false;
    });
    this.textSwap.bind();
    this.slingshot();
    this.timeago();
  },

  timeago: function() {
    $('.timeago').timeago();
  },

  bar: function(message, type) {
    if(!type) {
      type = 'error';
    }
    $.notifyBar({
      html: message,
      cssClass: type
    });
  },

  closePopovers: function(e) {
    if (!$(e.target).is('.popover-trigger, .popover-title, .popover-content')) {
      $('.popover-trigger').popover('hide');
    }
  },

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
  }

};

/* Custom AJAX Modal
 * Uses Bootbox plugin
 *
 * Accepts an object with modal options
 *
 * Example:
 *
 *  AjaxModal({
 *   title: 'Hey there',
 *   url: 'path/to/modal',
 *   buttons: {
 *     main: {
 *       label: 'Close',
 *       className: 'btn-primary'
 *     }
 *   }
 *  });
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
    // No animation because with it, going from
    // loading to ajax loaded modal is terrible
    animate: false
  };

  var options = $.extend(defaults, options);

  // Loading modal HTML
  var loadingImg = Alp.config.base+'assets/img/spinner.gif';
  var loadingHtml = '<div class="text-center" id="modal-loading">' +
                      '<img src="'+loadingImg+'" style="width:20px;" />' +
                      'Loading, please wait...' +
                    '</div>';

  // Options for loading modal
  var loadingOptions = {
    title: options.title || 'Modal',
    message: loadingHtml,
    buttons: {
      main: {
        label: 'Close'
      }
    },
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
    // Apply autosize plugin to textareas
    $('.autosize').autosize({ append: "" }).css('max-height', 150);
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