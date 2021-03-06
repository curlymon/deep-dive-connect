<?php
/**
 * Created in collaboration by:
 *
 * @author Gerardo Medrano <GMedranoCode@gmail.com>
 * @author Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * @author Steven Chavez <schavez256@yahoo.com>
 * @author Joseph Bottone <hi@oofolio.com>
 *
 */

//If session is new or session timed out show login if not show profile
$firstName = isset($_SESSION["profile"]["firstName"]) ? $_SESSION["profile"]["firstName"] : false;
$lastName = isset($_SESSION["profile"]["lastName"]) ? $_SESSION["profile"]["lastName"] : false;
$location = isset($_SESSION["profile"]["location"]) ? $_SESSION["profile"]["location"] : false;
$description = isset($_SESSION["profile"]["description"]) ? $_SESSION["profile"]["description"] : false;
$fileName = isset($_SESSION["profile"]["profilePicFilename"]) ? $_SESSION["profile"]["profilePicFilename"] : false;

// assciate array of the cohort session
$cohort["startDate"] = isset($_SESSION["cohort"]["startDate"]) ? $_SESSION["cohort"]["startDate"] : false;
$cohort["endDate"] = isset($_SESSION["cohort"]["endDate"]) ? $_SESSION["cohort"]["endDate"] : false;
$cohort["location"] = isset($_SESSION["cohort"]["location"]) ? $_SESSION["cohort"]["location"] : false;
$cohort["description"] = isset($_SESSION["cohort"]["description"]) ? $_SESSION["cohort"]["description"] : false;
echo "<aside class=\"col-sm-3 hidden-xs\">";

//name
echo "<p><h4><strong>" . $firstName . " " . $lastName . "</strong></h4></p>";

//profile pic
if ($fileName !== false) {
	echo "<div class=\"row\"><div class=\"col-md-6\"><img id=\"profilePic\" class=\"img-responsive\" src=\"/ddconnect/avatars/" .
		$fileName . "\" /></div></div><br>";
} else {
	echo "<div class=\"row\"><div class=\"col-md-6\"><img id=\"profilePic\" class=\"img-responsive\" src=\"resources/avatar-default.png\" /></div></div><br>";
}


//Always visible
echo "<a href=\"profile-edit.php\"><button class=\"btn btn-primary btn-xs \">edit-profile</button></a></p>";

//location
echo "<p><strong>Location:</strong></p>";
if($location === false) {
	echo "<p id=\"asideLoc\"><a href=\"profile-edit.php\"><button class=\"btn btn-primary btn-xs\">edit-profile</button></a></p>";
} else {
	echo "<p>" . $location . "</p>";
}

//Description
echo "<p><strong>Description:</strong></p>";
if($description === false) {
	echo "<p id=\"asideDesc\"><a href=\"profile-edit.php\"><button class=\"btn btn-primary btn-xs\">edit-profile</button></a></p>";
} else {
	echo "<p>" . $description . "</p>";
}

//Cohort
echo "<p><strong>Cohort:</strong></p>";
if($cohort["description"] === false){
	echo "<p><a href=\"cohort-edit.php\"><button class=\"btn btn-primary btn-xs\">edit-cohort</button></a></p>";
}
if($cohort["description"] !== false){
	echo "<p> " . $cohort["description"] . "</p>";
}

if($cohort["location"] !== false){
	echo "<p>" . $cohort["location"] . "</p>";
}

if($cohort["startDate"] !== false || $cohort["endDate"] !== false){
	echo "<p>" . $cohort["startDate"]. " - " . $cohort["endDate"] . "</p>";
}

//sign out
echo "<a href=\"php/form-processor/sessionDestroy.php\"><button class=\"btn btn-primary btn-xs\">Sign Out</button></a>";

echo "</aside>";
