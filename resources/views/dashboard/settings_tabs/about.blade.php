<div class="card shadow mb-4">
    <div class="card-body">
        <form id="aboutSettingsForm" action="{{ route('about.update', $about->id) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Page --}}
            <h4>Page</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="page_title">Page Title</label>
                        <input type="text" class="form-control" name="page_title" id="page_title"
                               placeholder="eg. About Us" value="{{ $about->page_title }}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="page_subtitle">Page Subtitle</label>
                        <input type="text" class="form-control" name="page_subtitle" id="page_subtitle" placeholder="eg. Get to know us..."
                               value="{{ $about->page_subtitle }}"/>
                    </div>
                </div>
            </div>

            {{-- About Content --}}
            <h4>Content</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="about_title">About Title</label>
                        <input type="text" class="form-control" name="about_title" id="about_title"
                               placeholder="eg. Who We Are?" value="{{ $about->about_title }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <div>
                                <label class="form-label" for="about_img">About Image</label>
                                <input type="file" class="form-control-file" id="about_img" name="about_img"/>
                                <small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
                            </div>
                            <div>
                                <img src="{{ $about->aboutImg() }}" alt="about_image" width="100"
                                     height="100">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="about_content">About Body</label>
                        <textarea class="form-control form-control-textarea" name="about_content" id="about_content"
                                  placeholder="eg. Explain your organization here..."
                                  rows="4">{!! $about->about_content !!}</textarea>
                    </div>
                </div>
            </div>

            {{--  Vision And Mission  --}}
            <h4>Vision And Mission</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="vision">Vision</label>
                        <textarea class="form-control form-control-textarea" name="vision" id="vision"
                                  placeholder="eg. Vision of your company/organization..."
                                  rows="7">{{ $about->vision }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mission">Mission</label>
                        <textarea class="form-control form-control-textarea" name="mission"
                                  placeholder="eg. Mission of your company/organization..." id="mission"
                                  rows="7">{{ $about->mission }}</textarea>
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
