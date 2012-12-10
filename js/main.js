/*jslint nomen: true, unparam: true, regexp: true */
/*global $, window, document */
$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'u/',
        autoUpload: true,
        limitMultiFileUploads: 1
    });

    function closeModal(){
        $('.ok-message').hide();
        $('.shadow').hide();
        $('.template-upload').remove();
        $('.fileinput-button').show();
    }

    $('.ok-message .ok-button').click(closeModal); 

    $('#fileupload').fileupload(
        'option',
        {
            done: function (e, data) {
                $('input[name="title"]').val('');
                $('textarea[name="comment"]').val('');
                $('.ok-message').show();
                $('.shadow').show();
                $('.shadow').click(closeModal);
                
            },

            submit: function(e,data){
                if( $('input[name="title"]').val() == '' ){
                    $('.template-upload').remove();
                    alert('Пожалуйста, введите название ролика.');
                    return false;        
                }
                

                $('.fileinput-button').hide();
            },
            error: function(e,data){
                $('.fileinput-button').show();   
            },

            autoUpload: true
        }
    );

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );
});
