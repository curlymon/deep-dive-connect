$(document).ready(function() {
	var topicId;
	topicId = getUrlParameter('t');

	$(".addComment").html("<div class=\"row\"><a href=\"../html/comment-new-edit.html?t=" + topicId + "\">Comment on this Topic.</a></div>");

	$.ajax({
		url    : '../php/form/topicMainTopic.php?t=' + topicId,
		success: function(ajaxOutput) {
			$("#topic").html(ajaxOutput);
			if(ajaxOutput !== "<h1>Topic does not exist.</h1>") {
				$.ajax({
					url    : '../php/form/topicMainComments.php?t=' + topicId,
					success: function(ajaxOutput) {
						$("#comments").html(ajaxOutput);
					}
				});
			}
		}
	});
});

function getUrlParameter(sParam)
{
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++)
	{
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam)
		{
			return sParameterName[1];
		}
	}
}