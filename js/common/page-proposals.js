(function($){
    $(document).ready(function(){

        var ajaxurl = $('body').data('admin-url') + 'admin-ajax.php';

        $('#proposals-submit').on('click', function(){
            var firstName = $('#firstName').val();
            var middleName = $('#middleName').val();
            var lastName = $('#lastName').val();
            var completeAddress = $('#completeAddress').val();
            var telNumber = $('#telNumber').val();
            var mobileNumber = $('#mobileNumber').val();
            var emailAddress = $('#emailAddress').val();
            var message = $('#message').val();

            var fieldsError = [];
            if (firstName == ''){ fieldsError.push('First Name'); }
            if (lastName == ''){ fieldsError.push('Last Name'); }
            if (completeAddress == ''){ fieldsError.push('Complete Address'); }
            if (mobileNumber == ''){ fieldsError.push('Mobile Number'); }
            if (emailAddress == ''){ fieldsError.push('Email Address'); } else {
                var result = $.validateEmail(emailAddress);
                if (result == false){ fieldsError.push('Enter a valid email address.'); }
            }
            if (message == ''){ fieldsError.push('Message'); }
            // send error
            if (fieldsError.length >= 1){
                $.showAlert($('.register-notice'), 'danger', 'Error', 'Please enter or select the following:', fieldsError);
            } else {
                $.showLoadingButton($('#proposals-submit'));
                var formDetails = {
                    'emailDetails': {
                        'emailType': 'data',
                        'toEmailAddress': 'roy@allfamous.com',
                        'toFullName': 'Roy Yap',
                        'fromEmailAddress': ''+emailAddress+'',
                        'fromFullName': ''+firstName+' '+lastName+'',
                        'emailSubject': 'Contact Proposals',
                        'emailBodyHeader': 'This user wants to submit a proposal to Camella. Contact detals are below:'
                    },
                    'emailContent': {
                        'firstName': ['First Name', firstName ],
                        'middleName': ['Middle Name', middleName ],
                        'lastName': ['Last Name', lastName ],
                        'completeAddress': ['Complete Address', completeAddress ],
                        'telNumber': ['Telephone Number', telNumber ],
                        'mobileNumber': ['Mobile Number', mobileNumber ],
                        'emailAddress': ['Email Address', emailAddress ],
                        'message': ['Message', message ],
                    }
                }
                var dataSend = {
                    'action': 'send-email',
                    'formDetails': formDetails
                }
                $.ajax({
                    url: ajaxurl,
                    dataType: 'JSON',
                    data: dataSend,
                    success: function(data){
                        $.removeLoadingButton($('#proposals-submit'));
                        if (data == true){
                            $.showAlert($('.proposals-notice'), 'success', 'Success', 'Your email has been sent. Please wait for at least 24 hours for us to get back to you.', false);
                        } else {
                            $.showAlert($('.proposals-notice'), 'danger', 'Error', 'There has been an error, plese try again later.', false);
                        }
                    }
                });
            }
        });


    });
}(jQuery));