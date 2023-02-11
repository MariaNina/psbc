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
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false
                },
            {
                data: "image",
                name: "image",
            },
            {
                data: "subject_code",
                name: "subject_code",
            },
            {
                data: "subject_name",
                name: "subject_name",
            },
            {
                data: "subject_description",
                name: "subject_description",
            },
            {
                data: "subject_type",
                name: "subject_type",
            },
            {
                data: "is_for_college",
                name: "is_for_college",
                render: (is_for_college) => {
                    return `<span class="mode ${
                        is_for_college === 1 ? "mode_on" : "mode_off"
                    }">${is_for_college === 1 ? "Yes" : "No"
                    }</span>`;
                },
            },
            {
                data: "lect_unit",
                name: "lect_unit",
            },
            {
                data: "lab_unit",
                name: "lab_unit",
            },
            {
                data: "is_offered",
                name: "is_offered",
                render: (is_offered) => {
                    return `<span class="mode ${
                        is_offered === 1 ? "mode_on" : "mode_off"
                    }">${is_offered === 1 ? "Open" : "Close"
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

