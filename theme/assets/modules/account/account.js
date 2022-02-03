$(document).ready(function() {
    $('#processAccount').on("submit", function(e) {
        e.preventDefault();
        if($('#input_password').val() !== '') {
            if($('#input_password').val() !== $('#input_password_confirm').val()) {
                Swal.fire(
                    'Error',
                    'Password and confirm password does not match',
                    'error'
                );
                return false;
            }
        }

        var js_app_url = $('#js_site_url').val();
        var formdata = $(this).serialize();

        $('.has-loader').addClass('has-loader-active');

        $.ajax({
            url: js_app_url + 'account/process_account',
            data: formdata,
            type: 'POST',
            success: function(data) {
                $('.has-loader').removeClass('has-loader-active');

                Swal.fire(
                    'Saved',
                    'Settings saved',
                    'success'
                ).then((result) => {
                    $('.modal').removeClass('show');
                    if(result.isConfirmed) {
                        window.location.reload();
                    }
                });
            },
            error: function() { }
        });
    });
});