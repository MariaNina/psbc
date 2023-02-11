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
                title: 'PSBC List of Audit Trail',
            },
        ],
        "responsive": true,
        "pageLength": 10,
        "processing": true,
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
                data: "user_name",
                name: "users_tbls.user_name",
            },
            {
                data: "description",
                name: "description",
            },
            {
                data: "ip",
                name: "ip",
            },
            {
                data: "datetime",
                name: "datetime",
            },
        ],

    })

})