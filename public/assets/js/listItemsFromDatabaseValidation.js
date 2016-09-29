$(function () {
	$(document).on("click", "#btnAddDateAndTime", function () {
		$dateFrom = $('#dateFrom').val();
		$dateTo = $('#to').val();
		$absence = $('#type').val();
		$approver = $('#multiple').val();
		if ($dateFrom == false || $dateTo == false || $absence == "Choose" || $approver == null) {
			$('#messageWrongFields').text("Fields with * are required!").css("color", "tomato").css("font-size", "22px");
		} else {
			$('#messageWrongFields').text("");
		}
	});
});
$('.dropify').dropify({
    messages: {
        'default': 'Drag and drop a file here or click',
        'replace': 'Drag and drop or click to replace',
        'remove': 'Remove',
        'error': 'Ooops, something wrong appended.'
    },
    error: {
        'fileSize': 'The file size is too big (1M max).'
    }
});