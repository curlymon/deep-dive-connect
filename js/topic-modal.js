$(document).ready(function()
{
	$("#topicModalForm").validate(
		{
			rules: {
				topicSubject: {
					required: true
				},
				topicBody: {
					required: true
				}
			},

			messages: {
				topicSubject: {
					required: "Please enter a topic subject."
				},
				topicBody: {
					required: "Please enter a topic body."
				}
			}
		});

	$("#commentModalForm").validate(
		{
			rules: {
				commentSubject: {
					required: true
				},
				commentBody: {
					required: true
				}
			},

			messages: {
				commentSubject: {
					required: "Please enter a topic subject."
				},
				commentBody: {
					required: "Please enter a topic body."
				}
			}
		});
});

function populateTopicModal(){
	$('#topicModal').show();
}

function dePopulateTopicModal(){
	$('#topicModal').hide();
}

function populateCommentModal(btnId){
	if (btnId !== 0) {
		document.getElementById('commentSubject').value = document.getElementById('subject'.concat(btnId)).value;
		document.getElementById('commentBody').value = document.getElementById('body'.concat(btnId)).value;
		document.getElementById('commentCommentId').value = document.getElementById('commentId'.concat(btnId)).value;
	}
	$('#commentModal').show();
}

function dePopulateCommentModal(){
	document.getElementById('commentSubject').value = "";
	document.getElementById('commentBody').value = "";
	document.getElementById('commentCommentId').value = "";
	$('#commentModal').hide();
}