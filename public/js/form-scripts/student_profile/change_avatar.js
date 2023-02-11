$(document).ready(function () {

    $("#avatar_edit").click(function () {
        $("#image").trigger('click');
    });

    // When Image has value
    $('#image').on('change', function () {
        $("#avatar_form").submit();
    })

    // Submit the Form
    $("#avatar_form").submit(function (e) {
        e.preventDefault();

        // Do something here if validation is passed.
        avatarFormSubmit();
    });

    function avatarFormSubmit() {
        // AJAX with Image Uploading
        let myForm = document.getElementById("avatar_form");
        let formData = new FormData(myForm); //use formData for forms with files
        formData.append('_method', 'PUT');

        $.ajax({
            type: "POST",
            url: `/profile/change_avatar`,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                Swal.fire("Updated!", response.msg, "success");

                $("#avatar").attr("src", response.image); // Update UI
                $("#topbar_avatar").attr("src", response.image); // Update UI

            },
            error: function (err) {
                if (err.status === 422) {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: "Profile avatar must be a valid image",
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: "Something went wrong! Please try again later",
                    });
                }
            }
        });
    }
});
