(function($) {
    "use strict";

    $('[data-toggle="popover"]').popover();
    $('.popover-dismiss').popover({
        trigger: 'focus'
    });

    $(".threadInput").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: 'post',
            url: 'thread.php',
            data: $('.threadInput').serialize(),
            success: function(res) {
                if (res.response == "success") {
                    Swal.fire({
                        type: 'success',
                        title: "Success",
                        text: "You have left a comment on the thread",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: "Sorry, something went wrong",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        location.reload();
                    })
                }
            }
        });

    });



    /*==================================================================
    [ Focus Contact2 ]*/
    $('.input100').each(function() {
        $(this).on('blur', function() {
            if ($(this).val().trim() != "") {
                $(this).addClass('has-val');
            } else {
                $(this).removeClass('has-val');
            }
        })
    })


    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit', function(e) {
        e.preventDefault();
        var check = true;
        // for(var i=0; i<input.length; i++) {
        //     if(validate(input[i]) == false){
        //         showValidate(input[i]);
        //         check=false;
        //     }
        // }
        console.log($('form').serialize())
        check ? authenticate($('form').serialize()) : check;
    });

    $(".toggle").on('click', function() {



        if ($(".toggleInput").val() == "login") {
            $(".toggleInput").val("signup");
            $(".buttonInput").text("Sign Up");
            // $(".rmbInput").slideUp("slow");
            // $(".forgotpwInput").slideUp("slow");
            $(".nameInput").show("slow");
            $(".phoneInput").show("slow");
            $(".emailInput").show("slow");

            $(".loginTitle").text("Sign Up to Continue");

        } else {
            $(".toggleInput").val("login");
            $(".buttonInput").text("Log In");
            // $(".rmbInput").slideDown("slow");
            // $(".forgotpwInput").slideDown("slow");
            $(".nameInput").hide("slow");
            $(".phoneInput").hide("slow");
            $(".emailInput").hide("slow");
            $(".loginTitle").text("LogIn to Continue");
        }

        // $(".toggleInput")



    });

    function signUp() {


    }

    // function toggle(){
    //     alert("toggle")
    // }


    function jsUcfirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function authenticate(inputs) {
        console.log(inputs)
        $.ajax({
            type: 'post',
            url: 'auth.php',
            data: inputs,
            success: function(res) {
                // alert(res)
                if (res.response == "success") {
                    console.log(res)
                    Swal.fire({
                            // position: 'top-end',
                            type: 'success',
                            title: "Hi, " + jsUcfirst(res.data[0].name) + "!",
                            text: "Redirecting you to your homepage",
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            window.location.href = "/home.php";
                        })
                        // alert(JSON.stringify(res))
                } else {
                    Swal.fire({
                            // position: 'top-end',
                            type: 'error',
                            title: 'Wrong credential',
                            text: "Sorry, we couldn\'t find you in our database",
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            window.location.href = "/login.php";
                        })
                        // alert(JSON.stringify(res))
                }
            }
        });
    }

    $('.validate-form .input100').each(function() {
        $(this).focus(function() {
            hideValidate(this);
        });
    });

    function validate(input) {
        if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        } else {
            if ($(input).val().trim() == '') {
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }


})(jQuery);