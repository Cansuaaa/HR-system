$("#descriptionForm").submit(function(e){
	var url = "/ajax/description";
        tinymce.triggerSave();
	$.ajax({
		type: "POST",
		url: url,
		data: $("#descriptionForm").serialize(),
		dataType: "json",
		success: function(data){
			if (data.error == true ) {
				$('#successMessage').hide();
				$('#errorMessage').html( data.message ).fadeTo(1,1000);

			} else {
				$('#errorMessage').hide();
				$('#successMessage').html( data.message ).fadeTo(1,1000);
			}
		}
	});
	
	e.preventDefault();

});