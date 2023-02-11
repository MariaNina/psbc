$(document).ready(function() {
    $(".js-example-basic-single").select2({
        placeholder: 'No selected',
        theme: "bootstrap4",
    });
    let id; //define a global variable id for edit
    const page_route = "students_enrollment";
    // Smart wizard for Multistep Form
    const smartWizard = $("#smartwizard");

    smartWizard.smartWizard("reset");

    var btnFinish = $('<button type="button"></button>')
        .text("Submit")
        .addClass("btn btn-orange btn-finish");

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
        function(e, anchorObject, stepNumber, stepDirection) {
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
            section: {
                required: true,
            },
            status: {
                required: true,
            }
        },
        messages: {
            section: "Section is required",
            status: "Status is required"
        },
        highlight: function(element) {
            $(".btn-finish").addClass("disabled");

            // Disable #x
            $(".btn-finish").prop("disabled", true);

            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");

            // Enable #x
            $(".btn-finish").prop("disabled", false);

            $(".btn-finish").removeClass("disabled");
        },
    };

    $("#myForm").validate(opt);

    let tab = document.getElementsByClassName("students-tab");

    // Prevent user from going to next step if not validate
    smartWizard.on(
        "leaveStep",
        function(
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

        let input = tab[1].getElementsByTagName("input");

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
    $('body').on('click', '.viewDocument', function(e) {
            id = $(this).data('id');
            console.log(id)
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: page_route + "/getStudentData",
                type: "POST",
                data: {
                    id: id,
                    _token: _token
                },
                success: function(result) {
                    console.log(result.docs)
                    $('#viewStudentModal').modal('show');
                    // students
                    $('#student_id').val(result.student_details[0].id);
                    $('#user_id').val(result.student_details[0].user_id);
                    $('#guardian_id').val(result.student_details[0].guardian_id);
                    $('#lrn').val(result.student_details[0].lrn);
                    $('#user_name').val(result.student_details[0].user_name);
                    $('#first_name').val(result.student_details[0].first_name);
                    $('#middle_name').val(result.student_details[0].middle_name);
                    $('#last_name').val(result.student_details[0].last_name);
                    $('#suffix_name').val(result.student_details[0].suffix_name);
                    $('#religion').val(result.student_details[0].religion);
                    $('#email_address').val(result.student_details[0].email);
                    $('#contact_number').val(result.student_details[0].contact_number);
                    $('#address').val(result.student_details[0].address);
                    $('#birth_day').val(result.student_details[0].birth_day);
                    $('#birth_place').val(result.student_details[0].birth_place);
                    $('#enrollment_id').val(result.enrollment[0].id);
                    $('#app_no').val(result.enrollment[0].application_no);
                    $('#app_no_').val(result.enrollment[0].application_no);
                    let section_id = result.enrollment[0].section_id;
                    let term_id = result.enrollment[0].term_id;
                    let level_id = result.enrollment[0].level_id;
                    let curriculum_id = result.enrollment[0].curriculum_id;
                    let branch_id = result.enrollment[0].branch_id;
                    let student_type = result.enrollment[0].student_type;
                    let school_year_id = result.enrollment[0].school_year_id;
                    let student_department = result.enrollment[0].student_department;
                    let is_approved = result.enrollment[0].is_approved;
                    let gender = result.student_details[0].gender;
                    let citizenship = result.student_details[0].citizenship;
                    let civil_status = result.student_details[0].civil_status;
                    let app_status = result.app_stats[0].STATUS;
                    let secHtml = '<option value="" disabled selected>Select...</option>';
                    let termHtml = '<option value="" disabled selected>Select...</option>';
                    let curHtml = '';
                    let syHtml = '';
                    let statusHtml = '';
                    let stdDeptHtml = '';
                    let stdTypeHtml = '';
                    let levelHtml = '<option value="" disabled selected>Select...</option>';
                    let branchHtml = '<option value="" disabled selected>Select...</option>';
                    let object1 = JSON.parse(result.student_details[0].other_details);


                    genderHtml = '<option value="" disabled selected>Select...</option>';
                    genderHtml += '<option value="Female" ' + ((gender == "Female") ? "selected" : "") + '>Female</option>';
                    genderHtml += '<option value="Male" ' + ((gender == "Male") ? "selected" : "") + '>Male</option>';

                    citizenshipHtml = '<option value="" disabled selected>Select...</option>';
                    citizenshipHtml += '<option value="Filipino" ' + ((citizenship == "Filipino") ? "selected" : "") + '>Filipino</option>';
                    citizenshipHtml += '<option value="American" ' + ((citizenship == "American") ? "selected" : "") + '>American</option>';

                    civilstatusHtml = '<option value="" disabled selected>Select...</option>';
                    civilstatusHtml += '<option value="Single" ' + ((civil_status == "Single") ? "selected" : "") + '>Single</option>';
                    civilstatusHtml += '<option value="Married" ' + ((civil_status == "Married") ? "selected" : "") + '>Married</option>';

                    stdDeptHtml += '<option value="" disabled selected>Select...</option>';
                    stdDeptHtml += '<option value="Elementary" ' + ((student_department == "Elementary") ? "selected" : "") + '> Pre Elementary / Elementary </option>';
                    stdDeptHtml += '<option value="JHS" ' + ((student_department == "JHS") ? "selected" : "") + '>Junior High School</option>';
                    stdDeptHtml += '<option value="SHS" ' + ((student_department == "SHS") ? "selected" : "") + '>Senior High School</option>';
                    stdDeptHtml += '<option value="College" ' + ((student_department == "College") ? "selected" : "") + '>College</option>';
                    stdDeptHtml += '<option value="Graduate Studies" ' + ((student_department == "Graduate Studies") ? "selected" : "") + '>Graduate Studies</option>';

                    stdTypeHtml += '<option value="" disabled selected>Select...</option>';
                    stdTypeHtml += '<option value="Old" ' + ((student_type == "Old") ? "selected" : "") + '>Old</option>';
                    stdTypeHtml += '<option value="New" ' + ((student_type == "New") ? "selected" : "") + '>New</option>';
                    stdTypeHtml += '<option value="Transferee" ' + ((student_type == "Transferee") ? "selected" : "") + '>Transferee</option>';
                    stdTypeHtml += '<option value="Cross Enrollee" ' + ((student_type == "Cross Enrollee") ? "selected" : "") + '>Cross Enrollee</option>';

                    result.sections.forEach(sec => {
                        secHtml += '<option value="' + sec.id + '" ' + ((section_id == sec.id) ? "selected" : "") + '>' + sec.section_label + '</option>';
                    });

                    result.terms.forEach(t => {
                        termHtml += '<option value="' + t.id + '" ' + ((term_id == t.id) ? "selected" : "") + '>' + t.term_name + '</option>';
                    });

                    result.branches.forEach(b => {
                        branchHtml += '<option value="' + b.id + '" ' + ((branch_id == b.id) ? "selected" : "") + '>' + b.branch_name + '</option>';
                    });

                    result.levels.forEach(l => {
                        levelHtml += '<option value="' + l.id + '" ' + ((level_id == l.id) ? "selected" : "") + '>' + l.level_name + '</option>';
                    });

                    result.curriculums.forEach(cur => {
                        curHtml += '<option value="' + cur.id + '" ' + ((curriculum_id == cur.id) ? "selected" : "") + '>' + cur.pname + ' - ' + cur.mname + '</option>';
                    });

                    result.school_years.forEach(sy => {
                        syHtml += '<option value="' + sy.id + '" ' + ((school_year_id == sy.id) ? "selected" : "") + '>' + sy.school_years + '</option>';
                    });
                    statusHtml += '<option value="" disabled selected>Select...</option>';
                    statusHtml += '<option value="1" ' + ((is_approved == "1") ? "selected" : "") + '>Approved</option>';
                    statusHtml += '<option value="2" ' + ((is_approved == "2") ? "selected" : "") + '>Rejected</option>';

                    $('#curriculum').html(curHtml);
                    $('#student_level').html(levelHtml);
                    $('#gender').html(genderHtml);
                    $('#citizenship').html(citizenshipHtml);
                    $('#civil_status').html(civilstatusHtml);

                    // guardians
                    $('#g_first_name').val(result.student_details[0].g_first_name);
                    $('#g_middle_name').val(result.student_details[0].g_middle_name);
                    $('#g_last_name').val(result.student_details[0].g_last_name);
                    $('#g_address').val(result.student_details[0].g_address);
                    $('#g_contact_number').val(result.student_details[0].g_contact_number);

                    $('#branch').html(branchHtml);
                    $('#student_type').html(stdTypeHtml);
                    $('#section').html(secHtml);
                    $('#term').html(termHtml);
                    $('#status').html(statusHtml);
                    $('#school_years').html(syHtml);
                    $('#student_department').html(stdDeptHtml);
                    $('#view_docs').html(result.docs);
                    $('#subject_tbl').html(result.subjects);

                    console.log(app_status)
                    if (app_status == 'Enrolled') {
                        $(".btn-finish").addClass("disabled");
                    } else {
                        $(".btn-finish").removeClass("disabled");
                    }

                    _obj = '';
                    for (let [key, value] of Object.entries(object1)) {
                        _obj += `<div class="col-md-6"><div class="form-group"><label for="${key}">${key.replaceAll("_"," ")}</label><input type="text" class="form-control" name="${key}" value="${(value == null) ? "N/A": value}" /></div></div>`;
                    }

                    $('#other_details').html(_obj);
                    setSubjectDatatable();
                }
            });
        })
        // Select Picker (Searchable Dropdown)

    // Do Something when finissh
    function onFinishCallback(objs, context) {
        if ($("button.sw-btn-next").hasClass("disabled")) {
            if (!validateLastInput()) return false;
        }

        // console.log("Finished Clicked");
        saveData();

        smartWizard.smartWizard("reset");
    }

    $(".btn-finish").click(function(e) {
        e.preventDefault();
        onFinishCallback();
    });

    function saveData() {
        // Do something here if validation is passed.
        let form_data = $("#myForm").serialize();

        $.ajax({
                url: page_route + '/update',
                type: 'PUT',
                data: form_data
            })
            .done(function(response) {
                console.log(response)
                Swal.fire(response.status, response.msg, response.status);
                // alert+response.status(response.msg) //calls function alertSuccess in public\js\main.js
                $("#myForm")[0].reset();
                $('#viewStudentModal').modal('hide');
                $('#filtertable').DataTable().ajax.reload()
            })
            .fail(function() {
                alertFailed('Saved')
            })
    }

    $('#addEnrolleeForm').validate(opt); // Validate

    // add Enrollee Form
    $('#addEnrolleeForm').submit(function(e) {

        e.preventDefault();

        $('#addEnrolleeForm').validate(opt);

        if (!$('#addEnrolleeForm').valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
    });

    function createData() {
        // Do something here if validation is passed.
        let form_array = $('#addEnrolleeForm').serialize();

        $.post("", form_array, function(resp) {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
            })
            .done(function(response) {
                console.log(response)
                Swal.fire(response.status, response.msg, response.status); //calls function alertSuccess in public\js\main.js
                $('#add_student_id').val();
                $('#addEnrolleeForm')[0].reset();
                $('#addStudentModal').modal('hide');
                $('#filtertable').DataTable().ajax.reload()
            })
            .fail(function() {
                alertFailed('Create')
            })
    }

    $('#add_student_department').on('change', function() {

        let stud_dept = $(this).val();
        let stud_level = $('#add_student_level').val();
        let branch_id = $('#add_branch').val();
        let type = 'add';
        getLevelsByStudDept(stud_dept, type);
        getCurriculumByStudDeptAndLevel(stud_dept, stud_level, branch_id, type);
    });

    $('#student_department').on('change', function() {

        let stud_dept = $(this).val();
        let stud_level = $('#student_level').val();
        let branch_id = $('#branch').val();
        let type = 'update';
        getLevelsByStudDept(stud_dept, type);
        getCurriculumByStudDeptAndLevel(stud_dept, stud_level, branch_id, type);
    });

    $('#add_student_level').on('change', function() {

        let stud_dept = $('#add_student_department').val();
        let stud_level = $(this).val();
        let branch_id = $('#add_branch').val();
        let type = 'add';
        getCurriculumByStudDeptAndLevel(stud_dept, stud_level, branch_id, type);

        let branch = $('#add_branch').val();
        getSectionByBranchAndLevel(branch, stud_level, type);

    });
    $('#student_level').on('change', function() {

        let stud_dept = $('#student_department').val();
        let stud_level = $(this).val();
        let branch_id = $('#branch').val();
        let type = 'update';
        getCurriculumByStudDeptAndLevel(stud_dept, stud_level, branch_id, type);

        let branch = $('#branch').val();
        getSectionByBranchAndLevel(branch, stud_level, type);

    });
    $('#add_branch').on('change', function() {

        let stud_dept = $('#add_student_department').val();
        let stud_level = $('#add_student_level').val();
        let branch_id = $(this).val();
        let type = 'add';
        getSectionByBranchAndLevel(branch_id, stud_level, type);

        getCurriculumByStudDeptAndLevel(stud_dept, stud_level, branch_id, type);
    });
    $('#branch').on('change', function() {

        let stud_dept = $('#student_department').val();
        let stud_level = $('#student_level').val();
        let branch_id = $(this).val();
        let type = 'update';

        getSectionByBranchAndLevel(branch_id, stud_level, type);
        getCurriculumByStudDeptAndLevel(stud_dept, stud_level, branch_id, type);
    });
    $('#curriculum').on('change', function() {
        getSubjectByCur();
    });
    $('#add_curriculum').on('change', function() {
        getSubjectByCurAdd();
    });

    function getSubjectByCur() {

        let curriculum = $('#curriculum').val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `${page_route}/getSubjectByCurAjax`,
            type: "POST",
            data: {
                curriculum: curriculum,
                _token: _token
            },
            success: function(result) {
                $('#subject-list').DataTable().destroy();
                // console.log(result)
                $('#subject_tbl').html(result);
                setSubjectDatatable();

            }
        });
    }

    function getSubjectByCurAdd() {

        let curriculum = $('#add_curriculum').val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `${page_route}/getSubjectByCurAjaxAdd`,
            type: "POST",
            data: {
                curriculum: curriculum,
                _token: _token
            },
            success: function(result) {
                $('#subject-list').DataTable().destroy();
                // console.log(result)
                $('#add_subject_tbl').html(result);
                setSubjectDatatableAdd();

            }
        });
    }

    function getLevelsByStudDept(stud_dept, type) {


        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "enrollment/getLevelsByStudDept",
            type: "POST",
            data: {
                stud_dept: stud_dept,
                _token: _token
            },
            success: function(result) {

                let levelHtml = '<option value="" disabled selected>Select...</option>';
                result.levels.forEach(level => {
                    levelHtml += '<option value="' + level.id + '">' + level.level_name + '</option>';
                });

                if (type == 'add') {
                    $('#add_student_level').html(levelHtml);
                    // console.log(levelHtml)
                } else {
                    $('#student_level').html(levelHtml);
                }


            }
        });
    }

    function getCurriculumByStudDeptAndLevel(stud_dept, stud_level, branch_id, type) {

        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "enrollment/getCurriculumByStudDeptAndLevel",
            type: "POST",
            data: {
                stud_dept: stud_dept,
                stud_level: stud_level,
                branch_id: branch_id,
                _token: _token
            },
            success: function(result) {
                // console.log(result)
                let Html = '<option value="" disabled selected>Select...</option>';
                result.curriculums.forEach(curriculum => {
                    Html += '<option value="' + curriculum.id + '">' + curriculum.pname + ' - ' + curriculum.mname + '</option>';
                });
                if (type == 'add') {
                    $('#add_curriculum').html(Html);
                } else {
                    $('#curriculum').html(Html);
                }


            }
        });
    }

    function getSectionByBranchAndLevel(branch, stud_level, type) {

        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `${page_route}/getSectionByBranchAndLevel`,
            type: "POST",
            data: {
                branch: branch,
                stud_level: stud_level,
                _token: _token
            },
            success: function(result) {
                // console.log(result)
                let Html = '<option value="" disabled selected>Select...</option>';

                result.sections.forEach(sec => {
                    Html += '<option value="' + sec.id + '">' + sec.section_label + '</option>';
                });
                // console.log(Html)
                if (type == 'add') {
                    $('#add_section').html(Html);

                } else {
                    $('#section').html(Html);
                }
            }
        });
    }

    function setSubjectDatatableAdd() {

        var table = $('#subject-list-add').DataTable({
            'dom': 't',
            'columnDefs': [{
                    'targets': 0,
                    'className': 'dt-body-center',

                },
                {
                    "orderable": false,
                    "targets": [0, 2]
                }
            ],
            'order': [1, 'asc'],
            "paging": false,
        });

        $(document).on('click', '#subject-list-add-select-all', function() {
            // Check/uncheck all checkboxes in the table
            var rows = table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows)
                .prop('checked', this.checked);
            if (this.checked) {
                $('input[type="checkbox"]', rows).closest('tr').addClass('tr-selected');
            } else {
                $('input[type="checkbox"]', rows).closest('tr').removeClass('tr-selected');
            }
        });

        // Handle click on checkbox to set state of "Select all" control
        $('#subject-list-add tbody').on('change', 'input[type="checkbox"]', function() {
            // If checkbox is not checked
            if (!this.checked) {
                var el = $('#subject-list-add-select-all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if (el && el.checked && ('indeterminate' in el)) {
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        });

        $(document).on('click', '.custom-control-input-add', function() {
            if ($(this).prop('checked')) {
                $(this).closest('td').closest('tr').addClass('tr-selected');
            } else {
                $(this).closest('td').closest('tr').removeClass('tr-selected');
            }
        });
    }

    function setSubjectDatatable() {

        var table = $('#subject-list').DataTable({
            'dom': 't',
            'columnDefs': [{
                    'targets': 0,
                    'className': 'dt-body-center',

                },
                {
                    "orderable": false,
                    "targets": [0, 2],
                    "paging": false
                }
            ],
            'order': [1, 'asc'],
            "paging": false
        });

        $(document).on('click', '#subject-list-select-all', function() {
            // Check/uncheck all checkboxes in the table
            var rows = table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows)
                .prop('checked', this.checked);
            if (this.checked) {
                $('input[type="checkbox"]', rows).closest('tr').addClass('tr-selected');
            } else {
                $('input[type="checkbox"]', rows).closest('tr').removeClass('tr-selected');
            }
        });

        // Handle click on checkbox to set state of "Select all" control
        $('#subject-list tbody').on('change', 'input[type="checkbox"]', function() {
            // If checkbox is not checked
            if (!this.checked) {
                var el = $('#subject-list-select-all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if (el && el.checked && ('indeterminate' in el)) {
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        });

        $(document).on('click', '.custom-control-input', function() {
            if ($(this).prop('checked')) {
                $(this).closest('td').closest('tr').addClass('tr-selected');
            } else {
                $(this).closest('td').closest('tr').removeClass('tr-selected');
            }
        });
    }

    $('body').on('click', '.deactivate', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to reject this application?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                id = $(this).data('id');
                let _token = $('meta[name="csrf-token"]').attr('content');
                // console.log(id)
                $.ajax({
                    url: page_route + "/" + id,
                    type: "DELETE",
                    data: {
                        is_approved: 2,
                        _token: _token,
                    },
                    success: function(data) {
                        alertSuccess('Rejected') //calls function alertSuccess in public\js\main.js
                        tbl.ajax.reload() //reloads the school year datatable
                    },
                    error: function(xhr, status, errorThrown) {
                        alertFailed('Reject') //calls function alertFailed in public\js\main.js
                    }
                });
            }
        });
    });

    $('body').on('click', '.activate', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to approved this application?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                id = $(this).data('id');
                let _token = $('meta[name="csrf-token"]').attr('content');
                // console.log(id)
                $.ajax({
                    url: page_route + "/" + id,
                    type: "DELETE",
                    data: {
                        is_approved: 1,
                        _token: _token,
                    },
                    success: function(data) {
                        alertSuccess('Approved') //calls function alertSuccess in public\js\main.js
                        tbl.ajax.reload() //reloads the school year datatable
                    },
                    error: function(xhr, status, errorThrown) {
                        alertFailed('Approve') //calls function alertFailed in public\js\main.js
                    }
                });
            }
        });
    });
});