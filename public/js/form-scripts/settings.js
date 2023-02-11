$(function () {
    ClassicEditor.create(document.querySelector("#home_icon_subtitle1"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    }).catch((error) => {
        console.log(error);
    });

    ClassicEditor.create(document.querySelector("#home_icon_subtitle2"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    }).catch((error) => {
        console.log(error);
    });

    ClassicEditor.create(document.querySelector("#home_icon_subtitle3"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    }).catch((error) => {
        console.log(error);
    });

    ClassicEditor.create(
        document.querySelector("#home_announcement_subtitle"),
        {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            mediaEmbed: {
                previewsInData: true,
            },
        }
    ).catch((error) => {
        console.log(error);
    });

    ClassicEditor.create(document.querySelector("#campus_subtitle"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    }).catch((error) => {
        console.log(error);
    });

    ClassicEditor.create(document.querySelector("#offer_subtitle"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    }).catch((error) => {
        console.log(error);
    });

    // Home Settings
    $("#homeSettingsForm").submit(function (e) {
        e.preventDefault();

        editHomeSettings();
    });

    // Edit home Settings
    function editHomeSettings() {
        let myForm = document.getElementById("homeSettingsForm");
        let formData = new FormData(myForm); //use formData for forms with files
        formData.append("_method", "PUT");

        $.ajax({
            url: `settings/${1}`,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                //Show Success Message
                Swal.fire("Updated!", response.msg, "success");

                setTimeout(function () {
                    window.location.href = "/settings";
                }, 1500);
            },
            error: function (err) {
                // validation error
                if (err.status == 422) {
                    let error = err.responseJSON.errors;

                    let errorsText = "";

                    if (error.logo) {
                        errorsText += `<div>${error.logo}</div>`;
                    }

                    if (error.email) {
                        errorsText += `<div>${error.email}</div>`;
                    }

                    if (error.facebook) {
                        errorsText += `<div>${error.facebook}</div>`;
                    }

                    if (error.carousel_img1) {
                        errorsText += `<div>Slider image 1 must be an image</div>`;
                    }

                    if (error.carousel_img2) {
                        errorsText += `<div>Slider image 2 must be an image</div>`;
                    }

                    if (error.carousel_img3) {
                        errorsText += `<div>Slider image 3 must be an image</div>`;
                    }
                    if (error.carousel_link1) {
                        errorsText += `<div>Slider Link 1 must be a URL</div>`;
                    }

                    if (error.carousel_link2) {
                        errorsText += `<div>Slider Link 2 must be a URL</div>`;
                    }

                    if (error.home_announcement_link) {
                        errorsText += `<div>Announcement link must be a URL</div>`;
                    }

                    if (error.home_announcement_img_background) {
                        errorsText += `<div>Announcement background must be an image</div>`;
                    }

                    if (error.home_announcement_img) {
                        errorsText += `<div>Announcement featured image must be an image</div>`;
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        html: errorsText,
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

    // ========== ABOUT SETTINGS ============ //
    let aboutEditor;
    ClassicEditor.create(document.querySelector("#about_content"), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        mediaEmbed: {
            previewsInData: true,
        },
    })
        .then((editor) => {
            aboutEditor = editor;
        })
        .catch((error) => {
            console.log(error);
        });

    // Home Settings
    $("#aboutSettingsForm").submit(function (e) {
        e.preventDefault();

        editAboutSettings();
    });

    // Edit home Settings
    function editAboutSettings() {
        let myForm = document.getElementById("aboutSettingsForm");
        let formData = new FormData(myForm); //use formData for forms with files
        formData.append("_method", "PUT");

        $.ajax({
            url: `about/${1}`,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                //Show Success Message
                Swal.fire("Updated!", response.msg, "success");

                setTimeout(function () {
                    window.location.href = "/settings";
                }, 1500);
            },
            error: function (err) {
                // validation error
                if (err.status == 422) {
                    let error = err.responseJSON.errors;

                    let errorsText = "";

                    if (error.about_img) {
                        errorsText += `<div>About image must be an image</div>`;
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        html: errorsText,
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
});
