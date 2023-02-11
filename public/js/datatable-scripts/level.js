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
                title: 'PSBC List of Levels',
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
                data: "level_code",
                name: "level_code",
            },
            {
                data: "level_name",
                name: "level_name",
            },
            {
                data: "student_dept",
                name: "student_dept",
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
  });