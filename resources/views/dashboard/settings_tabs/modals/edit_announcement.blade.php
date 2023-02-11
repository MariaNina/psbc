{{-- ADD MODAL --}}
<div
    class="modal fade announcement_modal"
    id="editAnnouncementModal"
    role="dialog"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="edit_branch_badge" class="badge badge-info"></span>
                    Edit Announcement
                </h5>
                <button
                    class="close"
                    type="button"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAnnouncementForm" role="form" data-toggle="validator" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">
                            Announcement Title
                            ; </label>
                        <input type="text" class="form-control" name="announcement_title" id="announcement_title"
                               placeholder="eg. Foundation Day"
                               value=""/>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-9">
                                <label for="title">Announcement Image</label>
                                <input type="file" class="form-control-file" id="edit_announcement_image"
                                       name="announcement_image"
                                       placeholder="eg. Foundation Day"
                                       value=""/>
                                <small id="edit_announcement_image_format" class="text-muted font-sm">Supported file
                                    format (jpeg, jpg, png, gif)</small>
                            </div>

                            <div class="col-lg-3">
                                <img src="" class="img-fluid" alt="announcement_img" id="announcement_img"/>
                                {{--                                width="100"--}}
                                {{--                                height="100"--}}
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="body">Announcement Content</label>
                        <textarea class="form-control form-control-textarea" name="announcement_body"
                                  id="announcement_body"
                                  placeholder="eg. Specify what event are you posting..." rows="4"></textarea>
                    </div>

                    <button id="btn" type="submit" class="btn btn-info float-right">Update</button>
                </form>

            </div>
        </div>
    </div>
</div>
