$(document).ready(function () {
    const guardianRules = {
        errorElement: "div",
        rules: {
            last_name: "required",
            middle_name: "required",
            first_name: "required",
            address: "required",
            contact_number: {
                required: true,
                maxlength: 20
            },
        },
        messages: {
            last_name: {
                required: "Last name is required",
            },
            middle_name: {
                required: "Middle name is required",
            },
            first_name: {
                required: "First name is required",
            },
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

    $("#student_profile #guardian_info_form").validate(guardianRules); // Validate

    // If Submit Form is Clicked
    $("#student_profile #guardian_info_form").submit(function (e) {
        e.preventDefault();

        $("#student_profile #guardian_info_form").validate(guardianRules);

        if (!$("#student_profile #guardian_info_form").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        guardianDetailsFormSubmit();
    });

    function guardianDetailsFormSubmit() {
        let formData = $("#student_profile #guardian_info_form").serialize();

        $.ajax({
            type: "POST",
            url: `/profile/guardian_details`,
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
