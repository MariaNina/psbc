$(function(){

    $(".js-example-basic-single").select2({
        placeholder:'No selected',
        theme: "bootstrap4",
    });
    
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
                title: 'PSBC List of Colleges',
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
                data: "branch_name",
                name: "branch_tbls.branch_name",
            },
            {
                data: "college_name",
                name: "colleges_tbls.college_name",
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
                data: "isActive",
                name: "is_active",
                render: (isActive) => {
                    return `<span class="mode ${
                        isActive === 1 ? "mode_on" : "mode_off"
                    }">${isActive === 1 ? "Active" : "Inactive"
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