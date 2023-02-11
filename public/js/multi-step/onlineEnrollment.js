$(window).on('load', function () {
    $('#regFormModal').modal('show');
});
$(document).ready(function () {
 
    let page_route = 'enrollment';
    /**hide divisiona at document load
     Divisions will show depends on student department**/
    $('#for_gradstuds').hide(); //if student dept is Graduate Studies
    $('#for_college').hide(); //if student dept is College
    $('#for_shs').hide(); //if student dept is SHS

    // Reset Steps

    // Smart wizard for Multistep Form
    const smartWizard = $("#smartwizard");

    smartWizard.smartWizard("reset");

    var btnFinish = $('<button type="submit"></button>')
        .text("Submit")
        .addClass("btn btn-finish btn-orange btn-success");

    const options = {
        selected: 0,
        theme: "arrows",
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
          
            if(stepNumber == 0){
               $('.toolbar').hide(); //hides the bottom buttons
            }
            if(stepNumber > 0){
                $('.toolbar').show(); //shows bottom buttons
            }
            if(stepNumber == 1){
                $("button.sw-btn-prev").attr("disabled",true);
            }else{
                $("button.sw-btn-prev").attr("disabled",false);
            }

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
            // enrollment information
            school_branch: "required",
            student_department: "required",
            student_type: "required",
            student_level: "required",
            curriculum: "required",
            // for graduate students
            grad_programs: "required",
            under_grad_program_taken: "required",
            // for college students
            college_programs: "required",
            // for shs
            shs_track_strand: "required",
            last_school_attended: {
                minlength: 2,
                maxlength: 60
            },
            year_graduated: {
                minlength: 0,
                maxlength: 4,
                number: true
            },
            

            // students information
            lrn:{
                number: true,
            },
            first_name: {
                required: true,
                minlength: 2,
                maxlength: 30
            },
            last_name: {
                required: true,
                minlength: 2,
                maxlength: 30
            },
            // middle_name: {
            //     required: false,
            //     maxlength: 30
            // },
            suffix_name: {
                required: false,
                maxlength: 5
            },
            gender: {
                required: true
            },
            citizenship: {
                required: true
            },
            religion: {
                required: true,
            },
            civil_status: {
                required: true
            },
            email_address: {
                required: true,
                minlength: 2,
                maxlength: 100,
                email: true
            },
            contact_number: {
                required: true,
                minlength: 6,
                maxlength: 20,
                number: true
            },
            address: {
                required: true,
                minlength: 6,
                maxlength: 100
            },
            birth_day: {
                required: true,
                date: true
            },
            birth_place: {
                required: true,
                minlength: 6,
                maxlength: 100
            },

            // Guardians information
            guardian_first_name: {
                required: true,
                minlength: 2,
                maxlength: 30
            },
            guardian_last_name: {
                required: true,
                minlength: 2,
                maxlength: 30
            },
            guardian_middle_name: {
                required: false,
                minlength: 0,
                maxlength: 30
            },
            guardian_contact_number: {
                required: true,
                minlength: 6,
                maxlength: 20,
                number: true
            },
            guardian_address: {
                required: true,
                minlength: 6,
                maxlength: 40
            },
            // image: {
            //     maxfilesize: true
            // }

        },
        messages: {
            // enrollment information
            school_branch: {
                required: "School Branch is required"
            },
            student_department: {
                required: "Student Department is required"
            },
            student_type: {
                required: "Student Type is required"
            },
            student_level: {
                required: "Student Level is required"
            },
            // for graduate students
            grad_programs: {
                required: "Graduate Program is required"
            },
            under_grad_program_taken: {
                required: "Undergraduate Program taken is required"
            },
            // for college students
            college_programs: {
                required: "College Program is required"
            },
            // for shs
            shs_track_strand: {
                required: "Strand or Track is required"
            },
            year_graduated: {
                number: "Please enter a valid year or leave it blank"
            },
            //student informations
            lrn: {
                number: "Please enter a valid LRN or leave it blank"
            },
            first_name: {
                required: "First Name is required"
            },
            last_name: {
                required: "Last Name is required"
            },
            gender: {
                required: "Gender is required"
            },
            citizenship: {
                required: "Citizenship is required"
            },
            religion: {
                required: "Religion is required"
            },
            civil_status: {
                required: "Civil Status is required"
            },
            email_address: {
                required: "Email is required"
            },
            contact_number: {
                required: "Contact Number is required"
            },
            address: {
                required: "Complete Home Address is required"
            },
            birth_day: {
                required: "Birthdate is required"
            },
            birth_place: {
                required: "Birth Place is required"
            },

            // Guardians information
            guardian_first_name: {
                required: "Guardian's First Name is required"
            },
            guardian_last_name: {
                required: "Guardian's Last Name is required"
            },
            guardian_contact_number: {
                required: "Guardian's Contact Number is required"
            },
            guardian_address: {
                required: "Guardian's Address is required"
            },
            // agree: 'Please check "I Agree" to proceed'

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

    // $.validator.addMethod(
    // "maxfilesize",
    // function (value, element) {
    //     if (this.optional(element) || ! element.files || ! element.files[0]) {
    //      return true;
    //     } else {
    //      return element.files[0].size <= 1024 * 1024 * 2;
    //     }
    // },
    // 'The file size can not exceed 2MiB.'
    // );

    $("#registrationForm").validate(opt);

    let tab = document.getElementsByClassName("registrationForm-tab");

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
            // for (i = 0; i < input.length; i++) {
            //     // If a field is empty...
            //     if (input[i].value == "" && !$(".bs-searchbox > input")) {
            //         // add an "invalid" class to the field:
            //         input[i].className += " is-invalid";

            //         valid = false;
            //     } else {
            //         input[i].classList.remove("is-invalid");
            //     }
            // }

            if (!$("#registrationForm").valid()) {
                valid = false;
            }

            return valid;
        }
    );

    // Validate last step form
    function validateLastInput() {
        let valid = true;

        let input = tab[5].getElementsByTagName("input");

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

        if (!$("#registrationForm").valid()) {
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

        // console.log("Finished Clicked");
        registerData();

        // $("#collegeCurriculumModal").modal("hide");

        smartWizard.smartWizard("reset");
    }

    $(".btn-finish").click(function (e) {
        e.preventDefault();
        onFinishCallback();
    });

    $('#school_branch').on('change', function () {
        getCurriculumByStudDeptAndLevel();
    })
    $('#student_department').on('change', function () {
        let stud_dept = $(this).val();

        if (stud_dept == 'Elementary' || stud_dept == 'JHS') {
            $('#for_gradstuds').hide();
            $('#for_college').hide();
            $('#for_shs').hide();
        }
        if (stud_dept == 'SHS') {
            $('#for_gradstuds').hide();
            $('#for_college').hide();
            $('#for_shs').show();
        }
        if (stud_dept == 'College') {
            $('#for_gradstuds').hide();
            $('#for_college').show();
            $('#for_shs').hide();
        }
        if (stud_dept == 'Graduate Studies') {
            $('#for_gradstuds').show();
            $('#for_college').hide();
            $('#for_shs').hide();
        }

        getLevelsByStudDept();
        getDocumentsByStudDeptAndType();
        getCurriculumByStudDeptAndLevel();
    });

    $('#student_type').on('change', function () {
        getDocumentsByStudDeptAndType();
        
    });
    $('#student_level').on('change', function () {
        getCurriculumByStudDeptAndLevel();
        
    });

    function getLevelsByStudDept() {

        let stud_dept = $('#student_department').val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route + "/getLevelsByStudDept",
            type: "POST",
            data: {
                stud_dept: stud_dept,
                _token: _token
            },
            success: function (result) {

                let levelHtml = '<option value="" disabled selected>Select...</option>';
                result.levels.forEach(level => {
                    levelHtml += '<option value="' + level.id + '">' + level.level_name + '</option>';
                });

                $('#student_level').html(levelHtml);

            }
        });
    }

    function getDocumentsByStudDeptAndType() {

        let stud_dept = $('#student_department').val();
        let stud_type = $('#student_type').val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route + "/getDocumentsByStudDeptAndType",
            type: "POST",
            data: {
                stud_dept: stud_dept,
                stud_type: stud_type,
                _token: _token
            },
            success: function (result) {
            
                let Html = '';
                result.documents.forEach(docs => {
                    required = (docs.is_required == 1) ? "<sup style='color:red'>required</sup>" : "<sup style='color:red'>optional</sup>";
                    // Html += '<label for="">'+docs.document_name+' '+required+'</label>';
                    // Html += '<input type="file" class="form-control" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" name="document_'+docs.id+'"/>';

                    Html += '<div class="form-group"><label for="">'+docs.document_name+' '+docs.required+' <sup style="color:red">(jpg, jpeg, png, pdf)</sup></label>';
                    Html += '<input onchange="validateFile(this)" type="file" class="form-control" accept="image/jpeg,image/png,application/pdf,image/x-eps" name="document_'+docs.id+'"/></div>';
                });
                // console.log(Html)
                $('#documents').html(Html);

            }
        });
    }
    
    function getCurriculumByStudDeptAndLevel() {

        let stud_dept = $('#student_department').val();
        let stud_level = $('#student_level').val();
        let branch_id = $('#school_branch').val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route + "/getCurriculumByStudDeptAndLevel",
            type: "POST",
            data: {
                stud_dept: stud_dept,
                stud_level: stud_level,
                branch_id: branch_id,
                _token: _token
            },
            success: function (result) {
                // console.log(result)
                let Html = '<option value="" disabled selected>Select...</option>';
                result.curriculums.forEach(curriculum => {
                    Html += '<option value="' + curriculum.id + '">' + curriculum.pname + ' - ' + curriculum.mname + '</option>';
                });

                $('#curriculum').html(Html);

            }
        });
    }

    // $('#registrationForm').submit(function (e) {
    //     e.preventDefault();

    //     $('#registrationForm').validate(opt);

    //     if (!$('#registrationForm').valid()) {
    //         return false;
    //     }
    //     registerData()
    // });

    // function registerData() {
    //     // Do something here if validation is passed.
    //     let form_array = $('#registrationForm').serializeArray();
    //     // console.log(form_array)
    //     $.post("", form_array, function (resp) {
    //         alertSuccess('resp') //calls function alertSuccess in public\js\main.js
    //     })
    //         .done(function (resp) {
    //             alertSuccess(resp) //calls function alertSuccess in public\js\main.js
    //             $('#registrationForm')[0].reset();
    //         })
    //         .fail(function () {
    //             alertFailed('Create')
    //         })
    // }
    function registerData() {
        // Do something here if validation is passed.
        let myForm = document.getElementById('registrationForm');
        let formData = new FormData(myForm); //use formData for forms with files
        // console.log(formData);
        $.ajax({
            type: 'POST',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
        })
        .done(function (resp) {
            alertSuccess(resp) //calls function alertSuccess in public\js\main.js
            $('#registrationForm')[0].reset();
        })
        .fail(function () {
            alertFailed('Create')
        })
    }
    $('#search_application_button').on('click', function() {
        let app_no = $('#serach_box').val();
        window.location.href = "/application/"+app_no;
    });

   

    function alertSuccess(application_no) {
        Swal.fire({
            title: "Successful Registration",
            text: `You are now successfully registered with application no. ${application_no}`,
            icon: "success",
            showCloseButton: true,
            confirmButtonColor: "#3085d6",
            closeButtonColor: "#d33",
            confirmButtonText: "Click to view/print Application Form",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `application/${application_no}`;
            }
        });

    }

    function alertFailed() {
        Swal.fire({
            title: "Failed Registration",
            text: "Failed to Register",
            icon: "error",
            showCloseButton: true,
            confirmButtonColor: "#3085d6",
            closeButtonColor: "#d33",
        })
    }
});
