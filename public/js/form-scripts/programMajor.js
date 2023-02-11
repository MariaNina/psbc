$(document).ready(function () {
    let id = ""; //define a global variable id for edit
    const page_route = "programmajors";
    const opt = {
        errorElement: "div",
        rules: {
            programName: "required",
            majorName: "required",
            description: {
                required: false,
                maxlength: 100
            }
        },
        messages: {
            programName: {
                required: "Program name is required",
            },
            majorName: {
                required: "Major name is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };


    $("#programMajorError").hide();
    $("#programMajorError2").hide();
    $("#ProgramMajorForm").validate(opt); // Validate
    $("#updProgramMajorForm").validate(opt); // Validate

    // Check validation if submit
    $("#ProgramMajorForm").submit(function (e) {
        e.preventDefault();

        $("#ProgramMajorForm").validate(opt);

        if (!$("#ProgramMajorForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
    });


     // get data by id from program major edit
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
        })
        .done((result)=>{
            // console.log(result);
            let html = '';
                
            let programshtml = '';
            let majorshtml = '';

            // display data to program major
            $('#editProgramMajorModal').modal('show');
            $('#up_description').val(result.getDataById[0].description);

            let program_id = result.getDataById[0].program_id;
            let major_id = result.getDataById[0].major_id;
            let studentDept =result.getDataById[0].student_department;
            result.programs.forEach(p => {
                programshtml += '<option value="'+p.id+'" '+((program_id == p.id) ? "selected" : "")+'>'+p.program_name+'</option>';
            });

            result.majors.forEach(m => {
                majorshtml += '<option value="'+m.id+'" '+((major_id == m.id) ? "selected" : "")+'>'+m.major_name+'</option>';
            });
            html = '<option value="Elementary"'+((studentDept == "Elementary") ? "selected" : "")+'>Elementary</option>';
                html += '<option value="JHS" '+((studentDept == "JHS") ? "selected" : "")+'>JHS</option>';
                html += '<option value="SHS" '+((studentDept == "SHS") ? "selected" : "")+'>SHS</option>';
                html += '<option value="College" '+((studentDept == "College") ? "selected" : "")+'>College</option>';

                $('#upd_studentDept').html(html);
            $('#up_programName').html(programshtml);
            $('#up_majorName').html(majorshtml);

        })
    });

    // submit updates and save to database
    $('#updProgramMajorForm').submit(function(e) {
        e.preventDefault();

        $("#updProgramMajorForm").validate(opt);

        if (!$("#updProgramMajorForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function createData() {
        // Do something here if validation is passed.
        let form_array = $("#ProgramMajorForm").serialize();

        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#ProgramMajorForm")[0].reset();
                $("#programMajorError").hide();
                $('#addProgramMajorModal').modal('hide');
                tbl .reload();
          })
          .fail(function(response) {
            $("#programMajorError").show();
            $('#errorMessage').html(""); //clear html elements
            //check the error tresponse
            let errorText = response.responseJSON.errors;
            for (var key in errorText) {
                    $('#errorMessage').append(errorText[key]+"<br />");
            }
            console.log("Something went Wrong");
                alertFailed('Create')
          })
    }

       const updateData = () => {
          // Do something here if validation is passed.
        let form_data = $("#updProgramMajorForm").serialize();

        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function() {
            alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
            $("#updProgramMajorForm")[0].reset();
            $('#editProgramMajorModal').modal('hide');
            $("#programMajorError2").hide();
        })
        .fail(function(response) {
            $("#programMajorError2").show();
            $('#errorMessage2').html(""); //clear html elements
            //check the error tresponse
            let errorText = response.responseJSON.errors;
            for (var key in errorText) {
                    $('#errorMessage2').append(errorText[key]+"<br />");
            }
            $('#errorMessage2').append("Wrong Entry");
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
                let _token  = $('meta[name="csrf-token"]').attr('content');
                // console.log(id)
                $.ajax({
                    url: page_route+"/"+id,
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
                let _token  = $('meta[name="csrf-token"]').attr('content');
                // console.log(id)
                $.ajax({
                    url: page_route+"/"+id,
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

});
