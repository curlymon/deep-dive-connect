<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano GMedranoCode@gmail.com
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone hi@oofolio.com
 *
 */

// verify that only siteAdmin can use this page
$admin = isset($_SESSION["security"]["siteAdmin"]) ? $_SESSION["security"]["siteAdmin"] : false;

// relocates user to index if not logged in or not a siteAdmin
if(empty($_SESSION["profile"]["profileId"]) === true || $admin !== 1) {
	header("Location: index.php");
}


echo "<h3>Admin Dashboard</h3><br>";
echo "<p><a href=\"admin.php\">Edit Permissions</p>";
echo "<p><a href=\"adminCohort.php\">Add/Delete Cohorts</a>";