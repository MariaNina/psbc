$(document).ready(function () {
    const addressDetailsRules = {
        errorElement: "div",
        rules: {
            address: {
                required: true,
                maxlength: 100
            },
            contact_number: {
                required: true,
                maxlength: 20
            },
        },
        messages: {
            address: {
                required: "Address is required",
            },
            contact_number: {
                required: "Mobile No. is required",
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#student_profile #adress_details_form").validate(addressDetailsRules); // Validate

    // If Submit Form is Clicked
    $("#student_profile #adress_details_form").submit(function (e) {
        e.preventDefault();

        $("#student_profile #adress_details_form").validate(addressDetailsRules);

        if (!$("#student_profile #adress_details_form").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        addressDetailsFormSubmit();
    });

    function addressDetailsFormSubmit() {
        let formData = $("#student_profile #adress_details_form").serialize();

        $.ajax({
            type: "POST",
            url: `/profile/address_details`,
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
