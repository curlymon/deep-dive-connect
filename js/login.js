/**
 * Login Javascript form
 *
 * @autor Marc Hayes <marc.hayes.tech@gmail.com>
 */
$(document).ready(function()
{
	$("#login-form").validate(
		{
			rules: {
				email: {
					email: true,
					required: true
				},
				password: {
					required: true
				}
			},

			messages: {
				email: {
					email: "Please enter a valid email.",
					required: "Please enter your email."
				},
				password: {
					required: "Please enter your password."
				}
			}
		});
});