$(document).ready(function() {
    let id; //define a global variable id for edit
    const page_route = "subjects";
    const opt = {
        errorElement: "div",
        rules: {
            subject_name: "required",
            subject_code: "required",
            subject_type: "required",
            subject_desc: "required",
            subject_image: {
                required: false,
                extension: "jpeg|jpg|png|gif",
            },
            is_for_college: "required",
            lab_units: "required",
            lect_units: "required",
        },
        messages: {
            subject_name: {
                required: "Subject name is required",
            },
            subject_code: {
                required: "Subject code is required",
            },
            subject_type: {
                required: "Subject type is required",
            },
            subject_desc: {
                required: "Subject description is required",
            },
            subject_image: {
                required: "Subject image is required",
            },
            is_for_college: {
                required: "Please select one of the options",
            },
            lab_units: {
                required: "Lab units must not be empty",
            },
            lect_units: {
                required: "Lect units must not be empty",
            },
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#SubjectForm").validate(opt); // Validate
    $("#editSubjectForm").validate(opt);

    // Check validation if submit
    $("#SubjectForm").submit(function(e) {
        e.preventDefault();

        $("#SubjectForm").validate(opt);

        if (!$("#SubjectForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        createData();
    });

    // add subject
    function createData() {
        // Do something here if validation is passed.
        let myForm = document.getElementById('SubjectForm');
        let formData = new FormData(myForm); //use formData for forms with files
        // console.log(formData);
        $.ajax({
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
            })
            .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#SubjectForm")[0].reset();
                $('#addSubjectModal').modal('hide');
            })
            .fail(function(res) {
                alertFailed('Create')
                console.log(res);
            })
    }


    // get data by id from room edit
    $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route + "/" + id + "/edit",
            type: "GET",
            success: function(result) {
                // display data to updateschoolyearform
                $('#editSubjectModal').modal('show');
                $('#edit_subject_code').val(result[0].subject_code);
                $('#edit_subject_name').val(result[0].subject_name);

                $('#edit_subject_desc').val(result[0].subject_description);
                $('#edit_lect_units').val(result[0].lect_unit);
                $('#edit_lab_units').val(result[0].lab_unit);
                $('#edit_is_for_college').val(result[0].is_for_college);
                if (result[0].is_for_college === 1) {
                    $("#edit_is_for_college").prop("checked", true);
                }
                let html = '';
                let is_college_html = '';
                let edit_subject_type = result[0].subject_type;
                let is_for_college = result[0].is_for_college;
                html = '<option value="Acad" ' + ((edit_subject_type == "Acad") ? "selected" : "") + '>Academic</option>';
                html += '<option value="Non-acad" ' + ((edit_subject_type == "Non-acad") ? "selected" : "") + '>Non-Academic</option>';

                is_college_html = '<option value="1" ' + ((is_for_college == "1") ? "selected" : "") + '>Yes</option>';
                is_college_html += '<option value="0" ' + ((is_for_college == "0") ? "selected" : "") + '>No</option>';

                $('#edit_subject_type').html(html);
                $('#edit_is_for_college').html(is_college_html);
                // console.log(result)
            }
        });
    });

    // submit updates and save to database
    $('#editSubjectForm').submit(function(e) {
        e.preventDefault();

        if (!$("#editSubjectForm").valid()) {
            return false;
        }

        //if data is valid call function to run
        updateData();
    });

    function updateData() {
        // Do something here if validation is passed.
        let myForm = document.getElementById('editSubjectForm');
        let formData = new FormData(myForm); //use formData for forms with files
        formData.append('_method', 'PUT'); //need to spoof PUT method here because formData and PUT are having an error.. Use POST as method then add this line successfully update the data
        console.log(formData);
        $.ajax({
                url: page_route + "/" + id,
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
            })
            .done(function() {
                alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
                $("#editSubjectForm")[0].reset();
                $('#editSubjectModal').modal('hide');
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
                        is_offered: 0,
                        _token: _token,
                    },
                    success: function(data) {
                        alertSuccess('Deactivated') //calls function alertSuccess in public\js\main.js
                        tbl.ajax.reload() //reloads the school year datatable
                    },
                    error: function(xhr, status, errorThrown) {
                        alertFailed('Deactivate') //calls function alertFailed in public\js\main.js
                    }
                });
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
                        is_offered: 1,
                        _token: _token,
                    },
                    success: function(data) {
                        alertSuccess('Activated') //calls function alertSuccess in public\js\main.js
                        tbl.ajax.reload() //reloads the school year datatable
                    },
                    error: function(xhr, status, errorThrown) {
                        alertFailed('Activate') //calls function alertFailed in public\js\main.js
                    }
                });
            }
        });
    });
});