$(document).ready(function () {

    // TODO: ADD LENGTH VALIDATION TO NAME FIELDS
    const basicInfoRules = {
        errorElement: "div",
        rules: {
            last_name: {
                required: true,
                maxlength: 30
            },
            middle_name: {
                required: true,
                maxlength: 30
            },
            first_name: {
                required: true,
                maxlength: 30
            },
            gender: "required",
            civil_status: "required",
            birth_day: "required",
            birth_place: {
                required: true,
                maxlength: 100
            },
            citizenship: "required",
            lrn: {
                maxlength: 30
            },
            suffix_name: {
                maxlength: 5
            },
            religion: {
                maxlength: 30
            }
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
            gender: {
                required: "Gender is required",
            },
            civil_status: {
                required: "Civil status is required",
            },
            birth_day: {
                required: "Birth day is required",
            },
            birth_place: {
                required: "Birth place is required",
            },
            citizenship: {
                required: "Citizenship is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#student_profile #basic_info_form").validate(basicInfoRules); // Validate

    // If Submit Form is Clicked
    $("#student_profile #basic_info_form").submit(function (e) {
        e.preventDefault();

        $("#student_profile #basic_info_form").validate(basicInfoRules);

        if (!$("#student_profile #basic_info_form").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        basicInfoFormSubmit();
    });

    function basicInfoFormSubmit() {

        let formData = $("#student_profile #basic_info_form").serialize();

        $.ajax({
            type: "POST",
            url: `/profile/basic_info`,
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
