$(function(){
let page_route ="/sections";
$(".js-example-basic-single").select2({
    placeholder:'No selected',
    theme: "bootstrap4",
});
    // server side datatable
    var tbl = $('#filtertable').DataTable({
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'print',
            
            },
            {
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data',
                title: 'PSBC List of Rooms',
            },
        ],
        "responsive": true,
        "pageLength": 10,
        "processing":true,
        "serverSide": true, 
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
        },
        
        columns: [
            {
                data: "DT_RowIndex",
                orderable:false,
               
            },
            {
                data: "section_label",
                name: "section_label",
            },
            {
                data: "branch",
                name: "branch_tbls.branch_name",
            },
            {
                data: "last_name",
                name: "staffs_tbls.last_name",
            },
            {
                data: "level_name",
                name: "levels_tbls.level_name",
            },
            {
                data: "school_year",
                name: "school_year_tbls.school_years",
            },
            {
                data: "is_active",
                name: "is_active",
                render: (is_active) => {
                    return `<span class="mode ${
                        is_active === 1 ? "mode_on" : "mode_off"
                    }">${is_active === 1 ? "Active" : "Inactive"
                    }</span>`;
                },
            },
            {
                data: "action",
                name: "action",
                orderable: false,
            },
        ],
       
      })

        // add section
        $("#SectionForm").submit(function(e){  //use .submit to read html validation

            let schoolYear = $("#schoolYear").val();
            let level = $("#level").val();
            let adviser = $("#adviser").val();
            let branch = $("#branch").val();
            let sectionLabel = $("#sectionLabel").val();
            let _token  = $('meta[name="csrf-token"]').attr('content'); 
            $('#addSectionModal').modal('hide');
            $.ajax({
                type: "POST",
                data:{
                    schoolYear:schoolYear,
                    level:level,
                    adviser:adviser,
                    branch:branch,
                    sectionLabel:sectionLabel,
                    _token: _token
                },
                success: function(data){
                    alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                    tbl.ajax.reload() //reloads the school year datatable
                },
                error: function (xhr, status, errorThrown) {
                    alertFailed('Create')  //calls function alertFailed in public\js\main.js
                }
            });
            e.preventDefault();
        });
        // end of adding section


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
            console.log(result)
            // console.log(result);
            let schoolYearHtml = '';
            let gradeLevelHtml = '';
            let adviserHtml ='';
            let branchHtml ='';
            // display data to edit section
            $('#editSectionModal').modal('show');
            $('#editSection').val(result.getDataById[0].section_label);

            let sy_id = result.getDataById[0].school_year_id;
            let level_id = result.getDataById[0].level_id;
            let adviser_id =result.getDataById[0].staff_id;
            let branch_id =result.getDataById[0].branch_id;
            result.school_year.forEach(sy => {
                schoolYearHtml += '<option  value="'+sy.id+'" '+((sy_id == sy.id) ? "selected" : "")+'>'+sy.school_years+'</option>';
            });
            result.levels.forEach(l => {
                gradeLevelHtml += '<option value="'+l.id+'" '+((level_id == l.id) ? "selected" : "")+'>'+l.level_name+'</option>';
            });
            result.staffs.forEach(s => {
                adviserHtml += '<option value="'+s.id+'" '+((adviser_id == s.id) ? "selected" : "")+'>'+s.last_name+" "+s.first_name+'</option>';
            });
            result.branches.forEach(b => {
                branchHtml += '<option value="'+b.id+'" '+((branch_id == b.id) ? "selected" : "")+'>'+b.branch_name+'</option>';
            });
            $("#editSy").html(schoolYearHtml);
            $("#editLevel").html(gradeLevelHtml);
            $("#editAdviser").html(adviserHtml);
            $("#branchEdit").html(branchHtml);
        })
    });


        // submit updates and save to database
        $('#editSectionForm').submit(function(e) {
            e.preventDefault();
    
            if (!$("#editSectionForm").valid()) {
                return false;
            }

            //id data is valid
            let sy = $.trim($("#editSy").val());
            let gl = $.trim($("#editLevel").val());
            let aa = $.trim($("#editAdviser").val());
            let sn = $.trim($("#editSection").val());
            let branch = $.trim($("#branchEdit").val());
            let _token  = $('meta[name="csrf-token"]').attr('content'); 
            $('#editSectionModal').modal('hide');

            $.ajax({
                url: "sections/"+id,
                type: 'PUT',
                data: {
                    sy: sy,
                    gl: gl,
                    aa: aa,
                    sn: sn,
                    branch: branch,
                    _token: _token,
                },
                success: function(data){
                    alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
                    tbl.ajax.reload() //reloads the school year datatable
                },
                error: function (xhr, status, errorThrown) {
                    alertFailed('Update')  //calls function alertFailed in public\js\main.js
                }
            });
        });

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
                        url:"sections/"+id,
                        type: "DELETE",
                        data: {
                            is_active: 0,
                            _token: _token,
                        },
                        success: function(data){
                            alertSuccess('Deactivated') //calls function alertSuccess in public\js\main.js
                            tbl.ajax.reload() //reloads the school year datatable
                        },
                        error: function (xhr, status, errorThrown) {
                            alertFailed('Deactivate')  //calls function alertFailed in public\js\main.js
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
                    let _token  = $('meta[name="csrf-token"]').attr('content'); 
                    // console.log(id)
                    $.ajax({
                        url:"sections/"+id,
                        type: "DELETE",
                        data: {
                            is_active: 1,
                            _token: _token,
                        },
                        success: function(data){
                            alertSuccess('Activated') //calls function alertSuccess in public\js\main.js
                            tbl.ajax.reload() //reloads the school year datatable
                        },
                        error: function (xhr, status, errorThrown) {
                            alertFailed('Activate')  //calls function alertFailed in public\js\main.js
                        }
                    });
                }
            });
        });
        //Add Schedule
        $('body').on('click', '.text-secondary', function(e) {
            id = $(this).data('id');
            let _token  = $('meta[name="csrf-token"]').attr('content'); 
        console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
        })
        .done((result)=>{
            console.log(result.getDataById.curri_id);
            //$('#showScheduleModal').modal('show');
            let cur_id = result.curri_id;
            location.href ="/schedule?token="+_token+"&section="+id+"&curriculum=+"+cur_id;
        })
        });

        //View Schedule
        $('body').on('click', '.text-info', function(e) {
            id = $(this).data('id');
            let _token  = $('meta[name="csrf-token"]').attr('content'); 
        console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
        })
        .done((result)=>{
            let cur_id = result.curri_id;
            location.href ="/schedule?-token="+_token+"&section="+id+"&curriculum=+"+cur_id;
        })
        });

})

