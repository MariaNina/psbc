<div class="row">

    <div class="col-lg-12">

        <div class="card shadow mb-4">
            <div class="card-body">
                {{--    Campus--}}
                <form id="addCampusImageForm" method="POST">
                    @csrf

                    <h3>Campus Images</h3>

                    <div class="form-group">
                        <div class="d-flex">
                            <div>
                                <label class="form-label" for="file">Add Image</label>
                                <input type="file" class="form-control-file " id="file" name="file" required/>
                                <small id="campus_img_format" class="text-muted font-sm">Supported file format (jpeg,
                                    jpg, png, gif)</small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-orange btn-sm my-3 text-white-50">
                            <i class="fas fa-plus text-white-50"></i>
                            Add
                        </button>
                    </div>

                    <div id="campus_images" class="row">
                        @forelse($campus_photos as $photo)
                            <div class="col-md-4 img-relative mb-3">
                                <img class="img-fluid" src="/storage{{ $photo->file }}"
                                     width="w-100"
                                     height="350"
                                     alt="{{ $photo->file }}"/>
                                <div class="delete-icon">
                                    <a data-id="{{ $photo->id }}" id="deleteCampusImg" href="#campus_images">
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12 mb-3">
                                <h5>You don't have any images, please add image above.</h5>
                            </div>
                        @endforelse
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>

