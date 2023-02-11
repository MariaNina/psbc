$(function(){ 
    // start of server side datatable
    $('#filtertable').DataTable({

        "processing": true,
        "serverSide": true, 
        "pageLength": 10,

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
                    data: "school_years",
                    name: "school_years",
                },
                {
                    data: "is_active",
                    name: "is_active",
                    render: (is_active) => {
                        return `<span class="mode ${
                            is_active === 1 ? "mode_on" : "mode_off"
                        }">${is_active === 1 ? "Active" : "Inactive"
                        }</span>`;
                    },
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                },
            ],
       
        })
        //   end of server side datatable
})