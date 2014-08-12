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
        Alp.bar('Sorry, an error occurred. Please try again later.');
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
  }

};