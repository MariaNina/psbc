$(document).ready(function () {
    const tableOpt = {
        responsive: true,
        pageLength: 10,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: {
            url: "/get_latest_employees", // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false
                },
            {
                data: "full_name",
                name: "full_name",
            },
            {
                data: "position",
                name: "position",
            },
            {
                data: "is_active",
                name: "is_active",
                render: (is_active) => {
                    if (is_active == 1) {
                        return `<td><span class="mode mode_on">Active</span></td>`;
                    } else {
                        return `<td><span class="mode mode_off">Inactive</span></td>`;
                    }
                },
                orderable: false,
                ordering: false,
            },
        ],
    };

    //  Only Load the Datatable when user click on the events tab
    if (!$.fn.DataTable.isDataTable('#employee_table')) {
        $("#employee_table").DataTable(tableOpt);
    }


});
