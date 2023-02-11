<div class="card shadow mb-4">
    <div class="card-body">
        {{--    Campus--}}
        <form id="homeSettingsForm" action="{{ route('settings.update', $home->id) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{--    Logo Link--}}
            <h4>Header</h4>
            <div class="form-group">
                <div class="d-flex">
                    <div class="pr-3">
                        <label class="form-label" for="logo">Logo</label>
                        <input type="file" class="form-control-file" id="logo" name="logo" alt="logo"/>
                        <small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
                    </div>
                    <div>
                        <img src="{{ $home->logo() }}" alt="logo" width="100" height="100">
                    </div>

                </div>
            </div>

            {{--    Preheader --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contact_no">Contact No.</label>
                        <input type="text" class="form-control" name="contact_no" id="contact_no"
                               placeholder="eg. (049) 557-0184" value="{{ $home->contact_no }}"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                               placeholder="eg. yourcompany@email.com" value="{{ $home->email }}"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="facebook">Facebook Url</label>
                        <input type="text" class="form-control" name="facebook" id="facebook"
                               placeholder="eg. www.facebook.com/your_organization" value="{{ $home->facebook }}"/>
                    </div>
                </div>
            </div>

            <h4>Slider Images</h4>
            {{--    Carousel Titles--}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="carousel_title">Slider Title</label>
                        <input type="text" class="form-control" name="carousel_title" id="carousel_title"
                               placeholder="eg. Your Organization Name..." value="{{ $home->carousel_title }}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="carousel_subtitle">Slider Subtitle</label>
                        <input type="text" class="form-control" name="carousel_subtitle" id="carousel_subtitle"
                               placeholder="eg. Additional subtitle for your organization..."
                               value="{{ $home->carousel_subtitle }}">
                    </div>
                </div>
            </div>

            {{--    Carousel Images--}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="pr-3">
                                <label class="form-label" for="carousel_img1">Slider First Image</label>
                                <input type="file" class="form-control-file" id="carousel_img1" name="carousel_img1"/>
                                <small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
                            </div>
                            <div>
                                <img src="{{ $home->sliderOne() }}" alt="slider-img-one" width="100"
                                     height="100">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="pr-3">
                                <label class="form-label" for="carousel_img2">Slider Second Image</label>
                                <input type="file" class="form-control-file" id="carousel_img2" name="carousel_img2"/>
                                <small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
                            </div>
                            <div>
                                <img src="{{ $home->sliderTwo() }}" alt="slider-img-2" width="100"
                                     height="100">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="pr-3">
                                <label class="form-label" for="carousel_img3">Slider Third Image</label>
                                <input type="file" class="form-control-file" id="carousel_img3" name="carousel_img3"/>
                                <small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
                            </div>
                            <div>
                                <img src="{{ $home->sliderThree() }}" alt="slider-img-3" width="100"
                                     height="100">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <h4>Slider Links</h4>

            {{--    Carousel Links--}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="carousel_link1">Enrollment Link</label>
                        <input type="text" class="form-control" name="carousel_link1" id="carousel_link1"
                               placeholder="eg. Link or URL for your enrollment..." value="{{ $home->carousel_link1 }}">
                        <div class="invalid-feedback">This field must be a valid URL.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="carousel_link2">LMS Link</label>
                        <input type="text" class="form-control" name="carousel_link2" id="carousel_link2"
                               placeholder="eg. Link or URL for second button..." value="{{ $home->carousel_link2 }}">
                        <div class="invalid-feedback">This field must be a valid URL.</div>

                    </div>
                </div>
            </div>

            <h4>Three column icons</h4>
            {{--    3 Icon Column--}}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="home_icon_title1">Home Icon Title 1</label>
                        <input type="text" class="form-control" name="home_icon_title1" id="home_icon_title1"
                               placeholder="eg. Learn with us" value="{{ $home->home_icon_title1 }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="home_icon_subtitle1">Home Icon Subtitle 1</label>
                        <textarea class="form-control form-control-textarea" name="home_icon_subtitle1"
                                  id="home_icon_subtitle1" placeholder="eg. Additional text here..."
                                  rows="3">{!! $home->home_icon_subtitle1 !!}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="home_icon_title2">Home Icon Title 2</label>
                        <input type="text" class="form-control" name="home_icon_title2" id="home_icon_title2"
                               placeholder="eg. Enroll now..." value="{{ $home->home_icon_title2 }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="home_icon_subtitle2">Home Icon Subtitle 2</label>
                        <textarea class="form-control form-control-textarea" name="home_icon_subtitle2"
                                  id="home_icon_subtitle2" placeholder="eg. Additional text here..."
                                  rows="3">{!! $home->home_icon_subtitle2 !!}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="home_icon_title3">Home Icon Title 3</label>
                        <input type="text" class="form-control" name="home_icon_title3" id="home_icon_title3"
                               placeholder="eg. Entrust your future..." value="{{ $home->home_icon_title3 }}">
                    </div>

                    <div class="form-group">
                        <label for="home_icon_subtitle3">Home Icon Subtitle 3</label>
                        <textarea class="form-control form-control-textarea" name="home_icon_subtitle3"
                                  id="home_icon_subtitle3" placeholder="eg. Additional text here..."
                                  rows="3">{!! $home->home_icon_subtitle3 !!}</textarea>
                    </div>

                </div>
            </div>

            {{-- Announcement --}}
            <h4>Announcement</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="pr-3">
                                <label class="form-label" for="home_announcement_img_background">Announcement
                                    Background</label>
                                <input type="file" class="form-control-file" id="home_announcement_img_background"
                                       name="home_announcement_img_background"/>
                                <small class="text-muted font-sm">Supported file format (jpeg, jpg, png,
                                    gif)</small><br>
                                <small class="text-muted font-sm">(Recommended image is dark background)</small>

                            </div>
                            <div>
                                <img src="{{ $home->announcementBackground() }}"
                                     alt="announcement-img_bg" width="100" height="100">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h4>Campus</h4>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="form-group mb-3">
                        <label for="campus_title">Campus Title</label>
                        <input type="text" class="form-control" name="campus_title" id="campus_title"
                               placeholder="eg. Explore Our Campus" value="{{ $home->campus_title }}">
                        <small class="text-muted"><i>If you want to add images, please refer to the campus tab above</i></small>

                    </div>


                    <div class="form-group">
                        <label for="campus_subtitle">Campus Subtitle</label>
                        <textarea class="form-control form-control-textarea" name="campus_subtitle" id="campus_subtitle"
                                  placeholder="eg. Support content here..."
                                  rows="3">{!! $home->campus_subtitle !!}</textarea>
                    </div>

                </div>
            </div>

            <h4>Offers</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="offer_title">Offer Title</label>
                        <input type="text" class="form-control" name="offer_title" id="offer_title"
                               placeholder="eg. Offer title here..." value="{{ $home->offer_title }}">
                    </div>

                    <div class="form-group">
                        <label for="offer_subtitle">Offer Subtitle</label>
                        <textarea class="form-control form-control-textarea" name="offer_subtitle" id="offer_subtitle"
                                  placeholder="eg. Support your offers here..."
                                  rows="3">{!! $home->offer_subtitle !!}</textarea>
                    </div>

                    <div class="form-group">
                        <div class="d-flex">
                            <div class="pr-3">
                                <label class="form-label" for="offer_img">Offer Image</label>
                                <input type="file" class="form-control-file" id="offer_img"
                                       name="offer_img"/>
                                <small class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>
                            </div>
                            <div>
                                <img src="{{ $home->offerImage() }}" alt="announcement-img" width="100"
                                     height="100">
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="offer_list">Offer List</label>
                        <input type="text" class="form-control" name="offer_list" id="offer_list"
                               placeholder="eg. Offer title here..." value="{{ $home->offer_list }}"/>

                        <small class="text-muted font-sm">Please seperate each text by comma (eg. Example1, Example2,
                            Example3 ...)</small>

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
