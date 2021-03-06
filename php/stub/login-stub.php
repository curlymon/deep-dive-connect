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
require_once("php/lib/csrf.php");

echo "<script type=\"text/javascript\" src=\"js/login.js\"></script>
<aside class=\"col-sm-3 col-xs-12\">
	<form name=\"login\" id=\"login-form\" action=\"php/form-processor/login-form-processor.php\" method=\"POST\" accept-charset=\"utf-8\">
		<div class=\"col-sm-12 hidden-xs input-group input-group-xs\">
			<h4><strong>Login</strong></h4>
		</div>
		<div class=\"col-sm-12 col-xs-4\">
			<input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"yourname@email.com\" required>
		</div>
		<div class=\"col-sm-12 col-xs-4\">
			<input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"password\" required>
		</div>";
echo generateInputTags();
echo "		<div class=\"col-sm-12 col-xs-4\">
			<button id=\"loginBtn\" type=\"submit\" class=\"btn btn-primary btn-sm\" name=\"submit\">Login</button>
		</div>
	</form>
	<form name=\"signUp\" id=\"signup-form\" action=\"signupForm.php\">
		<div class=\"col-sm-12 col-xs-4\">
			<button id=\"signupbtn\" type=\"submit\" class=\"btn btn-primary btn-sm\" name=\"submit\">Sign-up</button>
		</div>
	</form>
</aside>";