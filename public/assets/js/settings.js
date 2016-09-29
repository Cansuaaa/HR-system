$(function () {

    $('#localeSettings').submit(function(e) {
        var form_data = $(this).serialize();

        $.ajax({ //make ajax request
            url: '/settings',
            type: 'POST',
            dataType: 'json',
            data: form_data
        }).done(function(data) { //on Ajax success

            console.log(data.category);

        }).fail(function(data) {
            alert('error');
        });
        e.preventDefault();

    });

});