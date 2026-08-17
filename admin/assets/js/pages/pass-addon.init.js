/*
Template Name: Admin Panel
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Password Addon Js File
*/

// show password input value
document.getElementById('password-addon').addEventListener('click', function () {
	var passwordInput = document.getElementById("password-input");
	if (passwordInput.type === "password") {
		passwordInput.type = "text";
	} else {
		passwordInput.type = "password";
	}
});