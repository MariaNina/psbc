$(function () {
    const tableOpt = {
        responsive: true,
        pageLength: 10,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: {
            url: "/events/datatable", // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: "image",
                name: "image",
                render: (image) => {

                    if (image.includes('https://')) {
                        return `<img src="${image}" alt="${image}" width="80"
                                 height="80">
                            `;
                    } else {
                        return `<img src="/storage${image}" alt="${image}" width="80"
                                 height="80">
                            `;
                    }


                },
                orderable: false,
                ordering: false,
            },
            {
                data: "title",
                name: "title",
            },
            {
                data: "body",
                name: "body",
            },
            {
                data: "upcoming_at",
                name: "upcoming_at",
            },
            {
                data: "status",
                name: "status",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                ordering: false,
            },
        ],
    };

    //  Only Load the Datatable when user click on the events tab
    $('#events_tab_btn').click(function () {
        // Only Initialize Datatable If Not Initialized
        if (!$.fn.DataTable.isDataTable('#filtertable')) {
            $("#filtertable").DataTable(tableOpt);
        }
    });


});
