/*jslint nomen: true, unparam: true, regexp: true */
/*global $, window, document */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'u/',
        autoUpload: true
    });

   /* $('#fileupload').fileupload(
        'option',
        {
            done: function (e, data) {
                alert('done!');
            },
            error: function (e, data) {
                alert('panic!');
            },
            autoUpload: true
        }
    );*/
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
