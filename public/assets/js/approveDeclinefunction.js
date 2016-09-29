$(document).ready(function()
{
    $(document).on('click', '#approve', function(e){
        var id = $(this).data('id');
            $.ajax({
                url: '/approve',
                method: 'POST',
                dataType: 'json',
                data: {id: id}
            }).done(function(data) { //on Ajax success
                // alert('Success');
                $('#statusindex' + data.id).html(data.status);
                $('#statusindex' + data.id).css("background-color","#009900");
                console.log(data);
            }).fail(function(data) {
                alert('Error !');
            });
        e.preventDefault();
    });

    $(document).on('click', '#decline', function(e){
        var id = $(this).data('id');
        // if(confirm("Are you sure you want to decline?"))
        // {
        $.ajax({
            url: '/decline',
            method: 'POST',
            dataType: 'json',
            data: {id: id}
        }).done(function(data) { //on Ajax success
            // alert('Success');
            $('#statusindex' + data.id).html(data.status);
            $('#statusindex' + data.id).css("background-color","red");
        }).fail(function(data) {
            alert('Error !');
        });
        // }
        e.preventDefault();
    });
});
