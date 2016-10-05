/**
 * Ajax execution.
 * @param {string} type -> HTTP request method.
 * @param {string} url  -> URL of the request.
 * @param {type} data   -> Data to be sent to the server.
 * @param {string} dataType   -> Type of data expected back from the server.
 * @param {function} serverResponse -> Function which will process the data received from the server. (Takes 1 argument)
 */
$(function () {
    $("#logTimeForm").submit(function (e) {
        $selectedItem = $("#chooseProject").find(':selected').text();
        $selectedtext = $selectedItem.trim();
        $.ajax({
            type: 'post',
            url: "/ajax/projectslogtime",
            data: $("#logTimeForm").serialize(),
            dataType: 'json',
            success: function (response) {
                if (response['error'] == false) {
                    alert(response['message']);
//                    $('#messageWrong').text(response['message']).css('color', 'green');
//                    $('#logtimeTable').append("<tr id='newLogtimeID'><td>" + $selectedtext + "</td>" +
//                        "<td>" + response.duration + " h.</td><td>" + response.calendarDate + "</td><td><i class='fa fa-trash-o deleteNewRow'> DELETE</i></td></tr>");
                } else {
                    alert(response['message']);
//                    $('#messageWrong').text(response['message']).css('color', 'tomato');
                }
            },
//            error: function (response) {
//                $('#messageWrong').text('We have problems, please try again later!').css('color', 'tomato');
//            }
        });
        e.preventDefault(e);
    });
    for (var i = 0; i < $('.details').length; i++) {
        $($('.details')[i]).on('click', function () {
            var data = {
                date: $($(this).closest('tr').find('td')[0]).text(),
            };
            console.log(data);
            $.ajax({
                type: 'GET',
                dataType: 'json',
                data: data,
                url: '/ajax/projectslogtime/GetInfo',
                success: function () {
                    
                },
                error: function () {
                    
                }
            })
        })
    }
});

//$(function () {
//    $(document).on('click', '.deleteNewRow', function () {
//        $(this).closest('tr').remove();
//
//        $.ajax({
//            type: 'post',
//            url: "/ajax/projectslogtime",
//            data: "",
//            dataType: 'json',
//            success: function (response) {
//
//            },
//            error: function (response) {
//
//            }
//        });
//    });
//});

function serverTableDeletionResponse(response) {
    if (!response.error) {
        $('#' + response.success).remove();
    }
}
