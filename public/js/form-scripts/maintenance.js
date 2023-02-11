$(document).ready(function () {


    async function toggleMaintenanceMode() {

        try {
            const res = await axios.post('/settings/maintenance');

            Swal.fire({
                title: 'Settings Updated',
                text: res.data.msg,
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            })

        } catch (e) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    }

    // For Maintenance
    //set initial state.
    $('#maintenanceBtn').click(function () {

        Swal.fire({
            title: 'Are you sure?',
            text: "Turn ON/OFF maintenance mode?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {

                toggleMaintenanceMode();

            }
        })
    });

});
