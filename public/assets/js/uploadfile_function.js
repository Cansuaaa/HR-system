$('#formInput').submit(function(e) {
    var myForm = document.forms.namedItem('myForm');
    var newData = new FormData(myForm);
    $.ajax({
        type: "POST",
        url: '/timeoff',
        data: newData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $myData = JSON.parse(data);
            $status = $myData['status'];
            $message = $myData['message'];
            if($status == true) {
                $('#messageWrongFields').text($message)
                    .css({"font-size": "22px", "color": "lawngreen"});
                $('.containerTable').show();
                var offdays = $myData['offdays'];
                for(var i = 0; i < offdays.length; i++) {
                    for(var j = 0; j < offdays[i].approvers.length; j++)
                    {
                        var type = offdays[i].type;
                        var from = offdays[i].from;
                        var to = offdays[i].to;
                        var description = offdays[i].description;
                        var approvers = offdays[i].approvers[j];

                        $('.approvers').append("<div>" + approvers + "</div>");
                        $('#fromd').html(from);
                        $('#tod').html(to);
                        $('#timeofftype').html(type);
                        $('#timeoffdescr').html(description);
                        $('#timeoffappr').append("<div>" + approvers + "</div>");
                    }
                }
            } else {
                $('#messageWrongFields').text($message)
                    .css({"font-size": "22px", "color": "tomato"});
            }
        }
    });
    e.preventDefault();
});