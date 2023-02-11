$(function(){

    // server side datatable
    $('#filtertable').DataTable({
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'print',
            
            },
            {
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data',
                title: 'PSBC List of College Curriculums',
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
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false
                },
            {
                data: "curriculum_year",
                name: "curriculum_tbls.curriculum_year", 
            },
            {
                data: "program_name",
                name: "programs_tbls.program_name",
            },
            {
                data: "major_name",
                name: "majors_tbls.major_name",
            },
            
            {
                data: "curriculum_description",
                name: "curriculum_tbls.curriculum_description",
            },
            {
                data: "student_department",
                name: "curriculum_tbls.student_department",
            },
            {
                data: "level_name",
                name: "levels_tbls.level_name",
            },
            {
                data: "school_years",
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

})