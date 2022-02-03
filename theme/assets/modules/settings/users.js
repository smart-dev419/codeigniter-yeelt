$(document).ready(function() {
    $('#processInvite').on("submit", function(e) {
        e.preventDefault();

        var js_app_url = $('#js_site_url').val();
        var formdata = $(this).serialize();

        $('.has-loader').addClass('has-loader-active');

        $.ajax({
            url: js_app_url + 'settings/users/user_invite',
            data: formdata,
            type: 'POST',
            success: function(data) {
                $('.has-loader').removeClass('has-loader-active');

                Swal.fire(
                    'Invited',
                    'User is invited and notified by email',
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