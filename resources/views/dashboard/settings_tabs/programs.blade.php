<div class="card shadow mb-4">
    <div class="card-body">
        <form id="programSettingsForm" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- About Content --}}
            <h4>Content</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_pagetitle">Page Title</label>
                        <input type="text" class="form-control" name="program_pagetitle" id="program_pagetitle"
                               placeholder="eg. PROGRAMS AND COURSES" value="{{ $home->program_pagetitle }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_contentitle">Content Title</label>
                        <input type="text" class="form-control" name="program_contentitle" id="program_contentitle"
                               placeholder="eg. Programs Offered..." value="{{ $home->program_contentitle }}">
                    </div>
                </div>
            </div>

            <hr/>
            <button class="btn btn-sm btn-secondary text-white px-3 py-1" type="submit">
                Save Changes
            </button>
        </form>
    </div>
</div>

{{-- Add Icons --}}
<div class="card shadow mb-4">

    <div class="card-body">
        <form id="programPhotosForm" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_name">Program Name</label>
                        <input type="text" class="form-control" name="program_name" id="program_name"
                               placeholder="eg. College of Education, Senior High School..." value="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <div>
                                <label class="form-label" for="program_file">Program Image/Icon</label>
                                <input type="file" class="form-control-file" id="program_file" name="program_file"/>
                                <small id="our_programs_format" class="text-muted font-sm">Supported file format (jpeg,
                                    jpg, png, gif)</small>
                                <br>
                                <small id="our_programs_format" class="text-muted font-sm">Recommended size (64x64)
                                    px.</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="program_description">Program Description</label>
                        <textarea class="form-control form-control-textarea" name="program_description"
                                  id="program_description" placeholder="eg. Description text here..."
                                  rows="3"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-orange btn-sm text-white-50">
                <i class="fas fa-plus text-white-50"></i>
                Add
            </button>

            {{--  VIEW --}}
            <div class="container">
                <div id="programs_photos" class="row my-5">
                    @forelse($program_photos as $program_img)
                        <div class="col-md-4 bg-light">
                            <div class="d-flex justify-content-center mb-3">
                                <img class="circle-wrapper img-relative" id="program_photo_view"
                                     data-id="{{ $program_img->id }}"
                                     data-toggle="modal" data-target="#programDescriptionModal"
                                     src="{{ asset('/storage'.$program_img->file) }}" alt="building-icon">
                            </div>
                            <div class="delete-icon">
                                <a data-id="{{ $program_img->id }}" id="deleteProgramImg" href="#programs_photos">
                                    <i class="fas fa-trash-alt text-white"></i>
                                </a>
                            </div>
                            <div class="text-center text-dark">
                                <p>{{ $program_img->name }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <h5>No Programs, Please add content above</h5>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="container">
                <div class="row my-3">
                    <div class="small">
                        <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a
                                href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Program Description Modal --}}
@include('dashboard.settings_tabs.modals.view_programs')



