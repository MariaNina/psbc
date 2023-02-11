$(function () {
    // Datatable

    // var dataTable = $("#filtertable").DataTable({
        // dom: '<"top">ct<"top"p><"clear">',
        //pageLength: 5,
    // });

    $("#filterbox").keyup(function () {
        dataTable.search(this.value).draw();
    });

    $("#pageFilter").change(function () {
        let tablePageLength = parseInt(this.value);

        dataTable.page.len(tablePageLength).draw();
    });

    // Logout
    $("#logout-btn").click(function () {
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to logout?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Logout",
        }).then((result) => {
            if (result.isConfirmed) {
                $('#logoutForm').submit();
            }
        });
    });

    // Navbar
    $("#sidebarCollapse").on("click", function () {
        $("#sidebar, #content").toggleClass("active");
    });

    /*
    const data = {
        labels: ["Red", "Blue", "Yellow"],
        datasets: [
            {
                label: "My First Dataset",
                data: [300, 50, 100],
                backgroundColor: [
                    "rgb(255, 99, 132)",
                    "rgb(54, 162, 235)",
                    "rgb(255, 205, 86)",
                ],
                hoverOffset: 4,
            },
        ],
    };

    // Pie Chart
    const config = {
        type: "pie",
        data: data,
        options: {},
    };

    // Line Chart
    const labels = ["January", "February", "March", "April", "May", "June"];
    const lineData = {
        labels: labels,
        datasets: [
            {
                label: "Enrolees",
                backgroundColor: "rgb(255, 99, 132)",
                borderColor: "rgb(255, 99, 132)",
                data: [0, 10, 5, 2, 20, 30, 45],
            },
        ],
    };

    const lineConfig = {
        type: "line",
        data: lineData,
        options: {},
    };

    var myChart = new Chart(document.getElementById("pie"), config);
    var myChart = new Chart(document.getElementById("line"), lineConfig);
    */
});

function alertSuccess(status)
{
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'success',
        title: 'Successfully '+status
      })

      reloadDatatable()
}

function alertFailed(status)
{
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'error',
        title: 'Failed to '+status
      })

      reloadDatatable()
}

function reloadDatatable()
{
    $('#filtertable').DataTable().ajax.reload()
}
