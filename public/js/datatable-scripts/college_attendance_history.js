$(function() {

    // server side datatable
    $('#filtertable').DataTable({
        dom: 'Blfrtip',
        buttons: [{
                extend: 'print',

            },
            {
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data',
                title: 'PSBC List of College Attendance',
            },
        ],
        "responsive": true,
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
        },
        columns: [    {
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex', 
            orderable: false, 
            searchable: false
            },
            {
                data: "first_name",
                name: "first_name",
            },
            {
                data: "last_name",
                name: "last_name",
            },
            {
                data: "action",
                name: "action",
            }
        ],

    })

})