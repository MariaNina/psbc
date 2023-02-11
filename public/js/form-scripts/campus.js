$(function () {

    const addCampusImageRules = {
        errorElement: "div",
        rules: {
            file: {
                required: true,
            },
        },
        messages: {
            file: {
                required: "Image field must not be empty",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        errorPlacement: function (error, element) {
            // Change the location of error labels
            if (element.attr("name") == "file") {
                error.insertAfter("#campus_img_format");
            } else {
                error.insertAfter(element);
            }
        },
    };

    $("#addCampusImageForm").validate(addCampusImageRules); // Validate

    // If Submit Form is Clicked
    $("#addCampusImageForm").submit(function (e) {

        e.preventDefault();

        $("#addCampusImageForm").validate(addCampusImageRules);

        if (!$("#addCampusImageForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        addCampusImage()
    });

    // Function to add event
    function addCampusImage() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // AJAX with Image Uploading
        let myForm = document.getElementById('addCampusImageForm');
        let formData = new FormData(myForm); //use formData for forms with files

        $.ajax({
            type: "POST",
            url: "/campus",
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                //Show Success Message
                Swal.fire(
                    'Added!',
                    response.msg,
                    'success'
                );

                //  Update  UI
                $('#campus_images').html(response.data);

                let filePond = FilePond.find(document.getElementById('file'));
                if (filePond != null) {
                    //this will remove all files
                    filePond.removeFiles();
                }

                document.getElementById("file").value = null;

                $("#addCampusImageForm").trigger('reset'); // Clear the form

            },
            error: function (err) {

                // validation error
                if (err.status == 422) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-right',
                        iconColor: 'red',
                        showConfirmButton: false,
                        timer: 1100,
                        timerProgressBar: true
                    })

                    const errMsg = err.responseJSON.message;

                    Toast.fire({
                        icon: 'error',
                        title: errMsg
                    })
                } else {
                    // Show another error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Something went wrong! Please try again later',
                    })
                }


            }
        });
    }

    async function deleteCampusImage(id) {
        try {
            const response = await axios.delete(`/campus/${id}`);

            //Update  UI
            $('#campus_images').html(response.data.data);

            Swal.fire(
                'Deleted!',
                response.data.msg,
                'success'
            );

        } catch (e) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Something went wrong! Please try again later',
            })
        }
    }

    // Delete Event
    $('body').on('click', '#deleteCampusImg', function () {

        const id = $(this).attr('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                deleteCampusImage(id);

            }
        })

    });

});
