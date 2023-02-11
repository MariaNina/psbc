$(function(){
    $("#attendanceFile").change(function() {

        $("#failed").attr('hidden', true);
        var fileExtension = ['xlsx', 'xls'];

        if (this.files[0].size > 5000000) {
            
            $("#failed").html('Please upload file less than 5MB.');
            $("#failed").attr('hidden', false);
            $(this).val('');

        } else {

            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                // alert("Only formats are allowed : " + fileExtension.join(', '));
                $("#failed").html("Allowed Format: " + fileExtension.join(', '));
                $("#failed").attr('hidden', false);
                $(this).val("");
            } else {
                return true;
            }

        }

    });
    let id; //define a global variable id for edit
    const page_route = 'staff_attendance'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
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
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#addForm").validate(opt); // Validate
    $("#updateLevelForm").validate(opt); // Validate

     // get data by id from schoolyear edit
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // display data to updateschoolyearform
                $('#updateStudentModal').modal('show');
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
        // Do something here if validation is passed.
      let form_data = $("#updateForm").serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
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

    $('#import_excel_form').on('submit', function(event){
        event.preventDefault();
        $('#import').attr('disabled', 'disabled');
        $('#import').val('Importing...');
        $.ajax({
          url:"staff_attendance/saveAttendance",
          method:"POST",
          data:new FormData(this),
          contentType:false,
          cache:false,
          processData:false,
        })
        .done(function(response) {
            Swal.fire(
                'Added!',
                response.msg,
                'success'
            );
            $('#filtertable').DataTable().ajax.reload();
            $("#import_excel_form")[0].reset();
            $('#uplaodAttendance').modal('hide');
            $('#import').attr('disabled', false);
            $('#import').val('Import');
        })
        .fail(function() {
                alertFailed('Create')
                $('#import').attr('disabled', false);
                $('#import').val('Import');
        })
      });
      
    $('#btn_filter').click(function() {
        $('#filtertable').DataTable().ajax.reload();
    });


  });