$(function()
{
    //sending notifications every 5 seconds
    // setInterval(manageNotifications, 5000);

    //method for sending notifications
    function manageNotifications()
    {
        $.ajax
        ({
            url: '/notify',
            method: 'POST',
            dataType: 'json',
            success: function(data)
            {
                var status = data.status;

                if(status == true)
                {
                        $('#notifmessage').html("New notifications!");

                        //getting the elements from the returned json object
                        var name = data.notif.name;
                        var desc = data.notif.description;
                        var time = data.notif.name;

                        //setting a notification in the notification bar
                        $("#after").before('<li class="list-group-item">' +
                            '<a href="#" class="user-list-item">'+
                            '<div class="icon bg-info">'+
                            '<i class="zmdi zmdi-account"></i>'+
                            '</div>'+
                            '<div class="user-desc">' +
                            '<span class="name">' + name + '</span>'+
                            '<span class="desc">' + desc + '</span>'+
                            '<span class="time">' + time + '</span>'+
                            '</div></a></li>');

                }
                else if(status == false)
                {
                    $('#notifmessage').html("No new notifications!");
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log('error', errorThrown);
            }
        });
    }
});
