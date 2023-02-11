$(document).ready(function () {
    let addAnnouncementFormBody;

    ClassicEditor.create(document.querySelector("#addAnnouncementForm #announcement_body"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    })
        .then(editor => {
            addAnnouncementFormBody = editor;
        })
        .catch((error) => {
            console.log(error);
        });

    let editAnnouncementFormBody;

    ClassicEditor.create(document.querySelector("#editAnnouncementForm #announcement_body"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    })
        .then((editor) => {
            editAnnouncementFormBody = editor;
        })
        .catch((error) => {
            console.error(error);
        });

    // ============= ADD ANNOUNCEMENT ==================== //

    const addAnnouncementRules = {
        errorElement: "div",
        rules: {
            announcement_title: "required",
            announcement_body: {
                required: true,
                minlength: 30,
                maxlength: 1000
            },
        },
        messages: {
            announcement_title: {
                required: "Title is required",
            },
            announcement_image: {
                required: "Image is required"
            },
            announcement_body: {
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
            if (element.attr("name") == "announcement_image") {
                error.insertAfter("#announcement_image_format");
            } else {
                error.insertAfter(element);
            }
        },
        //ignore: ":hidden, [contenteditable='true']:not([name]), .cke_editable"
        //ignore: ['.ck', ':hidden', '.cke__editable', 'cke_editable'],
        ignore: []

    };

    $("#addAnnouncementForm").validate(addAnnouncementRules); // Validate

    // If Submit Form is Clicked
    $("#addAnnouncementForm").submit(function (e) {
        e.preventDefault();

        $("#addAnnouncementForm").validate(addAnnouncementRules);

        if (!$("#addAnnouncementForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        addAnnouncement();
    });

    // Function to add event
    function addAnnouncement() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        // AJAX with Image Uploading
        let myForm = document.getElementById("addAnnouncementForm");
        let formData = new FormData(myForm); //use formData for forms with files

        $.ajax({
            type: "POST",
            url: "/announcements",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                addAnnouncementFormBody.setData('');

                // Reset image input
                const imgId = document.querySelector('#add_announcement_image')
                //Show Success Message
                let filePond = FilePond.find(imgId);
                if (filePond != null) {
                    //this will remove all files
                    filePond.removeFiles();
                }


                imgId.value = null;

                //Show Success Message
                Swal.fire("Added!", response.msg, "success");

                $("#addAnnouncementForm").trigger("reset"); // Clear the form
                $("#addAnnouncementModal").modal("hide"); // Hide the modal
                $("#announcementTable").DataTable().ajax.reload();
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

    // ===================== EDIT ANNOUNCEMENT ================ //

    let id = null;

    // Get the data ang put on the modal
    $("body").on("click", "#editAnnouncementModalBtn", function () {
        id = $(this).attr("data-id");

        $.ajax({
            url: `/announcements/${id}/edit `,
            type: "GET",
            success: function (response) {

                editAnnouncementFormBody.setData(response.announcement_body); // set the data on the ckeditor

                $("#editAnnouncementModal #edit_branch_badge").html(response.branch.branch_name);
                $("#editAnnouncementForm #announcement_title").val(response.announcement_title);

                let image = response.announcement_image;

                // Check if image is website url and not folder
                if (image.includes('https://')) {
                    image = response.announcement_image;
                } else {
                    // If folder, then add the storage folder path
                    image = `/storage${response.announcement_image}`;
                }

                $("#editAnnouncementForm #announcement_img").attr("src", image);
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
    const editAnnouncementRules = {
        errorElement: "div",
        rules: {
            announcement_title: "required",
            announcement_body: {
                required: true,
                minlength: 30,
                maxlength: 1000
            },
        },
        messages: {
            announcement_title: {
                required: "Title is required",
            },
            announcement_body: {
                required: "Content is required",
            },
            announcement_image: {
                required: "Image is required"
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
            if (element.attr("name") == "announcement_image") {
                error.insertAfter("#edit_announcement_image_format");
            } else {
                error.insertAfter(element);
            }
        },
        ignore: []
    };

    $("#editAnnouncementForm").validate(editAnnouncementRules); // Validate

    // 2. If Submit Form is Clicked
    $("#editAnnouncementForm").submit(function (e) {
        e.preventDefault();

        $("#editAnnouncementForm").validate(editAnnouncementRules);

        if (!$("#editAnnouncementForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        editEvent();
    });

    // 3. update the event
    function editEvent() {
        let myForm = document.getElementById("editAnnouncementForm");
        let formData = new FormData(myForm); //use formData for forms with files
        formData.append("_method", "PUT");

        $.ajax({
            url: `announcements/${id}`,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {

                // Reset image input
                const imgId = document.querySelector('#editAnnouncementForm #edit_announcement_image')
                //Show Success Message
                let filePond = FilePond.find(imgId);
                if (filePond != null) {
                    //this will remove all files
                    filePond.removeFiles();
                }

                imgId.value = null;

                $("#editAnnouncementModal").modal("hide"); // Hide the modal

                $("#editAnnouncementForm").trigger("reset"); // Clear the form

                $("#announcementTable").DataTable().ajax.reload();

                Swal.fire("Updated!", response.msg, "success");

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
            const response = await axios.delete(`/announcements/${id}`);
            Swal.fire("Deleted!", response.data.msg, "success");
            $("#announcementTable").DataTable().ajax.reload();
        } catch (e) {
            Swal.fire({
                icon: "error",
                title: "Failed",
                text: "Something went wrong! Please try again later",
            });
        }
    }

    // Delete Event
    $("body").on("click", "#editDeleteAnnouncementModalBtn", function () {
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
