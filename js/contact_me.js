$(function() {

    $('#contactForm').on('submit',function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url : 'mail/sendMessage.php',
            data : new FormData(this),
            processData: false,
            contentType: false,
            beforeSend : function(){

            },
            success : function(data){
                console.log(data)
                if(data.status === "ok"){
                    // Success message
                    $('#success').html("<div class='alert alert-success'></div>");
                    $('#success > .alert-success').append("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
                    $('#success > .alert-success').append("<strong>"+data.message+"</strong>");

                    //clear all fields
                    $('#contactForm').trigger("reset");
                    grecaptcha.reset();
                }
                else{
                    // Fail message
                    $('#success').html("<div class='alert alert-danger'></div>");
                    $('#success > .alert-danger').append("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>");
                    $('#success > .alert-danger').append("<strong>"+data.message+"</strong>");
                }
            },
            error : function(){
                // Fail message
                $('#success').html("<div class='alert alert-danger'>");
                $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                    .append("</button>");
                $('#success > .alert-danger').append("<strong>Sorry, it seems that my mail server is not responding. Please try again later!");
                $('#success > .alert-danger').append('</div>');
                //clear all fields
                $('#contactForm').trigger("reset");
            }
        });
    });

    $("a[data-toggle=\"tab\"]").click(function(e) {
        e.preventDefault();
        $(this).tab("show");
    });
});


/*When clicking on Full hide fail/success boxes */
$('#name').focus(function() {
    $('#success').html('');
});
