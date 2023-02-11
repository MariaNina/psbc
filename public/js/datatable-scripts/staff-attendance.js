$(function () {

    function GetFromDate() {
        let from_date = $('#from_date').val();
        return from_date;
    }
    function GetToDate() {
        let to_date = $('#to_date').val();
        return to_date;
    }
    function GetDept() {
        let department = $('#department').val();
        return department;
    }
    // function GetPunchType() {
    //     let punch_type = $('#punch_type').val();
    //     return punch_type;
    // }
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
                title: 'Deduction List',
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
            data: function(d) {
                d.from = GetFromDate();
                d.to = GetToDate();
                d.dept = GetDept();
                // d.punch_type = GetPunchType();
            }
        },

        // <th>No.</th>
        // <th>Date</th>
        // <th>Day</th>
        // <th>First Name</th>
        // <th>Last Name</th>
        // <th>Shift</th>
        // <th>Shift Hours</th>
        // <th>Time In</th>
        // <th>Time Out</th>
        // <th>Lates</th>
        // <th>Undertime</th>
        columns: [
            {
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false
                },
            {
                data: "punch_date",
                name: "punch_date",
            },
            {
                data: "punch_day",
                name: "punch_day",
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
                data: "shift",
                name: "shift",
            },
            {
                data: "shift_hours",
                name: "shift_hours",
            },
            
            {
                data: "morning_in",
                name: "morning_in",
            },
            {
                data: "afternoon_out",
                name: "afternoon_out",
            },
            {
                data: "lates",
                name: "lates",
            },
            {
                data: "undertime",
                name: "undertime",
            },
            {
                data: "status",
                name: "status",
            },
        ],

    })
})
