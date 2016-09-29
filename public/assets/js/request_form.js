$(document).ready(function()
{
       //Show results
        function showValues() {
            var fields = $(":input").serializeArray();
            alert("fields: " + fields);
            postData(fields);
        }
        // JQuery Ajax function for sending data through POST method
        function postData(sent_data)
        {

            $.ajax({ //make ajax request
                        url: '/request',
                        type: 'POST',
                        dataType: 'json',
                        data: sent_data
                 }).done(function (data)
            { //on Ajax success
                console.log(data);
                $('div #showResponse').html(data.message);
            }).fail(function (data) { });
        }
        // Show elements in DOM on click action
        $(":input").change(showValues);
        // Update elements in DOM
        $("select").change(showValues);
});
