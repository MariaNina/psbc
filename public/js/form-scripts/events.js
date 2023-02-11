$(document).ready(function () {
    
    let addEventFormBody;

    ClassicEditor.create(document.querySelector("#addEventForm #body"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    })
        .then(editor => {
            addEventFormBody = editor;
        })
        .catch((error) => {
            console.log(error);
        });

    let editEventFormBody;

    ClassicEditor.create(document.querySelector("#editEventForm #body"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    })
        .then((editor) => {
            editEventFormBody = editor;
        })
        .catch((error) => {
            console.error(error);
        });

    // ============= ADD EVENT ==================== //

    const addEventRules = {
        errorElement: "div",
        rules: {
            title: "required",
            upcoming_at: "required",
            body: {
                required: true,
                minlength: 30,
                maxlength: 1000
            }
        },
        messages: {
            title: {
                required: "Title is required",
            },
            upcoming_at: {
                required: "Upcoming date is required",
            },
            body: {
                required: "Content is required",
            },
            image: {
                required: "Image is required"
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
            if (element.attr("name") == "image") {
                error.insertAfter("#event_image_format");
            } else {
                error.insertAfter(element);
            }
        },
        //ignore: ":hidden, [contenteditable='true']:not([name]), .cke_editable"
        ignore: []
    };

    $("#addEventForm").validate(addEventRules); // Validate

    // If Submit Form is Clicked
    $("#addEventForm").submit(function (e) {
        e.preventDefault();

        $("#addEventForm").validate(addEventRules);

        if (!$("#addEventForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        addEvent();
    });

    // Function to add event
    function addEvent() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        // AJAX with Image Uploading
        let myForm = document.getElementById("addEventForm");
        let formData = new FormData(myForm); //use formData for forms with files

        $.ajax({
            type: "POST",
            url: "/events",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                addEventFormBody.setData(''); // Clear wysiwyg form
                // Reset image input
                const imgId = document.querySelector('#event_file')
                //Show Success Message
                let filePond = FilePond.find(imgId);
                if (filePond != null) {
                    //this will remove all files
                    filePond.removeFiles();
                }

                //Show Success Message
                Swal.fire("Added!", response.msg, "success");

                $("#addEventForm").trigger("reset"); // Clear the form
                $("#addEventModal").modal("hide"); // Hide the modal
                $("#filtertable").DataTable().ajax.reload();
            },
            error: function (err) {
                // validation error
                if (err.status == 422) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-right",
                        iconColor: "red",
                        showConfirmButton: false,
                        timer: 1100,
                        timerProgressBar: true,
                    });

                    const errMsg = err.responseJSON.message;

                    Toast.fire({
                        icon: "error",
                        title: errMsg,
                    });
                } else {
                    // Show another error message
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: "Something went wrong! Please try again later",
                    });
                }
            },
        });
    }

    // =============  END ADD ===================== //

    // ===================== EDIT EVENT ================ //

    let id = null;

    // Get the data ang put on the modal
    $("body").on("click", "#editEventModalBtn", function () {
        id = $(this).attr("data-id");

        $.ajax({
            url: `/events/${id}/edit `,
            type: "GET",
            success: function (response) {
                editEventFormBody.setData(response.body);

                $("#editEventForm #title").val(response.title);
                $("#editEventForm #upcoming_at").val(response.date);
                $("#editEventModal #edit_branch_badge").html(response.branch.branch_name);

                $("#editEventForm #link").val(response.link);

                let image = response.image;

                // Check if image is website url and not folder
                if (image.includes('https://')) {
                    image = response.image;
                } else {
                    // If folder, then add the storage folder path
                    image = `/storage${response.image}`;
                }

                $("#editEventForm #event_image").attr("src", image);
            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            },
        });
    });

    // For Updating data
    // 1. validation
    const editEventRules = {
        errorElement: "div",
        rules: {
            title: "required",
            upcoming_at: "required",
            body: {
                required: true,
                minlength: 30,
                maxlength: 1000
            }
        },
        messages: {
            title: {
                required: "Title is required",
            },
            upcoming_at: {
                required: "Upcoming date is required",
            },
            body: {
                required: "Content is required",
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
            if (element.attr("name") == "image") {
                error.insertAfter("#edit_event_image_format");
            } else {
                error.insertAfter(element);
            }
        },
        //ignore: ":hidden, [contenteditable='true']:not([name]), .cke_editable"
        ignore: []
    };

    $("#editEventForm").validate(editEventRules); // Validate

    // 2. If Submit Form is Clicked
    $("#editEventForm").submit(function (e) {
        e.preventDefault();

        $("#editEventForm").validate(editEventRules);

        if (!$("#editEventForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        editEvent();
    });

    // 3. update the event
    function editEvent() {
        let myForm = document.getElementById("editEventForm");
        let formData = new FormData(myForm); //use formData for forms with files
        formData.append("_method", "PUT");

        $.ajax({
            url: `events/${id}`,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {

                // Reset image input
                const imgId = document.querySelector('#editEventForm #image')
                //Show Success Message
                let filePond = FilePond.find(imgId);
                if (filePond != null) {
                    //this will remove all files
                    filePond.removeFiles();
                }

                //Show Success Message
                Swal.fire("Updated!", response.msg, "success");

                $("#editEventForm").trigger("reset"); // Clear the form
                $("#editEventModal").modal("hide"); // Hide the modal
                $("#filtertable").DataTable().ajax.reload();
            },
            error: function (err) {
                // validation error
                if (err.status == 422) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-right",
                        iconColor: "red",
                        showConfirmButton: false,
                        timer: 1100,
                        timerProgressBar: true,
                    });

                    const errMsg = err.responseJSON.message;

                    Toast.fire({
                        icon: "error",
                        title: errMsg,
                    });
                } else {
                    // Show another error message
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: "Something went wrong! Please try again later",
                    });
                }
            },
        });
    }

    // ===================== END EDIT EVENT ================ //

    async function deleteEvent(id) {
        try {
            const response = await axios.delete(`/events/${id}`);
            Swal.fire("Deleted!", response.data.msg, "success");
            $("#filtertable").DataTable().ajax.reload();
        } catch (e) {
            Swal.fire({
                icon: "error",
                title: "Failed",
                text: "Something went wrong! Please try again later",
            });
        }
    }

    // Delete Event
    $("body").on("click", "#editDeleteEventModalBtn", function () {
        const id = $(this).attr("data-id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                deleteEvent(id);
            }
        });
    });
});
