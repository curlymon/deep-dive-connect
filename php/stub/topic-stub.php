<?php
require_once("php/lib/csrf.php");
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/topic.php");
require_once("php/class/comment.php");

try {
	$mysqli = MysqliConfiguration::getMysqli();

	// Grab and sanitize all the super globals
	$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;
	$canEditOther = isset($_SESSION["security"]["canEditOther"]) ? $_SESSION["security"]["canEditOther"] : false;
	$topicId = filter_input(INPUT_GET,"topic",FILTER_VALIDATE_INT);

	if ($topicId < 1) {
		throw (new UnexpectedValueException("Not a valid Topic Id"));
	}

	// get topic from database
	$topic = Topic::getTopicByTopicId($mysqli, $topicId);

	echo "<script src=\"js/topic-modal.js\"></script>
	<div class=\"modal\" id=\"topicModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modal\" aria-hidden=\"true\">
		<div class=\"modal-dialog\">
			<div class=\"modal-content\">
				<div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\" onclick=\"dePopulateTopicModal();\">&times;</button>
					<h4 class=\"modal-title\" id=\"topicModalLabel\">Topic:</h4>
				</div>
				<form id=\"topicModalForm\" method=\"POST\" action=\"php/form-processor/topic-new-edit.php\">
					<div class=\"modal-body\">";
	echo generateInputTags();
		echo "<label for=\"topicSubject\">Subject: </label><br />
						<textarea id=\"topicSubject\" name=\"topicSubject\" class=\"form-control\" rows=\"2\" maxlength=\"256\">" . $topic->getTopicSubject() . "</textarea><br />
						<label for=\"topicBody\">Body: </label><br />
						<textarea id=\"topicBody\" name=\"topicBody\" class=\"form-control\" rows=\"10\" maxlength=\"4096\">" . $topic->getTopicBody() . "</textarea><br />
						<input id=\"topic\" name=\"topic\" type=\"hidden\" value=\"" . $topicId . "\">
					</div>
					<div class=\"modal-footer\">
						<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\" onclick=\"dePopulateTopicModal();\">Close</button>
						<button type=\"submit\" id=\"modTopicSubmit\"  class=\"btn btn-primary\">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>";

	echo "<div class=\"modal\" id=\"commentModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modal\" aria-hidden=\"true\">
		<div class=\"modal-dialog\">
			<div class=\"modal-content\">
				<div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\" onclick=\"dePopulateCommentModal();\">&times;</button>
					<h4 class=\"modal-title\" id=\"commentModalLabel\"> Comment:</h4>
				</div>
				<form id=\"commentModalForm\" method=\"POST\" action=\"php/form-processor/comment-new-edit.php\">
					<div class=\"modal-body\">";
	echo generateInputTags();
	echo "<label for=\"commentSubject\">Subject: </label><br />
						<textarea id=\"commentSubject\" name=\"commentSubject\" class=\"form-control\" rows=\"2\" maxlength=\"256\"></textarea><br />
						<label for=\"commentBody\">Body: </label><br />
						<textarea id=\"commentBody\" name=\"commentBody\" class=\"form-control\" rows=\"10\" maxlength=\"4096\"></textarea><br />
						<input id=\"commentTopicId\" name=\"commentTopicId\" type=\"hidden\" value=\"" . $topicId . "\">
						<input id=\"commentCommentId\" name=\"commentCommentId\" type=\"hidden\">
					</div>
					<div class=\"modal-footer\">
						<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\" onclick=\"dePopulateCommentModal();\">Close</button>
						<button type=\"submit\" id=\"modCommentSubmit\"  class=\"btn btn-primary\">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>";

	if ($topic !== null) {
		// prep topic
		$html =	"<div class=\"row test-unit-topic\">" .
			"<h2><strong>" . $topic->getTopicSubject() . "</strong></h2><br>" .
			"<p>" . nl2br($topic->getTopicBody()) . "</p>";

		// if topic is owner by user or is viewed by someone with edit other
		if ($profileId === $topic->getProfileId() || $canEditOther === 1) {
			$html = $html . "<button type=\"submit\" class=\"btn btn-sm btn-right\" data-toggle=\"modal\" data-target=\"#topicModal\" onclick=\"populateTopicModal();\">Edit Topic</button>";
		}

		$html =	$html . "</div>";
		// send this back to calling JS
		echo $html;

		try {
			if ($topicId < 1) {
				throw (new UnexpectedValueException("Not a valid Topic Id"));
			}

			// get topic's comments from database
			$comments = Comment::getCommentsByTopicId($mysqli, $topicId, 100000, 1);

			// make sure we got them
			if ($comments !== null) {
				// iterate across array of received objects
				foreach($comments as $index => $element) {
					// prep comments
					$commentTopicId = $element->getTopicId();
					$commentProfileId = $element->getProfileId();
					$commentId = $element->getCommentId();
					$commentSubject = $element->getCommentSubject();
					$commentBody = $element->getCommentBody();

					$html =	"<div class=\"row test-unit-comment\"><blockquote>" .
						"<h4><strong>" . $commentSubject . "</strong></h4><br>" .
						"<h5>" . nl2br($commentBody) . "</h5>";

					// if user is owner of comment or can edit other give them a link to modify
					if ($profileId === $commentProfileId || $canEditOther === 1) {
						$html = $html .
							"<button type=\"submit\" class=\"btn btn-sm btn-right\" data-toggle=\"modal\" data-target=\"#commentModal\" onclick=\"populateCommentModal($commentId);\">Edit Comment</button>" .
							"<input id=\"commentId$commentId\" name=\"comment\" type=\"hidden\" value=\"$commentId\">" .
							"<input id=\"subject$commentId\" name=\"subject\" type=\"hidden\" value=\"$commentSubject\">" .
							"<input id=\"body$commentId\" name=\"body\" type=\"hidden\" value=\"$commentBody\">";
					}

					$html =	$html . "</blockquote></div>";

					echo $html;
				}

			} else {
				if ($profileId !== false){
					echo "<div class=\"row\"><h4>Be the first to comment on this topic!</h4></div>";
					echo	"<div class=\"row\"><button type=\"submit\" id=\"newComment\" class=\"btn btn-sm\" data-toggle=\"modal\" data-target=\"#commentModal\" onclick=\"populateCommentModal(0);\">Add Comment</button></div>";
				}
			}
			if ($profileId !== false){
				echo	"<div class=\"row\"><button type=\"submit\" class=\"btn btn-sm\" data-toggle=\"modal\" data-target=\"#commentModal\" onclick=\"populateCommentModal(0);\">Add Comment</button></div>";
			}
		} catch(Exception $exception) {
			echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load comments: " . $exception->getMessage() . "</div>";
		}
	} else {
		echo "<h1>Topic does not exist.</h1>";
	}
} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to load topic: " . $exception->getMessage() . "</div>";
}
?>