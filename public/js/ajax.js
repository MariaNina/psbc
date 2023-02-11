$(document).ready(function () {

    $('#ajaxForm').submit(function(e) {

        e.preventDefault();

        // Do something when submit
        addPeople();
    });


    const addPeople = async () => {

        // This is the form data
        const formData = {
            image: $('#image').val(),
            name: $('#name').val(),
            description: $('#description').val(),
            date: $('#date').val(),
            status: 'Active'
        };

        try {

            const config = {
                headers: {
                    'Content-Type': 'application/json',
                },
            };

            await axios.post('/people', formData, config); // Request from the server

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Added',
                text: 'Your file has been created',
            })


        } catch (e) {

            // If request returns error then show error message
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })

        }
    }

    const updatePeople = async () => {};

});
