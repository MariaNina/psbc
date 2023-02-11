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
                title: 'PSBC List of Documents',
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
                data: "document_name",
                name: "document_name",
            },
            {
                data: "student_type",
                name: "student_type",
            },
            {
                data: "student_dept",
                name: "student_dept",
            },
            {
                data: "is_required",
                name: "is_required",
                render: (is_required) => {
                    return `<span class="mode ${
                        is_required === 1 ? "mode_on" : "mode_off"
                    }">${is_required === 1 ? "Yes" : "No"
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