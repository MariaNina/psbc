$(document).ready(function () {
    const optAdd = {
        errorElement: "div",
        rules: {
            sectionLabel: "required",
            schoolYear: "required",
            level: "required",
        },
        messages: {
            sectionLabel: {
                required: "Section Name is required",
            },
            schoolYear: {
                required: "School year is required",
            },
            level: {
                required: "Grade level is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    const optEdit = {
        errorElement: "div",
        rules: {
            editSection: "required",
        },
        messages: {
            editSection: {
                required: "Section Name is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#SectionForm").validate(optAdd); // Validate
    $("#editSectionForm").validate(optEdit); // Validate

    // Check validation if submit
    $("#SectionForm").submit(function (e) {
        e.preventDefault();

        $("#SectionForm").validate(optAdd);

        if (!$("#SectionForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        console.log("Validated");
    });

    $("#editSectionForm").submit(function (e) {
        e.preventDefault();

        $("#editSectionForm").validate(optEdit);

        if (!$("#editSectionForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        console.log("Validated");
    });
});
