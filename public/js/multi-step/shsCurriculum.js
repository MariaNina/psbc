$(document).ready(function () {
    // Smart wizard
    const smartWizard = $("#SHSsmartwizard");

    // Reset Steps
    smartWizard.smartWizard("reset");

    var btnFinish = $('<button type="button"></button>')
        .text("Submit")
        .addClass("btn btn-success btn-shs-finish");

    const options = {
        selected: 0,
        theme: "dots",
        autoAdjustHeight: true,
        transition: {
            animation: "fade", // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
            speed: "400", // Transion animation speed
            easing: "", // Transition animation easing. Not supported without a jQuery easing plugin
        },
        toolbarSettings: {
            toolbarPosition: "bottom", // none, top, bottom, both
            toolbarButtonPosition: "right", // left, right, center
            toolbarExtraButtons: [btnFinish],
        },
        showStepURLhash: true,
        onFinish: onFinishSHSCallback,
    };

    smartWizard.smartWizard(options);

    // Show only the finish
    smartWizard.on(
        "showStep",
        function (e, anchorObject, stepNumber, stepDirection) {
            if ($("button.sw-btn-next").hasClass("disabled")) {
                $(".btn-shs-finish").show(); // show the button extra only in the last page
            } else {
                $(".btn-shs-finish").hide();
            }
        }
    );

    //=========================================//

    // Validation

    const opt = {
        errorElement: "div",
        rules: {
            curriculumYearSHS: "required",
            strand: {
                required: true,
            },
            subjectTitle: "required",
            subjectCode: "required",
            subjectDescription: "required",
            labUnitsSHS: {
                required: true,
                number: true,
            },
            lecUnitsSHS: {
                required: true,
                number: true,
            },
            acadSHSType: "required",
        },
        messages: {
            strand: {
                required: "Strand is required",
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
            curriculumYearSHS: {
                required: "Corriculum year is required",
            },
            labUnitsSHS: {
                required: "Lab units year is required",
            },
            lecUnitsSHS: {
                required: "Lecture units is required",
            },
            acadSHSType: {
                required: "Academic type is required",
            },
        },
        highlight: function (element) {
            $(".btn-shs-finish").addClass("disabled");

            // Disable #x
            $(".btn-shs-finish").prop("disabled", true);

            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(".btn-shs-finish").removeClass("disabled");

            // Enable #x
            $(".btn-shs-finish").prop("disabled", false);

            $(element).removeClass("is-invalid");
        },
    };

    $("#myFormSHS").validate(opt);

    let tab = document.getElementsByClassName("curriculumShs-tab");

    // Prevent user from going to next step if not validate
    smartWizard.on(
        "leaveStep",
        function (
            e,
            anchorObject,
            currentStepIndex,
            nextStepIndex,
            stepDirection
        ) {
            let valid = true;

            let input = tab[currentStepIndex].getElementsByTagName("input");

            // Only validate when clicking next
            if (stepDirection != "forward") {
                return valid;
            }

            // A loop that checks every input field in the current tab:
            for (i = 0; i < input.length; i++) {
                // If a field is empty...
                if (input[i].value == "" && !$(".bs-searchbox > input")) {
                    // add an "invalid" class to the field:
                    input[i].className += " is-invalid";

                    valid = false;
                } else {
                    input[i].classList.remove("is-invalid");
                }
            }

            if (!$("#myFormSHS").valid()) {
                valid = false;
            }

            return valid;
        }
    );

    // Validate last step form
    function validateLastInput() {
        let valid = true;

        let input = tab[2].getElementsByTagName("input");

        // A loop that checks every input field in the current tab:
        for (i = 0; i < input.length; i++) {
            // If a field is empty...
            if (input[i].value == "") {
                // add an "invalid" class to the field:
                input[i].className += " is-invalid";

                valid = false;
            } else {
                input[i].classList.remove("is-invalid");
            }
        }

        if (!$("#myFormSHS").valid()) {
            valid = false;
        }

        return valid;
    }

    // Do Something when finissh
    function onFinishSHSCallback(objs, context) {
        if ($("button.sw-btn-next").hasClass("disabled")) {
            if (!validateLastInput()) return false;
        }

        console.log("Finished Clicked");

        $("#shsCurriculumModal").modal("hide");

        smartWizard.smartWizard("reset");
    }

    $(".btn-shs-finish").click(function (e) {
        e.preventDefault();
        onFinishSHSCallback();
    });
});
