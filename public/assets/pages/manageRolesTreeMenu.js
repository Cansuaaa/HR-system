$(function () {
	$path = "/assets/images/user-512.png";
	$pathNo= "/assets/images/userGray-512.png";
	$('.manager').each(function (index, val) {
		if ($(this).text() !== "") {
			$('#managersContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $path + "'><span class='col-md-11 roles'>" + $(this).text() + "</span></li>")
		}
	});
	if ($('#setRolesContainer div').hasClass('manager') == false) {
		$('#managersContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $pathNo + "'><span class='col-md-11 roles'>We don't have managers. For now!</span></li>");
	}
	$('.leader').each(function (index, val) {
		if ($(this).text() !== "") {
			$('#leadersContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $path + "'><span class='col-md-11 roles'>" + $(this).text() + "</span></li>")
		}
	});
	if ($('#setRolesContainer div').hasClass('leader') == false) {
		$('#leadersContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $pathNo + "'><span class='col-md-11 roles'>We don't have leaders. For now!</span></li>");
	}
	$('.senior').each(function (index, val) {
		if ($(this).text() !== "") {
			$('#seniorsContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $path + "'><span class='col-md-11 roles'>" + $(this).text() + "</span></li>")
		}
	});
	if ($('#setRolesContainer div').hasClass('senior') == false) {
		$('#seniorsContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $pathNo + "'><span class='col-md-11 roles'>We don't have seniors. For now!</span></li>");
	}
	$('.developer').each(function (index, val) {
		if ($(this).text() !== "") {
			$('#developerContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $path + "'><span class='col-md-11 roles'>" + $(this).text() + "</span></li>")
		}
	});
	if ($('#setRolesContainer div').hasClass('developer') == false) {
		$('#developerContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $pathNo + "'><span class='col-md-11 roles'>We don't have developers. For now!</span></li>");
	}
	$('.junior').each(function (index, val) {
		if ($(this).text() !== "") {
			$('#juniorsContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $path + "'><span class='col-md-11 roles'>" + $(this).text() + "</span></li>")
		}
	});
	if ($('#setRolesContainer div').hasClass('junior') == false) {
		$('#juniorsContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $pathNo + "'><span class='col-md-11 roles'>We don't have juniors. For now!</span></li>");
	}
	$('.intern').each(function (index, val) {
		if ($(this).text() !== "") {
			$('#internsContainer').append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $path + "'><span class='col-md-11 roles'>" + $(this).text() + "</span></li>")
		}
	});
	if ($('#setRolesContainer div').hasClass('intern') == false) {
		$('#internsContainer')
			.append("<li class='col-md-12' style='display: none;'><img class='col-md-1 pics' src='" + $pathNo + "'><span class='col-md-11 roles'>We don't have interns. For now!</span></li>");
	}
	$('#treeContainer li:last-of-type').last().css({"background": "url('/assets/images/last.png')", "background-repeat": "no-repeat"});
	$(function () {
		$name = $('#me').text();
		$('.roles').each(function (e, va) {
			if ($(this).text() == $name) {
				if ($(this).parent().is(":last-of-type")){
					$(this).parent().css({
						"background-image": "url('/assets/images/below last.png', url('/assets/images/last.png')",
						"background-color": "rgba(130, 220, 252, 0.5)",
						"background-repeat": "no-repeat",
						"border-bottom-left-radius": "15px",
						"border-bottom-right-radius": "15px",
						"border-top-right-radius": "15px",
						"color": "rgb(56, 56, 56)"
					});
				} else if ($(this).parent().is(":first-of-type")) {
					$(this).parent().css({
						"background": "url('/assets/images/vline.png') no-repeat, rgba(130, 220, 252, 0.5)",
						"border-bottom-right-radius": "15px",
						"border-top-right-radius": "15px",
						"color": "rgb(56, 56, 56)"
					});
				} else {
					$(this).parent().css({
						"background": "url('/assets/images/node.png') no-repeat, rgba(130, 220, 252, 0.5)",
						"border-bottom-right-radius": "15px",
						"border-top-right-radius": "15px",
						"color": "rgb(56, 56, 56)"
					});
				}
			}
		});
	});
});
function showManagersContainer(name) {
	$("#" + name + " li:first-of-type").attr('onclick', "hideManagersContainer('" + name + "')");
	$("#" + name + " li:first-of-type").css({"background": "url('/assets/images/opened.png'), url('/assets/images/vline.png')", "background-repeat": "no-repeat"});
	//$("#" + name + " li:last-of-type").css({"background": "url('/assets/images/last.png'), url('/assets/images/below last.png')", "background-repeat": "no-repeat"});
	$("#" + name + " li:not(:nth-of-type(1))").fadeIn('slow');
}
function hideManagersContainer(name) {
	$("#" + name + " li:first-of-type").attr('onclick', "showManagersContainer('" + name + "')");
	$("#" + name + " li:first-of-type").css({"background": "url('/assets/images/closed.png')", "background-repeat": "no-repeat"});
	$("#" + name + " li:not(:nth-of-type(1))").fadeOut('fast');
}