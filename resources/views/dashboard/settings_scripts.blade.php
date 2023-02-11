{{--  For Tabs  --}}
<script>
    $(document).ready(function () {
        // For Tabs
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });

        // Branch select 2
        $('#addAnnouncementForm #branch_id').select2({
            theme: "bootstrap"
        });

    });
</script>

{{--CKEDITOR SHOW EMBED MEDIA/YOUTUBE/VIDEO--}}
<script>
    document.querySelectorAll('oembed[url]').forEach(element => {
        // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
        // to discover the media.
        const anchor = document.createElement('a');

        anchor.setAttribute('href', element.getAttribute('url'));
        anchor.className = 'embedly-card';

        element.appendChild(anchor);
    });
</script>

{{--Filepond IMPLEMENTATION--}}
<script>

    FilePond.registerPlugin(FilePondPluginImageValidateSize);
    FilePond.registerPlugin(FilePondPluginFileValidateType);

    // Get a reference to the file input element
    let pond;

    // get a collection of elements with class filepond
    const inputElements = document.querySelectorAll('#homeSettingsForm .form-control-file');

    // loop over input elements
    Array.from(inputElements).forEach(inputElement => {

        // create a FilePond instance at the input element location
        pond = FilePond.create(inputElement);

        // Default Options
        FilePond.setOptions({
            acceptedFileTypes: ['image/*'],
            onaddfilestart: (file) => {
                isLoadingCheck(pond, '#homeSettingsForm');
            },
            onprocessfile: (file) => {
                isLoadingCheck(pond, '#homeSettingsForm');
            },
            server: {
                url: '/upload_file',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': "XMLHttpRequest"
                }
            }
        });

    })

    // About Images
    const aboutImg = document.querySelector('#aboutSettingsForm input#about_img');

    const aboutImgPond = FilePond.create(aboutImg, {
        acceptedFileTypes: ['image/*'],
        onaddfilestart: (file) => {
            isLoadingCheck(aboutImgPond, '#aboutSettingsForm');
        },
        onprocessfile: (file) => {
            isLoadingCheck(aboutImgPond, '#aboutSettingsForm');
        },
        server: {
            url: '/upload_file',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': "XMLHttpRequest"
            }
        }
    });

    // Campus Images
    const campusImg = document.querySelector('#addCampusImageForm input#file');

    const campusPond = FilePond.create(campusImg, {
        required: true,
        acceptedFileTypes: ['image/*'],
        onaddfilestart: (file) => {
            isLoadingCheck(campusPond, '#addCampusImageForm');
        },
        onprocessfile: (file) => {
            isLoadingCheck(campusPond, '#addCampusImageForm');
        },
        server: {
            url: '/upload_file/campus_img',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': "XMLHttpRequest"
            }
        }
    });

    // Campus Images
    const programImg = document.querySelector('#programPhotosForm input#program_file');

    const programPond = FilePond.create(programImg, {
        required: true,
        acceptedFileTypes: ['image/*'],
        onaddfilestart: (file) => {
            isLoadingCheck(programPond, '#programPhotosForm');
        },
        onprocessfile: (file) => {
            isLoadingCheck(programPond, '#programPhotosForm');
        },
        server: {
            url: '/upload_file/programs_img',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': "XMLHttpRequest"
            }
        }
    });

    // Announcement Images
    const addAnnouncementImg = document.querySelector('#addAnnouncementModal input[type="file"]');

    const addAnnouncementPond = FilePond.create(addAnnouncementImg, {
        required: true,
        acceptedFileTypes: ['image/*'],
        onaddfilestart: (file) => {
            isLoadingCheck(addAnnouncementPond, '#addAnnouncementModal');
        },
        onprocessfile: (file) => {
            isLoadingCheck(addAnnouncementPond, '#addAnnouncementModal');
        },
        server: {
            url: '/upload_file/announcements_img',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': "XMLHttpRequest"
            }
        }
    });

    const editAnnouncementImg = document.querySelector('#editAnnouncementModal input[type="file"]');

    const editAnnouncementPond = FilePond.create(editAnnouncementImg, {
        required: false,
        acceptedFileTypes: ['image/*'],
        onaddfilestart: (file) => {
            isLoadingCheck(editAnnouncementPond, '#editAnnouncementModal');
        },
        onprocessfile: (file) => {
            isLoadingCheck(editAnnouncementPond, '#editAnnouncementModal');
        },
        server: {
            url: '/upload_file/announcements_img',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': "XMLHttpRequest"
            }
        }
    });

    // Events Images
    const addEventsImg = document.querySelector('#addEventModal input[type="file"]');

    const addEventsPond = FilePond.create(addEventsImg, {
        required: true,
        acceptedFileTypes: ['image/*'],
        onaddfilestart: (file) => {
            isLoadingCheck(addEventsPond, '#addEventModal');
        },
        onprocessfile: (file) => {
            isLoadingCheck(addEventsPond, '#addEventModal');
        },
        server: {
            url: '/upload_file/events_img',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': "XMLHttpRequest"
            }
        }
    });

    const editEventsImg = document.querySelector('#editEventModal input[type="file"]');

    const editEventsPond = FilePond.create(editEventsImg, {
        required: false,
        acceptedFileTypes: ['image/*'],
        onaddfilestart: (file) => {
            isLoadingCheck(editEventsPond, '#editEventModal');
        },
        onprocessfile: (file) => {
            isLoadingCheck(editEventsPond, '#editEventModal');
        },
        server: {
            url: '/upload_file/events_img',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': "XMLHttpRequest"
            }
        }
    });

    // Check if file is uploading
    function isLoadingCheck(pond = pond, formId) {

        let button = $(formId + ' button[type="submit"]');

        var isLoading = pond.getFiles().filter(x => x.status !== 5).length !== 0;
        if (isLoading) {
            button.attr("disabled", "disabled");
        } else {
            button.removeAttr("disabled");
        }
    }

</script>


<script src="{{ asset('js/form-scripts/events.js') }}"></script>
<script src="{{ asset('js/form-scripts/announcement.js') }}"></script>

<script src="{{ asset('js/form-scripts/program_settings.js') }}"></script>
<script src="{{ asset('js/form-scripts/settings.js') }}"></script>
<script src="{{ asset('js/form-scripts/campus.js') }}"></script>
<script src="{{ asset('js/form-scripts/maintenance.js') }}"></script>

<script src="{{ asset('js/datatable-scripts/events.js') }}"></script>
<script src="{{ asset('js/datatable-scripts/announcement.js') }}"></script>
