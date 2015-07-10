$(document).ready(function()
{
    $(".table").on("click",".btn-danger",function(event)
    {
        var stop=confirm("etes-vous sur ?");
        if(stop==false)
        {
            event.preventDefault();
        }
    })
});
