$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let id;

    $('body').on('click', '.reset-password-btn', function () {

        id = $(this).attr("data-id");

        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to reset this user's password?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: '/users/reset-password',
                    type: "PUT",
                    data: {id},
                    success: function (response) {
                        Swal.fire("Updated!", response.msg, "success");
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: "error",
                            title: "Failed",
                            text: error.msg,
                        });
                    }
                })

            }
        });
    })

});
