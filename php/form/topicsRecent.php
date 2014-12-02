<?php
session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../class/topic.php");

$mysqli = MysqliConfiguration::getMysqli();

$topics = Topic::getRecentTopics($mysqli, 10);

if ($topics !== null) {
	foreach($topics as $index => $element) {
		echo "<p><a href=\"../html/topicMain?t=" . $element->getTopicId() . "\">" . $element->getTopicSubject() . "</a></p>";
	}
} else {
	echo "No topics currently exist.";
}
