$(document).ready(function () {
    const opt = {
        errorElement: "div",
        rules: {
            curriculumYear: "required",
            subjectTitle: "required",
            subjectCode: "required",
            subjectDescription: "required",
            acadkto10Type: {
                required: true,
            },
            gradeLevel: "required",
        },
        messages: {
            gradeLevel: {
                required: "Grade level is required",
            },
            subjectTitle: {
                required: "Subject title is required",
            },
            subjectCode: {
                required: "Subject code is required",
            },
            subjectDescription: {
                required: "Subject description is required",
            },
            curriculumYear: {
                required: "Corriculum year is required",
            },
            acadkto10Type: {
                required: "Academic type is required",
            },
        },
        highlight: function (element) {
            $(".btn-finish").addClass("disabled");
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            $(".btn-finish").removeClass("disabled");
        },
    };

    $("#kto10Curriculum").validate(opt);

    $("#kto10Curriculum").submit(function (e) {
        e.preventDefault();

        $("#kto10Curriculum").validate(opt);

        if (!$("#kto10Curriculum").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        console.log('Validated');
    });
});
