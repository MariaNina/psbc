$(function(){


    let id; //define a global variable id for edit
    const page_route = 'users'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            firstName: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            lastName: {
                required: true,
                minlength: 2,
                maxlength: 100
            },
            branchName: {
                required: true,
                minlength: 1,
                maxlength: 100
            },
            roleName: {
                required: true,
                minlength: 1,
                maxlength: 100
            },
            username: {
                required: true,
                minlength: 8,
                maxlength: 100
            },
            email: {
                required: true,
                minlength: 9,
                maxlength: 100
            },
        },
        messages: {
            firstName: {
                required: "First Name is required",
            },
            lastName: {
                required: "Last Name is required",
            },
            branchName: {
                required: "Branch Name is required",
            },
            roleName: {
                required: "Role Name is required",
            },
            username: {
                required: "User Name is required",
            },
            email: {
                required: "Email Address name is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("body").on("click", ".createUser", function (e) {
        id = $(this).data("id");
        console.log(id);
    })

    $("#userError").hide();
    $("#userError2").hide();
    $("#addUserForm").validate(opt); // Validate
    $("#editUserForm").validate(opt); // Validate
    var user_id = '';

    function createData() {
        // Do something here if validation is passed.
        let form_array = $("#addUserForm").serialize();
        let usn = 0;
        $.post("",form_array,function(resp){
            //alertSuccess('Created') //calls function alertSuccess in public\js\main.js
        })
          .done(function(resp) {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#addUserForm")[0].reset();
                $('#addUserModal').modal('hide');
                $("#userError").hide();
          })
          .fail(function(response) {
                $("#userError").show();
                $('#errorMessage').html(""); //clear html elements
                //check the error tresponse
                let errorText = response.responseJSON.errors;
                for (var key in errorText) {
                        $('#errorMessage').append(errorText[key]+"<br />");
                }
                alertFailed('Create')
          });
    }

    // Check validation if submit
    $("#addUserForm").submit(function (e) {
        e.preventDefault();

        $("#addUserForm").validate(opt);

        if (!$("#addUserForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData();
        
});

     // get data by id from user edit
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
        })
        .done((result)=>{
            console.log(result.permissions);
            let rolehtml = '';
            let branchhtml = '';
            let first_name ='';
            let last_name ='';
            let page_name ='';
            let middle_name ='';
            // let permissionHtml =""
            let pagesHtml =""
            // display data to program major
            $('#editUserModal').modal('show');
            $('#upemail').val(result.getDataById[0].email);
            $('#upusername').val(result.getDataById[0].user_name);

            let role_id = result.getDataById[0].role_id;
            let branch_id = result.getDataById[0].branch_id;
            let user_id =result.getDataById[0].id;
            // console.log(result.getDataById[0].id);
            result.roles.forEach(r => {
                rolehtml += '<option value="'+r.id+'" '+((role_id == r.id) ? "selected" : "")+'>'+r.role_name+'</option>';
            });

            result.branches.forEach(b => {
                branchhtml += '<option value="'+b.id+'" '+((branch_id == b.id) ? "selected" : "")+'>'+b.branch_name+'</option>';
            });
            console.log('branch'+branchhtml);
            result.staffs.forEach(s => {
                console.log(s.user_id);
                first_name += (user_id == s.user_id) ? s.first_name:"";
                middle_name += (user_id == s.user_id) ? s.middle_name:"";
                last_name += (user_id == s.user_id) ? s.last_name:"";
            });
            
            // result.permissions.forEach(per =>{
            //     permissionHtml += '<option value="'+per.id+'" '+((user_id == per.user_id) ? "selected" : "")+'>'+per.page_name+'</option>';
            // })
            let permissionsArray =[];
            result.permissions.forEach(per =>{
                permissionsArray.push(per.page_id);
            })
            result.pages.forEach(page =>{
                pagesHtml += '<option value="'+page.id+'" '+((permissionsArray.includes(page.id)) ? "selected" : "")+'>'+page.page_name+'</option>';
            })
            $('#upbranchName').html(branchhtml);
            $('#uproleName').html(rolehtml);
            if(role_id!=3){
            // $('#editPermission').html(permissionHtml);
            $('#editPermission').html(pagesHtml);
            }else{
                $('#editPermission').html("<option selected>N/A</option>");  
            }
            $('#hidden').val(user_id);
            $('#upfirstName').val(first_name);
            $('#upmiddleName').val(middle_name);
            $('#uplastName').val(last_name);
            
        })
    });

    // submit updates and save to database
    $('#editUserForm').submit(function(e) {
        e.preventDefault();

        $("#editUserForm").validate(opt);

        if (!$("#editUserForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    

    function updateData() {
          // Do something here if validation is passed.
        let form_data = $("#editUserForm").serialize();

        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function() {
            alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
            $("#editUserForm")[0].reset();
            $('#editUserModal').modal('hide');
            $("#userError2").hide();
        })
        .fail(function(response) {
            $("#userError2").show();
                $('#errorMessage2').html(""); //clear html elements
                //check the error tresponse
                let errorText = response.responseJSON.errors;
                for (var key in errorText) {
                        $('#errorMessage2').append(errorText[key]+"<br />");
                }
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
    $(".select2").select2();

})
