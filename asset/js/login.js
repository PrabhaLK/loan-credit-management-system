(function ($) {
    "use strict";

    /*==================================================================
    [ Focus input ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })

    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });

    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
            hideValidate(this);
        });
    });

    function validate(input) {
        if($(input).attr('name') == 'nic') {
            var nicNumber = $(input).val().trim();
            // Validate NIC format
            if (nicNumber.length === 9) {
                // NIC with 'V' format: e.g., 991242121V
                if (!nicNumber.match(/^\d{9}[V]$/)) {
                    return false;
                }
            } else if (nicNumber.length === 12) {
                // NIC without 'V' format: e.g., 198712345678
                if (!nicNumber.match(/^\d{12}$/)) {
                    return false;
                }
            } else {
                return false; // NIC length should be either 9 or 12 characters
            }
        }
        else if($(input).attr('name') == 'pass') {
            // Password validation logic can remain the same
            if($(input).val().trim() == ''){
                return false;
            }
        }
        return true;
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();
        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();
        $(thisAlert).removeClass('alert-validate');
    }

    /*==================================================================
    [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('zmdi-eye');
            $(this).find('i').addClass('zmdi-eye-off');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').addClass('zmdi-eye');
            $(this).find('i').removeClass('zmdi-eye-off');
            showPass = 0;
        }
    });

})(jQuery);
