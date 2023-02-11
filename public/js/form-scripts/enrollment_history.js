$(document).ready(function () {

    let page_route = 'enrollment_history';

    $("#addEnrollment").submit(function (e) {
        e.preventDefault();

        // $("#addEnrollment").validate(opt);

        // if (!$("#addEnrollment").valid()) {
        //     return false;
        // }

        // Do something here if validation is passed.
        createData();
    });
    function createData(){
        // Do something here if validation is passed.
        let form_array = $("#addEnrollment").serializeArray(); 
        console.log(form_array)
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function(response) {
            Swal.fire(
                response.status,
                response.msg,
                response.status
            );
            $('#filtertable').DataTable().ajax.reload();
                $("#addEnrollment")[0].reset();
                $("#addModal").modal('hide');
          })
          .fail(function(response) {
            alertFailed('Create')
          })
    }
    $('#add_student_department').on('change', function () {

        let stud_dept = $(this).val();
        let stud_level = $('#add_student_level').val();
        let branch_id = $('#add_branch').val();
        let type = 'add';
        getLevelsByStudDept(stud_dept,type);
        getCurriculumByStudDeptAndLevel(stud_dept,stud_level,branch_id,type);
    });

    $('#add_student_level').on('change', function () {
        
        let stud_dept = $('#add_student_department').val();
        let stud_level = $(this).val();
        let branch_id = $('#add_branch').val();
        let type = 'add';
        getCurriculumByStudDeptAndLevel(stud_dept,stud_level,branch_id,type);
        
    });

    $('#add_curriculum').on('change', function () {
        getSubjectByCurAdd();
    });
    function getLevelsByStudDept(stud_dept,type) {

       
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "enrollment/getLevelsByStudDept",
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

                if(type == 'add'){
                    $('#add_student_level').html(levelHtml);
                    // console.log(levelHtml)
                }else{
                    $('#student_level').html(levelHtml);
                }
               

            }
        });
    }

    function getCurriculumByStudDeptAndLevel(stud_dept,stud_level,branch_id,type) {

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
            success: function (result) {
                // console.log(result)
                let Html = '<option value="" disabled selected>Select...</option>';
                result.curriculums.forEach(curriculum => {
                    Html += '<option value="' + curriculum.id + '">' + curriculum.pname + ' - ' + curriculum.mname + '</option>';
                });
                if(type == 'add'){
                    $('#add_curriculum').html(Html);
                }else{
                    $('#curriculum').html(Html);
                }
               

            }
        });
    }

    function getSubjectByCurAdd(){

        let curriculum = $('#add_curriculum').val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `students_enrollment/getSubjectByCurAjaxAdd`,
            type: "POST",
            data: {
                curriculum: curriculum,
                _token: _token
            },
            success: function (result) {
                $('#subject-list').DataTable().destroy();
                // console.log(result)
                $('#add_subject_tbl').html(result);
                setSubjectDatatableAdd();

            }
        });
    }
    function setSubjectDatatableAdd(){

        var table = $('#subject-list-add').DataTable({
            'dom': 't',
            'columnDefs': [
                {
                    'targets': 0,
                    'className': 'dt-body-center',
                  
                },
                {
                    "orderable": false,
                    "targets": [0, 2]
                }
            ],
            'order': [1, 'asc']
        });

        $(document).on('click', '#subject-list-add-select-all', function () {
            // Check/uncheck all checkboxes in the table
            var rows = table.rows({'search': 'applied'}).nodes();
            $('input[type="checkbox"]', rows)
                .prop('checked', this.checked);
            if (this.checked) {
                $('input[type="checkbox"]', rows).closest('tr').addClass('tr-selected');
            } else {
                $('input[type="checkbox"]', rows).closest('tr').removeClass('tr-selected');
            }
        });

        // Handle click on checkbox to set state of "Select all" control
        $('#subject-list-add tbody').on('change', 'input[type="checkbox"]', function () {
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

        $(document).on('click', '.custom-control-input-add', function () {
            if ($(this).prop('checked')) {
                $(this).closest('td').closest('tr').addClass('tr-selected');
            } else {
                $(this).closest('td').closest('tr').removeClass('tr-selected');
            }
        });
    }

    
});
