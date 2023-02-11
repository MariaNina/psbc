$(document).ready(function () {
    // Default Header for Request
    axios.defaults.headers.common["X-CSRF-TOKEN"] = $(
        "meta[name='csrf-token']"
    ).attr("content");

});
