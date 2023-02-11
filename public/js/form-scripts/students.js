$(function() {

    let id; //define a global variable id for edit
    const page_route = 'students'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            lrn: {
                number: false,
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
            email: {
                required: true,
                minlength: 2,
                maxlength: 100,
                email: true
            },
            gender: "required",
            address: {
                required: true,
                minlength: 6,
                maxlength: 100
            },
            contact_no: {
                required: true,
                minlength: 6,
                maxlength: 20,
                number: true
            },
            citizenship: {
                required: true
            },
            civil_status: {
                required: true
            },
            religion: {
                required: true
            },
            suffix_name: {
                required: false,
                maxlength: 5
            },
            g_first_name: {
                required: true
            },
            g_last_name: {
                required: true
            },
            g_address: {
                required: true
            },
            g_contact_number: {
                required: true
            }
        },
        messages: {
            lrn: {
                required: "LRN is required",
            },
            first_name: {
                required: "First name is required",
            },
            last_name: {
                required: "Last name is required",
            },
            email: {
                required: "Email is required",
            },
            contact_no: {
                required: "Contact Number is required",
            },
            address: {
                required: "Address is required",
            },
            citizenship: {
                required: "Citizenship is required",
            },
            civil_status: {
                required: "Civil Status is required",
            },
            religion: {
                required: "Religion is required"
            },
            g_first_name: {
                required: "Guardian's First Name is required"
            },
            g_last_name: {
                required: "Guardian's Last Name is required"
            },
            g_address: {
                required: "Guardian's Address is required"
            },
            g_contact_number: {
                required: "Guardian's Contact Number is required"
            }
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#addForm").validate(opt); // Validate
    $("#updateLevelForm").validate(opt); // Validate
    // add grade level
    $("#addForm").submit(function(e) {

        e.preventDefault();

        $("#addForm").validate(opt);

        if (!$("#addForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
    });

    function createData() {
        // Do something here if validation is passed.
        let form_array = $("#addForm").serialize();

        $.post("", form_array, function(resp) {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
            })
            .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#addForm")[0].reset();
                $('#addStudentsModal').modal('hide');
            })
            .fail(function() {
                alertFailed('Create')
            })
    }

    // get data by id from schoolyear edit
    $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route + "/" + id + "/edit",
            type: "GET",
            success: function(result) {
                // display data to updateschoolyearform
                $('#updateStudentModal').modal('show');

                $('#user_id').val(result.student_details[0].user_id);
                if(result.student_details[0].image==null){
                    $('#profile_pic').attr("src","storage/avatars_img/def.jpg");
                }
                else{
                $('#profile_pic').attr("src","storage"+result.student_details[0].image);
                }
                $('#guardian_id').val(result.student_details[0].guardian_id);
                // guardians
                $('#g_first_name').val(result.student_details[0].g_first_name);
                $('#g_middle_name').val(result.student_details[0].g_middle_name);
                $('#g_last_name').val(result.student_details[0].g_last_name);
                $('#g_address').val(result.student_details[0].g_address);
                $('#g_contact_number').val(result.student_details[0].g_contact_number);

                $('#lrn').val(result.student_details[0].lrn);
                $('#first_name').val(result.student_details[0].first_name);
                $('#middle_name').val(result.student_details[0].middle_name);
                $('#last_name').val(result.student_details[0].last_name);
                $('#suffix_name').val(result.student_details[0].suffix_name);

                $('#email_address').val(result.student_details[0].email);
                $('#contact_no').val(result.student_details[0].contact_number);
                $('#address').val(result.student_details[0].address);
                $('#birth_day').val(result.student_details[0].birth_day);

                let branch_id = result.student_details[0].branch_id;
                let branchHtml = '<option value="" disabled selected>Select...</option>';
                result.branches.forEach(b => {
                    branchHtml += '<option value="' + b.id + '" ' + ((branch_id == b.id) ? "selected" : "") + '>' + b.branch_name + '</option>';
                });
                $('#school_branch').html(branchHtml);

                let gender = result.student_details[0].gender;
                let citizenship = result.student_details[0].citizenship;
                let civil_status = result.student_details[0].civil_status;

                genderHtml = '<option value="" disabled selected>Select...</option>';
                genderHtml += '<option value="Female" ' + ((gender == "Female") ? "selected" : "") + '>Female</option>';
                genderHtml += '<option value="Male" ' + ((gender == "Male") ? "selected" : "") + '>Male</option>';

                citizenshipHtml = '<option value="" disabled selected>Select...</option>';
                citizenshipHtml += '<option value="Filipino" ' + ((citizenship == "Filipino") ? "selected" : "") + '>Filipino</option>';
                citizenshipHtml += '<option value="American" ' + ((citizenship == "American") ? "selected" : "") + '>American</option>';
                citizenshipHtml += '<option value="Japanese" ' + ((citizenship == "Japanese") ? "selected" : "") + '>Japanese</option>';
                citizenshipHtml += '<option value="Korean" ' + ((citizenship == "Korean") ? "selected" : "") + '>Korean</option>';
                citizenshipHtml += '<option value="Chinese" ' + ((citizenship == "Chinese") ? "selected" : "") + '>Chinese</option>';
                citizenshipHtml += '<option value="Others" ' + ((citizenship == "Others") ? "selected" : "") + '>Others</option>';

                civilstatusHtml = '<option value="" disabled selected>Select...</option>';
                civilstatusHtml += '<option value="Single" ' + ((civil_status == "Single") ? "selected" : "") + '>Single</option>';
                civilstatusHtml += '<option value="Married" ' + ((civil_status == "Married") ? "selected" : "") + '>Married</option>';
                civilstatusHtml += '<option value="Separated" ' + ((civil_status == "Separated") ? "selected" : "") + '>Separated</option>';
                civilstatusHtml += '<option value="Divorced" ' + ((civil_status == "Divorced") ? "selected" : "") + '>Divorced</option>';
                civilstatusHtml += '<option value="Widowed" ' + ((civil_status == "Widowed") ? "selected" : "") + '>Widowed</option>';

                let religion = result.student_details[0].religion;

                religionHtml = '<option value="" disabled>Select...</option>';
                religionHtml += '<option value="Catholic" ' + ((religion == "Catholic") ? "selected" : "") + '>Roman Catholic</option>';
                religionHtml += '<option value="Protestant" ' + ((religion == "Protestant") ? "selected" : "") + '>Protestant</option>';
                religionHtml += '<option value="INC" ' + ((religion == "INC") ? "selected" : "") + '>INC</option>';
                religionHtml += '<option value="Islam" ' + ((religion == "Islam") ? "selected" : "") + '>Islam</option>';
                religionHtml += '<option value="Christian" ' + ((religion == "Christian") ? "selected" : "") + '>Christian</option>';
                religionHtml += '<option value="Others" ' + ((religion == "Others") ? "selected" : "") + '>Others</option>';

                $('#religion').html(religionHtml);
                $('#gender').html(genderHtml);
                $('#citizenship').html(citizenshipHtml);
                $('#civil_status').html(civilstatusHtml);
            }
        });
    });

    // submit updates and save to database
    $('#updateForm').submit(function(e) {
        e.preventDefault();

        $("#updateForm").validate(opt);

        if (!$("#updateForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        let myForm = document.getElementById('updateForm');
        let formData = new FormData(myForm); //use formData for forms with files
            formData.append('_method', 'PUT'); //need to spoof PUT method here because formData and PUT are having an error.. Use POST as method then add this line successfully update the data
        console.log(formData);
        $.ajax({
                url: page_route + "/" + id,
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
            })
            .done(function() {
                alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
                $("#updateForm")[0].reset();
                $('#updateStudentModal').modal('hide');
            })
            .fail(function() {
                alertFailed('Update')
            })

    }

    $('body').on('click', '.deactivate', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to deactivate this item?",
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
                            is_active: 0,
                            _token: _token,
                        }
                    })
                    .done(function() {
                        alertSuccess('Deactivated') //calls function alertSuccess in public\js\main.js
                    })
                    .fail(function() {
                        alertFailed('Deactivate')
                    })
            }
        });
    });

    $('body').on('click', '.activate', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to activate this item?",
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
                            is_active: 1,
                            _token: _token,
                        }
                    })
                    .done(function() {
                        alertSuccess('Activated') //calls function alertSuccess in public\js\main.js
                    })
                    .fail(function() {
                        alertFailed('Activate')
                    })
            }
        });
    });
    $('#import_excel_form').on('submit', function(event) {
        event.preventDefault();
        $('#import').attr('disabled', 'disabled');
        $('#import').val('Importing...');
        $.ajax({
                url: "students/saveMultipleStudents",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
            })
            .done(function(response) {
                if (response.status == "success") {
                    swal_title = 'Added!';
                } else {
                    swal_title = 'Failed!';
                }
                Swal.fire(
                    swal_title,
                    response.msg,
                    response.status
                );
                $('#filtertable').DataTable().ajax.reload();
                $("#import_excel_form")[0].reset();
                $('#addMultipleStudentsModal').modal('hide');
                $('#import').attr('disabled', false);
                $('#import').val('Import');
            })
            .fail(function() {
                alertFailed('Create')
                $('#import').attr('disabled', false);
                $('#import').val('Import');
            })
    });


});