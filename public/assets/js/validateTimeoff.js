$(function()
{
    $("#formInput").submit(function(e){

        var from = $("#from").val();
        var to = $("#to").val();
        var type = $("#type").val();
        var approvers = $("#approvers").val();
        var descr = $("#descriptionArea").val();

        if(type == "" || to == "" || type == "Choose" || approvers == "" || descr == "" )
        {
            alert("Please fill all the fields!");
            $('.error').show();
            $("#validation").show();
            $("#success").hide();
            e.preventDefault();
        }
        else
        {
            $("#validation").hide();
            $("#success").show();
            
        }
    });
});
