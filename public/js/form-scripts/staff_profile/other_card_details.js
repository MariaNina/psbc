$(document).ready(function () {
    const otherCardDetailsRules = {
        errorElement: "div",
        rules: {
            staff_type: "required",
            position: "required",
            department: "required",
            agency_employee_no: {
                required: true,
                maxlength: 30
            },
            sss: {
                maxlength: 30
            },
            tin: {
                maxlength: 30
            },
            phil_health: {
                maxlength: 30
            },
            gsis: {
                maxlength: 30
            },
            pagibig: {
                maxlength: 30
            }
        },
        messages: {
            staff_type: {
                required: "Type is required",
            },
            position: {
                required: "Position is required",
            },
            department: {
                required: "Department is required",
            },
            agency_employee_no: {
                required: "Employee No. is required",
            },

        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#staff_profile #other_card_details_form").validate(otherCardDetailsRules); // Validate

    // If Submit Form is Clicked
    $("#staff_profile #other_card_details_form").submit(function (e) {
        e.preventDefault();

        $("#staff_profile #other_card_details_form").validate(otherCardDetailsRules);

        if (!$("#staff_profile #other_card_details_form").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        otherCardDetailsFormSubmit();
    });

    function otherCardDetailsFormSubmit() {
        let formData = $("#staff_profile #other_card_details_form").serialize();

        $.ajax({
            type: "POST",
            url: `/staff_profile/other_card_details`,
            data: formData,
            success: function (response) {
                Swal.fire("Updated!", response.msg, "success");

                $('._type').text(response.data.staff_type);
                $('._position').text(response.data.position);
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
