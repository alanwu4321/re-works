(function($) {
    "use strict";

    $('[data-toggle="popover"]').popover();
    $('.popover-dismiss').popover({
        trigger: 'focus'
    });

    /*==================================================================
     Handle Comment Input */
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
    Authentication for Login */
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
                        type: 'success',
                        title: "Hi, " + jsUcfirst(res.data[0].name) + "!",
                        text: "Redirecting you to your homepage",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "/~escheer/re-works/home.php";
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Wrong credential',
                        text: "Sorry, we couldn\'t find you in our database",
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "/~escheer/re-works/login.php";
                    })
                }
            }
        });
    }

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
        check ? authenticate($('form').serialize()) : check;
    });

    $(".toggle").on('click', function() {

        if ($(".toggleInput").val() == "login") {
            $(".toggleInput").val("signup");
            $(".buttonInput").text("Sign Up");
            $(".nameInput").show("slow");
            $(".phoneInput").show("slow");
            $(".emailInput").show("slow");

            $(".loginTitle").text("Sign Up to Continue");

        } else {
            $(".toggleInput").val("login");
            $(".buttonInput").text("Log In");
            $(".nameInput").hide("slow");
            $(".phoneInput").hide("slow");
            $(".emailInput").hide("slow");
            $(".loginTitle").text("LogIn to Continue");
        }

    });


    function jsUcfirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
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