/* Security - Report Suspicious Events */
var ReportEvents = function() {
  var config = {
    url: Alp.config.base+'settings/report_events'
  };
  var reportEvents = $('#report-events');
  var reportLink = $('#report-events-link');
  var reportBtn = $('#report');
  var cancelBtn = $('#report-events button.cancel');
  var checkboxContainers = $('th.check,td.check');
  var checkboxes = $('input', checkboxContainers);

  var toggle = function() {
    reportEvents.stop().slideToggle();
    checkboxContainers.toggleClass('hidden');
    return false;
  };
  reportLink.click(toggle);
  cancelBtn.click(toggle);

  var getIds = function() {
    var ids = $('.check input:checked').map(function() {
      return this.value;
    }).get().join(',');
    return ids;
  };

  var uncheckAll = function() {
    checkboxes.prop('checked',false);
  };

  var report = function() {
    var ids = getIds();
    var callback = function(data) {
      if(!data.success) {
        Alp.bar(data.error);
        return false;
      }
      bootbox.dialog({
        title: 'Reported',
        message: 'Thanks, we have received your report and will look into it shortly.',
        buttons: {
          main: {
            label: 'Close'
          }
        },
        size: 'small'
      });
      toggle();
      uncheckAll();
    };
    $.post(config.url, { ids: ids }, callback);
  };
  reportBtn.click(report);

};

$(function() {
  ReportEvents();
});

