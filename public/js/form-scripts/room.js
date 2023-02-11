$(document).ready(function () {
    const opt = {
        errorElement: "div",
        rules: {
            room_number: {
                required: true,
            },
            room_desc: {
                required: false,
                maxlength: 100
            },
            update_room_number: "required",

        },
        messages: {
            room_number: {
                required: "Room number is required",
            },
            update_room_number: {
                required: "Room number is required",
            },

        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    //hide and validation
    $("#roomError").hide();
    $("#roomError2").hide();
    $("#RoomForm").validate(opt); // Validate
    $("#updateRoomForm").validate(opt); // Validate

    // Check validation if submit
    $("#RoomForm").submit(function (e) {
        e.preventDefault();

        $("#RoomForm").validate(opt);

        if (!$("#RoomForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        requestToServer();
    });

    $("#updateRoomForm").submit(function (e) {
        e.preventDefault();

        $("#updateRoomForm").validate(opt);

        if (!$("#updateRoomForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        requestToServer();
    });

    function requestToServer() {
        // Do something here if validation is passed.
        console.log("Validated");
    }

    // add room
    $("#RoomForm").submit(function (e) {  //use .submit to read html validation

        let room_number = $("#room_number").val();
        let room_desc = $("#room_desc").val();
        let room_branch = $("#branchName").val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            data: {
                room_number: room_number,
                room_branch: room_branch,
                room_desc: room_desc,
                _token: _token
            },
            success: function (data) {
                $('#addRoomModal').modal('hide');
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                tbl.ajax.reload() //reloads the school year datatable
            },
            error: function (response) {
                $("#roomError").show();
                $('#errorMessage').html(""); //clear html elements
                //check the error tresponse
                let errorText = response.responseJSON.errors;
                for (var key in errorText) {
                    $('#errorMessage').append(errorText[key] + "<br />");
                }
                alertFailed('Create')  //calls function alertFailed in public\js\main.js
            }
        });
        e.preventDefault();
    });
    // end of adding room


    // get data by id from room edit
    $('body').on('click', '.editData', function (e) {
        // e.preventDefault();
        let branchHtml ="";
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: "rooms/" + id + "/edit",
            type: "GET",
            success: function (result) {
                let branches = result.branches;
                let =branch_id = result.getDataById.branch_id;
                // display data to updateschoolyearform
                $('#editRoomModal').modal('show');
                $('#updateId').val(result.id);
                $('#update_room_number').val(result.getDataById.room_no);
                $('#update_room_desc').val(result.getDataById.room_description);
                branches.forEach(b => {
                    branchHtml += '<option value="'+b.id+'" '+((branch_id == b.id) ? "selected" : "")+'>'+b.branch_name+'</option>';
                });
                $("#editBranchName").html(branchHtml);
                console.log(result)
            }
        });
    });

    // submit updates and save to database
    $('#updateRoomForm').submit(function (e) {
        e.preventDefault();

        if (!$("#updateRoomForm").valid()) {
            return false;
        }

        //id data is valid
        let rn = $.trim($("#update_room_number").val());
        let rd = $.trim($("#update_room_desc").val());
        let branch_id =$("#editBranchName").val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "rooms/" + id,
            type: 'PUT',
            data: {
                rn: rn,
                rd: rd,
                branch_id: branch_id,
                _token: _token,
            },
            success: function (data) {
                $("#roomError2").hide();
                $('#editRoomModal').modal('hide');
                alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
                //tbl.ajax.reload() //reloads the school year datatable
            },
            error: function (response) {
                $("#roomError2").show();
                $('#errorMessage2').html(""); //clear html elements
                //check the error tresponse
                let errorText = response.responseJSON.errors;
                for (var key in errorText) {
                    $('#errorMessage2').append(errorText[key] + "<br />");
                }
                alertFailed('Update')  //calls function alertFailed in public\js\main.js
            }
        });
    });

    $('body').on('click', '.deactivate', function (e) {
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
                    url: "rooms/" + id,
                    type: "DELETE",
                    data: {
                        is_active: 0,
                        _token: _token,
                    },
                    success: function (data) {
                        alertSuccess('Deactivated') //calls function alertSuccess in public\js\main.js
                       // tbl.ajax.reload() //reloads the school year datatable
                    },
                    error: function (xhr, status, errorThrown) {
                        alertFailed('Deactivate')  //calls function alertFailed in public\js\main.js
                    }
                });
            }
        });
    });

    $('body').on('click', '.activate', function (e) {
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
                    url: "rooms/" + id,
                    type: "DELETE",
                    data: {
                        is_active: 1,
                        _token: _token,
                    },
                    success: function (data) {
                        alertSuccess('Activated') //calls function alertSuccess in public\js\main.js
                       // tbl.ajax.reload() //reloads the school year datatable
                    },
                    error: function (xhr, status, errorThrown) {
                        alertFailed('Activate')  //calls function alertFailed in public\js\main.js
                    }
                });
            }
        });
    });

    $(".js-example-basic-single").select2({
        placeholder:'No selected',
        theme: "bootstrap4",
    });
});
