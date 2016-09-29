function validateEmail(email) {
    $re = /[A-Za-z0-9]\w+[\.\-]?[@][a-z]{3,6}\.[a-z]{2,3}/;
    return $re.test(email);
}
function validatePassword(pass) {
    $pattern = /[A-Za-z0-9!@#$%^&*()_+-]{6,30}/;
    return $pattern.test(pass);
}
function validate() {
    $email = $("#email").val();
    $password = $('#password').val();
	if ($email !== "" && $password !== "") {
	    if (validateEmail($email)) {
			if(validatePassword($password)){
				$("#messageWron").text("");
			} else {
				$("#messageWron").text("Password is not valid!");
				$("#messageWron").css("color", "tomato");
			}
		} else {
			$("#messageWron").text("Email is not valid!");
			$("#messageWron").css("color", "tomato");
		}
	} else {
		$("#messageWron").text("Must fill every field!");
        $("#messageWron").css("color", "tomato");
	}
}
$("#formLogin").bind("submit", validate);