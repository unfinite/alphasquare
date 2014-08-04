var Alp = {
  config: {},
  setupConfig: function(config) {
    $.each(config, function(key, val) {
      Alp.config[key] = val;
    });
  },
  init: function(config) {
    this.setupConfig(config);
    this.bind();
  },
  bind: function() {
    this.textSwap.bind();
    this.slingshot();
  },

  textSwap: {
    bind: function() {
      $('[data-text-swap]').hover(Alp.textSwap.mousein, Alp.textSwap.mouseout);
    },
    mousein: function() {
      $(this).data('text-orig', $(this).html());
      $(this).html($(this).data('text-swap'));
    },
    mouseout: function() {
      $(this).html($(this).data('text-orig'));
    }
  },

  slingshot: function() {
    $('.navbar.logged-in .navbar-brand').popover({
      placement: 'bottom',
      html: true,
      container: 'body',
      template: '<div class="popover" id="slingshot"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
      content: $('#slingshot-container').html()
    })
    .click(function(e) {
      e.preventDefault();
    });
  }

};