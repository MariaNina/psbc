$(document).ready(function () {
    // Reset Steps

    // Smart wizard for Multistep Form
    const smartWizard = $("#smartwizard");

    smartWizard.smartWizard("reset");

    var btnFinish = $('<button type="button"></button>')
        .text("Submit")
        .addClass("btn btn-orange btn-success");

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
        onFinish: onFinishCallback,
    };

    smartWizard.smartWizard(options);

    // Show only the finish
    smartWizard.on(
        "showStep",
        function (e, anchorObject, stepNumber, stepDirection) {
            if ($("button.sw-btn-next").hasClass("disabled")) {
                $(".btn-finish").show(); // show the button extra only in the last page
                $(".btn-finish").removeClass("disabled");
            } else {
                $(".btn-finish").hide();
                $(".btn-finish").addClass("disabled");
            }
        }
    );

    //=========================================//

    // Validation of Form

    const opt = {
        errorElement: "div",
        rules: {
            curriculumYear: "required",
            courseTitle: {
                required: true,
            },
            courseCode: "required",
            courseDescription: "required",
            labUnits: {
                required: true,
                number: true,
            },
            lecUnits: {
                required: true,
                number: true,
            },
            acadType: {
                required: true,
            },
        },
        messages: {
            courseTitle: {
                required: "Corusse title is required",
            },
            courseCode: {
                required: "Course code is required",
            },
            courseDescription: {
                required: "Course description is required",
            },
            curriculumYear: {
                required: "Corriculum year is required",
            },
            labUnits: {
                required: "Lab units year is required",
            },
            lecUnits: {
                required: "Lecture units is required",
            },
            acadType: {
                required: "Academic type is required",
            },
        },
        highlight: function (element) {
            $(".btn-finish").addClass("disabled");

            // Disable #x
            $(".btn-finish").prop("disabled", true);

            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");

            // Enable #x
            $(".btn-finish").prop("disabled", false);

            $(".btn-finish").removeClass("disabled");
        },
    };

    $("#myForm").validate(opt);

    let tab = document.getElementsByClassName("curriculumCollege-tab");

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

            if (!$("#myForm").valid()) {
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

        if (!$("#myForm").valid()) {
            valid = false;
        }

        return valid;
    }

    // Select Picker (Searchable Dropdown)

    // Do Something when finissh
    function onFinishCallback(objs, context) {
        if ($("button.sw-btn-next").hasClass("disabled")) {
            if (!validateLastInput()) return false;
        }

        console.log("Finished Clicked");

        $("#collegeCurriculumModal").modal("hide");

        smartWizard.smartWizard("reset");
    }

    $(".btn-finish").click(function (e) {
        e.preventDefault();
        onFinishCallback();
    });
});
