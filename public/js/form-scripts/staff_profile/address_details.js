$(document).ready(function () {
    const addressDetailsRules = {
        errorElement: "div",
        rules: {
            address: "required",
            zip_code: "required",
            mobile_number: "required",
        },
        messages: {
            address: {
                required: "Address is required",
            },
            zip_code: {
                required: "Zipcode is required",
            },
            mobile_number: {
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

    $("#staff_profile #adress_details_form").validate(addressDetailsRules); // Validate

    // If Submit Form is Clicked
    $("#staff_profile #adress_details_form").submit(function (e) {
        e.preventDefault();

        $("#staff_profile #adress_details_form").validate(addressDetailsRules);

        if (!$("#staff_profile #adress_details_form").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        addressDetailsFormSubmit();
    });

    function addressDetailsFormSubmit() {
        let formData = $("#staff_profile #adress_details_form").serialize();

        $.ajax({
            type: "POST",
            url: `/staff_profile/address_details`,
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
