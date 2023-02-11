$(document).ready(function () {

    $('#filtertable_length label select').val(5)

    var dataTable = $("#filtertable").DataTable({

		"processing": true,  
        "serverSide": true, 
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: "id",
                name: "id",
            },
            {
                data: "image",
                name: "image", // Custom Render
                render: (image, type, full, meta) => {
                    return `<img class="avatar" src="${image}" width="35" height="35" />`;
                },
                orderable: false,
            },
            {
                data: "name",
                name: "name",
            },
            {
                data: "date",
                name: "date",
            },
            {
                data: "status",
                name: "status",
                render: (status) => {
                    return `<span class="mode ${
                        status === "Active" ? "mode_on" : "mode_off"
                    }">${status}</span>`;
                },
            },
            {
                data: "action",
                name: "action",
                orderable: false,
            },
        ],
        pageLength: 5
    });
});
