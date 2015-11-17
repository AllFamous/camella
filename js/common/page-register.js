(function($){
    $(document).ready(function(){

        var ajaxurl = $('body').data('admin-url') + 'admin-ajax.php';

        $('#register-submit').on('click', function(){
            var regUsername = $('#regUsername').val();
            var regEmailAddress = $('#regEmailAddress').val();
            var regFirstName = $('#regFirstName').val();
            var regLastName = $('#regLastName').val();
            var regUserType = $('#regUserType').select2('val');
            var region = $('#regState').val();
            var city = $('#regCity').val();
            var the_form = $('#registration-form form, #registration-form .panel-footer');
            
            var fieldsError = [];
            if (regUsername == ''){ fieldsError.push('Username'); }
            if (regEmailAddress == ''){ fieldsError.push('Email Address'); } else {
                var result = $.validateEmail(regEmailAddress);
                if (result == false){ fieldsError.push('Enter a valid email address.'); }
            }
            if (regFirstName == ''){ fieldsError.push('First Name'); }
            if (regLastName == ''){ fieldsError.push('Last Name'); }
            if (regUserType == ''){ fieldsError.push('User Type'); }
            // send error
            if (fieldsError.length >= 1){
                $.showAlert($('.register-notice'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
            } else {
                $.showLoadingButton($('#register-submit'));
                var dataSend = {
                    'action': 'register-user',
                    'regUsername': regUsername,
                    'regFirstName': regFirstName,
                    'regLastName': regLastName,
                    'regEmailAddress': regEmailAddress,
                    'regUserType': regUserType,
                    'region' : region,
                    'city' : city
                }
                $.ajax({
                    url: ajaxurl,
                    dataType: 'JSON',
                    data: dataSend,
                    success: function(data){
                        $.removeLoadingButton($('#register-submit'));
                        if (data == 1){
                                the_form.slideUp();
                                $('.register-notice').html(
                                        '<div class="alert alert-success" role="alert">'
                                        + '<h3>Success</h3>'
                                        + '<p>Congratulations, you are now registered. Please check your email for your login details.</p>'
                                );
                                //$.showAlert($('.register-notice'), 'success', 'Success', 'Congratulations, you are now registered. Please check your email for your login details.', false);
                                
                        } else {
                            $.showAlert($('.register-notice'), 'danger', 'Error', 'The username and/or email you nominated already exists. Please use a different one and try again.', false);
                        }
                    }
                });
            }
        });
    });
}(jQuery));