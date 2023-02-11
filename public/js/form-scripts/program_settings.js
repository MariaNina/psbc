$(document).ready(function () {

    let descriptionEditor;

    ClassicEditor.create(document.querySelector("#program_description"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    })
        .then(editor => {
            descriptionEditor = editor;
        })
        .catch((error) => {
            console.log(error);
        });

    let form = $('#programPhotosForm');

    // ============= ADD EVENT ==================== //

    const addProgramPhotoRules = {
        errorElement: "div",
        rules: {
            program_name: "required",
            program_description: "required",
        },
        messages: {
            program_name: {
                required: "Program name is required",
            },
            program_file: {
                required: "Program icon is required",
            },
            program_description: {
                required: "Program description is required",
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        errorPlacement: function (error, element) {
            // Change the location of error labels
            if (element.attr("name") == "program_file") {
                error.insertAfter("#our_programs_format");
            } else {
                error.insertAfter(element);
            }
        },
        ignore: [],
    };

    form.validate(addProgramPhotoRules); // Validate

    // If Submit Form is Clicked
    form.submit(function (e) {

        e.preventDefault();

        form.validate(addProgramPhotoRules);

        if (!form.valid()) {
            return false;
        }

        // Do something here if validation is passed.
        addProgramPhotos()
    });

    // Function to add event
    function addProgramPhotos() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // AJAX with Image Uploading
        let myForm = document.getElementById('programPhotosForm');
        let formData = new FormData(myForm); //use formData for forms with files

        $.ajax({
            type: "POST",
            url: "/our-programs",
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

                $('#programs_photos').html(response.data);

                $('#program_name').val('');

                // Empty the CK-EDITOR textarea
                descriptionEditor.setData('');

                // Reset image input
                const imgId = document.getElementById('program_file')
                //Show Success Message
                let filePond = FilePond.find(imgId);
                if (filePond != null) {
                    //this will remove all files
                    filePond.removeFiles();
                }

                imgId.value = null;

                $('#programSettingsForm').trigger('reset');

            },
            error: function (err) {

                console.log(err);

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

    // =============  END ADD ===================== //


    // ================== UPDATE PAGE SETTINGS ================ //
    //programSettingsForm

    const updateProgramPageRule = {
        errorElement: "div",
        rules: {
            program_pagetitle: {
                required: false
            },
            program_contentitle: {
                required: false
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#programSettingsForm").validate(updateProgramPageRule); // Validate

    // If Submit Form is Clicked
    $("#programSettingsForm").submit(function (e) {

        e.preventDefault();

        $("#programSettingsForm").validate(updateProgramPageRule);

        if (!$("#programSettingsForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        updateProgramPage()
    });

    // Function to add event
    function updateProgramPage() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // AJAX with Image Uploading
        let myForm = document.getElementById('programSettingsForm');
        let formData = new FormData(myForm); //use formData for forms with files
        formData.append('_method', 'PUT');

        $.ajax({
            type: "POST",
            url: "/our-programs/1",
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                //Show Success Message
                Swal.fire(
                    'Updated!',
                    response.msg,
                    'success'
                );

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

    // ================ DELETE PROGRAM IMAGE ================= //

    async function deleteProgramImage(id) {
        try {
            const response = await axios.delete(`/our-programs/${id}`);

            //Update  UI
            $('#programs_photos').html(response.data.data);

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
    $('body').on('click', '#deleteProgramImg', function () {

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

                deleteProgramImage(id);

            }
        })

    });


    // Click image
    $('html').on('click', '#program_photo_view', function () {

        const id = $(this).attr('data-id');

        $.ajax({
            url: `/our-programs/${id}`,
            type: "GET",
            success: function (response) {

                $('#modal-program-title').text(response.name);
                $('#modal-program-description').html(response.description);

                let image = response.file;
                // Check if image is website url and not folder
                if (image.includes('https://')) {
                    image = response.file;
                } else {
                    // If folder, then add the storage folder path
                    image = `/storage${response.file}`;
                }

                $("#modal-program-img").attr("src", image);  // Append Image

            },
            error: function (err) {
                // Show another error message
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            },
        });

    });

});
