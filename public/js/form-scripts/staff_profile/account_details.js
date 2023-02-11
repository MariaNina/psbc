$(document).ready(function () {
    const accountDetailsRules = {
        errorElement: "div",
        rules: {
            email: {
                required: true,
                email: true
            },
            user_name: "required",
        },
        messages: {
            email: {
                required: "Email is required",
            },
            user_name: {
                required: "Username is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#staff_profile #account_details_form").validate(accountDetailsRules); // Validate

    // If Submit Form is Clicked
    $("#staff_profile #account_details_form").submit(function (e) {
        e.preventDefault();

        $("#staff_profile #account_details_form").validate(accountDetailsRules);

        if (!$("#staff_profile #account_details_form").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        accountDetailsFormSubmit();
    });

    function accountDetailsFormSubmit() {
        let formData = $("#staff_profile #account_details_form").serialize();

        $.ajax({
            type: "POST",
            url: `/staff_profile/account_details`,
            data: formData,
            success: function (response) {
                Swal.fire("Updated!", response.msg, "success");
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
