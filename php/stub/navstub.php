<?php

/**
 * Deep Dive Connect Navigation Stub by
 * @GMedrano, adapted from model by Marc Hayes
 *
 * From Marc's code, onloader
 * !!!!!echo "<form id=\"back\" action=\"loading.html\">
 *       <button type=\"submit\">Back</button>
 */


//Added ternary

$Admin = isset($_Session["security"]["siteAdmin"]) ? $_Session["security"]["siteAdmin"] : false;



//Code for Onloader - Navigation Bar

echo "<div class= \"btn-group btn-group-justified\">
      <a href=\"index.php\" class=\"btn btn-default\"><h4><strong>Home</strong></h4></a>";

echo "<a href=\"profile.php\" class=\"btn btn-default\"><h4><strong>Profile</strong></h4></a>";

echo "<a href=\"cohort.php\" class=\"btn btn-default\"><h4><strong>Cohort</strong></h4></a>";
if ($Admin === 1){
   echo "<a href=\"admin.php\" class=\"btn btn-default\"><h4><strong>Admin Page</strong></h4></a>";
}
echo "</div>";
