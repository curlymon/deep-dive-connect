/**
 * Created by Steven on 12/10/2014.
 */

$(document).ready(function(){

	$("#securityOption").bind('change', function(){
		var val = document.getElementById("securityOption").value;
		if(val == "new"){
			var string = "<h3>Enter Name for New Permission</h3>"+
					"<input type=\"text\" id=\"newPermission\" name=\"newPermission\">";
			document.getElementById("newOutput").innerHTML = string;
		}
		else if(val == "delete"){
			var string = "<h3>Delete</h3><p>Enter id below and press submit</p>"+
				"<input type=\"text\" id=\"deletePermission\" name=\"deletePermission\" size=\"3\">";
			document.getElementById("newOutput").innerHTML = string;
		}
		else{
			document.getElementById("newOutput").innerHTML = "";
		}
	});

});