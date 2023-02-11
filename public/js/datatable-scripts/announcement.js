$(function () {
    const tableOpt = {
        responsive: true,
        pageLength: 10,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        ajax: {
            url: "/all-announcements", // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: "announcement_image",
                name: "announcement_image",
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
                data: "announcement_title",
                name: "announcement_title",
            },
            {
                data: "announcement_body",
                name: "announcement_body",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                ordering: false,
            },
        ],
    };

    // Only Load the Datatable when user click on the announcement tab
    $('#announcement_tab_btn').click(function () {

        // Only Initialize Datatable If Not Initialized
        if (!$.fn.DataTable.isDataTable('#announcementTable')) {
            $("#announcementTable").DataTable(tableOpt);
        }

    });


});
