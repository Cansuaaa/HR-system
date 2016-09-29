$(function () {
    $('#notes').click(function () {
        $('#notesBackgroundResources').fadeIn();
        $("#notesBackgroundText").slideToggle('slow');
    });
    $('#cancelDialogNoticeAdd').click(function () {
        $('#notesBackgroundResources').fadeOut();
        $("#notesBackgroundText").fadeOut();
    });
    $('#notesBackgroundResources').click(function () {
        $('#notesBackgroundResources').fadeOut();
        $("#notesBackgroundText").fadeOut();
    });
});
$('#acceptlDialogNoticeAdd').on("click", function () {
    $name = $('#makeNotesName').val();
    $email = $('#makeNotesEmail').val();
    $note = $('#textNotice').val();
    if ($name == "" && $email == "" && $note == "") {
        $('#messageWrongNotes').text('Must fill every field!');
    } else {
        $('#messageWrongNotes').text('');
        $myData = {
            name: $name,
            email: $email,
            description: $note
        };
    }
    $.ajax({
        type: "POST",
        url: "/sendNotesToManagerPost",
        data: $myData,
        success: function (response) {
            $data = JSON.parse(response);
            if ($data['boolean']) {
                $('#messageWrongNotes').text("");
                $('#makeNotesName').val("");
                $('#makeNotesEmail').val("");
                $('#textNotice').val("");
                $('#notesBackgroundResources').fadeOut();
                $("#notesBackgroundText").fadeOut();
                $('#sendNoteToManagerSuccess').fadeIn('fast').delay(2000).fadeOut('slow');
            } else {
                $('#messageWrongNotes').text($data['message']);
            }
        },
        error: function () {
            $('#messageWrongNotes').text('We have a problem, please try again later.');
        }
    });
});