$(function () {
    // server side datatable
   var table = $('#filtertable').DataTable({
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'print',

            },
            {
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data',
                title: 'Earnings List',
            },
        ],
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]],
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
                data: "staffs.first_name",
                name: "staffs.last_name",
                render: function ( data, type, row ) {
                    return data+ ' ' + row.staffs.last_name;
                }
            },
            {
                data: "other_earnings.earning_name",
                name: "other_earnings.earning_name"
            },
            {
                data: "other_earnings.amount",
                name: "other_earnings.amount"
            },
            {
                data: "cut_off",
                name: "cut_offf"
            },
            {
                data: "status",
                name: "status",
                render: (status) => {
                    return `<span class="mode ${
                        status === 'Paid' ? "mode_on" :  status === 'Approve' ? "mode_done" : "mode_off"
                    }">${status}</span>`;
                },
            },
            {
                data: "action",
                name: "action",
                orderable: false,
            }
        ],

    })

})
