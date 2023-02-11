{{-- ADD MODAL --}}
<div
    class="modal fade announcement_modal"
    id="addAnnouncementModal"
    role="dialog"
    aria-hidden="true"
>
    <div class=" modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="badge badge-success">{{ session('user')->branch }}</span>
                    New Announcement
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
                <form id="addAnnouncementForm" role="form" data-toggle="validator" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">
                            Announcement Title
                        </label>
                        <input type="text" class="form-control" name="announcement_title" id="announcement_title"
                               placeholder="eg. Foundation Day"
                               value=""/>
                    </div>

                    <div class="form-group">
                        <label for="title">Announcement Image</label>
                        <input type="file" class="form-control-file" id="add_announcement_image"
                               name="announcement_image"
                               placeholder="eg. Foundation Day"
                               value=""/>
                        <small id="announcement_image_format" class="text-muted font-sm">Supported file format
                            (jpeg,
                            jpg, png, gif)</small>

                    </div>

                    <div class="form-group">
                        <label for="body">Announcement Content</label>
                        <textarea class="form-control form-control-textarea" name="announcement_body"
                                  id="announcement_body"
                                  placeholder="eg. Specify what event are you posting..." rows="4"></textarea>
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>

            </div>
        </div>
    </div>
</div>
