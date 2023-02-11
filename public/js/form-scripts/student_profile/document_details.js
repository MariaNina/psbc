$(document).ready(function () {
    // If Submit Form is Clicked
    $("#document_details_form").submit(function (e) {
        e.preventDefault();

        // Do something here if validation is passed.
        documentDetailsFormSubmit();
    });

    function documentDetailsFormSubmit() {
        let myForm = document.getElementById('document_details_form');
        let formData = new FormData(myForm); //use formData for forms with files
            formData.append('_method', 'PUT'); //need to spoof PUT method here because formData and PUT are having an error.. Use POST as method then add this line successfully update the data
        $.ajax({
            type: "POST",
            url: `/profile/document_details`,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                Swal.fire("Updated!", response.msg, "success");
            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            }
        });
    }
});
