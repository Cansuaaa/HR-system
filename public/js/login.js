
$("#loginForm").submit(function(e){

		var url = "/ajax/login";
		$.ajax({
			type: "POST",
			url: url,
			data: $("#loginForm").serialize(),
			dataType: "json",
			success: function(data)
			{
				if (data.error === false) {
					window.location.replace(data.redirectTo);
				} else {
					alert(data.message);
				}
			}
		});
		e.preventDefault();
});

// Validate Email format and check for empty password field
$( "#loginSubmit" ).click(function() {

	var email 	 = $("#loginEmail").val();
	var pass  	 = $("#loginPass").val();
	var isDataValid = true;

	email = $.trim(email);

	if(email == "") {

	  	$("errorLoginEmail").html("Email is empty");
		$("#errorLoginEmail").fadeTo(1500,1);
		isDataValid = false;
  	}

  	if ( !isEmail(email) ) {

  		$("#errorLoginEmail").html("Email is not valid");
  		$("#errorLoginEmail").fadeTo(1500,1);
  		isDataValid = false;
  	}

  	if ($.trim(pass) == "") {

  		$("#errorLoginPass").html("Password is empty");
		$("#errorLoginPass").fadeTo(1500,1);
		isDataValid = false;
  	}

	setTimeout(disappear,3500);

  	if(isDataValid){

  		return true;
  	}

  	return false;
  	
	function isEmail(email) {

	  		var emailRegex = /[a-zA-Z0-9_+.-]+\@[a-zA-Z0-9]+\.[a-zA-Z]+/g;
	  		return emailRegex.test(email);
	}

	function disappear() {

		$("#errorLoginEmail").fadeTo(1500,0);
		$("#errorLoginPass").fadeTo(1500,0);
	}

});

