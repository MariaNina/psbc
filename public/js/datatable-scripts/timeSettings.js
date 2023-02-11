$(function () {

    $(".select2").select2({
        placeholder: 'No selected days'
    });

    const tableOpt = {
        responsive: true,
        pageLength: 10,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: {
            url: "/time_settings", // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: "No",
                name: "No",
            },
            {
                data: "staff_name",
                name: "staff_name",
            },
            {
                data: "morning_in",
                name: "morning_in",
            },
            {
                data: "morning_out",
                name: "morning_out",
            },
            {
                data: "afternoon_in",
                name: "afternoon_in",
            },
            {
                data: "afternoon_out",
                name: "afternoon_out",
            },
            {
                data: "days",
                name: "days",
            },
            {
                data: "required_time",
                name: "required_time",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                ordering: false,
            },
        ],
    };

    // Only Initialize Datatable If Not Initialized
    if (!$.fn.DataTable.isDataTable('#filtertable')) {
        $("#filtertable").DataTable(tableOpt);
    }

});
