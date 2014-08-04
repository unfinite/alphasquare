/*
 * Dashboard JavaScript
 * Created 8/3/2014; Updated 8/4/2014
 *
 * Contributors:
 * - Nathan Johnson
 *
 */

var Dashboard = {
	init: function() {
		Dashboard.bind();
		Dashboard.post.bind();
	},
 	bind: function() {
 		$('#post-bar').submit(Dashboard.post.start);
 	},
 	post: {
 		start: function(e) {
			var content = $('input', this).val();
			Dashboard.post.ajax(content);
			e.preventDefault();
			return false;
		},
		ajax: function(content) {
			var formData = { content: content };
			$('#post-bar input').prop('disabled', true);
			$.post(Alp.config.base+'debate/create', formData, Dashboard.post.ajaxCallback);
		},
		ajaxCallback: function(data) {
			$('#post-bar input').prop('disabled', false).val('');
			$(data.postHtml).css('display','none')
											.prependTo('#posts')
											.delay(300)
											.slideDown(350, Dashboard.post.bind);
		},
		bind: function() {
			$('.timeago').timeago();
		}
	}
};

$(function() {
	Dashboard.init();
});