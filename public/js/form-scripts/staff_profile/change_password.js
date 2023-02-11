$(document).ready(function () {
    const changePasswordRules = {
        errorElement: "div",
        rules: {
            password: "required",
            new_password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            password: {
                required: "Current password is required",
            },
            new_password: {
                required: "New password is required",
            },
            confirm_password: {
                required: "Confirm password is required",
                equalTo: "Your password does not match"
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#changePasswordForm").validate(changePasswordRules); // Validate

    // If Submit Form is Clicked
    $("#changePasswordForm").submit(function (e) {
        e.preventDefault();

        $("#changePasswordForm").validate(changePasswordRules);

        if (!$("#changePasswordForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        changePasswordFormSubmit();
    });

    function changePasswordFormSubmit() {
        let formData = $("#changePasswordForm").serialize();

        $.ajax({
            type: "POST",
            url: `/staff_profile/change_password`,
            data: formData,
            success: function (response) {

                if (response.status === 400) {

                    if (response.is_password_wrong) {
                        $('#password_error').show();
                        $('#password_error').html('<span>Your current password is wrong</span>');
                        $('#password').addClass('is-invalid');
                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: "Failed",
                            text: response.msg,
                        });
                    }

                } else {
                    Swal.fire("Updated!", response.msg, "success");
                    $('#changePasswordModal').modal("hide");
                    $('#changePasswordModal form').trigger('reset');
                }
            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            }
        });
    }
});
