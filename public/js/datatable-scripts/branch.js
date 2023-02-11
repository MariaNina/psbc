$(function () {

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
                title: 'PSBC List of Branches',
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
                data: "branch_name",
                name: "branch_name",
            },
            {
                data: "branch_address",
                name: "branch_address",
            },
            {
                data: "description",
                name: "description",
            },
            {
                data: "email",
                name: "email",
            },
            {
                data: "telephone_no",
                name: "telephone_no",
            },
            {
                data: "mobile_no",
                name: "mobile_no",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
        ],

    })

})
