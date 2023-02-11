$(function(){
    $(".js-example-basic-single").select2({
        placeholder:'No selected',
        theme: "bootstrap4",
    });
    let id; //define a global variable id for edit
    const page_route = 'staff_other_earnings'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            amount:{
                number: true,
                required: true,
            },
            staff_name: {
                required: true,
            },
            earning: {
                required: true,
            },
            period: {
                required: true,
            },
            status: {
                required: true,
            }
        },
        messages: {
        
            // staff_name: {
            //     required: 'true',
            // },
            // deduction: {
            //     required: true,
            // },
            // period: {
            //     required: true,
            // },
            // status: {
            //     required: true,
            // }
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
         // add grade level
      $("#addForm").submit(function(e){
        
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
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#addForm")[0].reset();
                $('#addAllowanceModal').modal('hide');
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
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // display data to updateschoolyearform
            
                $('#updateAllowanceModal').modal('show');

                let staffs_html = '';
                let earnings_html = '';
                let period_html = '';
                let status_html = '';

                let staff_id = result.getDataById[0].staff_id;
                let earnings_id = result.getDataById[0].earnings_id;
                let cut_off = result.getDataById[0].cut_off;
                let status = result.getDataById[0].status;

                status_html +='<option value="Pending" '+((status == "Pending") ? "selected" : "")+'>Pending</option>';
                status_html +='<option value="Approve" '+((status == "Approve") ? "selected" : "")+'>Approved</option>';
                status_html +='<option value="Paid" '+((status == "Paid") ? "selected" : "")+'>Paid</option>';
                status_html +='<option value="Rejected" '+((status == "Rejected") ? "selected" : "")+'>Rejected</option>';

                $('#status').html(status_html);

                period_html +='<option value="semi-monthly" '+((cut_off == "semi-monthly") ? "selected" : "")+'>Semi-Monthly</option>';
                period_html +='<option value="monthly"  '+((cut_off == "monthly") ? "selected" : "")+'>Monthly</option>';

                $('#period').html(period_html);

                result.staffs.forEach(staff => {
                    staffs_html += '<option value="'+staff.id+'" '+((staff_id == staff.id) ? "selected" : "")+'>'+staff.first_name+' '+staff.last_name+'</option>';
                });

                $('#staff_name').html(staffs_html);

                result.earnings.forEach(earning => {
                    earnings_html += '<option value="'+earning.id+'" '+((earnings_id == earning.id) ? "selected" : "")+'>'+earning.earning_name+'</option>';
                });

                $('#earnings').html(earnings_html);
              
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
          $('#updateAllowanceModal').modal('hide');
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
    $('#import_excel_form').on('submit', function(event){
        event.preventDefault();
        $('#import').attr('disabled', 'disabled');
        $('#import').val('Importing...');
        $.ajax({
          url:"students/saveMultipleStudents",
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