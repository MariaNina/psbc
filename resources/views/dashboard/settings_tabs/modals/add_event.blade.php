{{-- ADD MODAL --}}
<div
    class="modal fade event_modal"
    id="addEventModal"
    role="dialog"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="badge badge-success">{{ session('user')->branch }}</span>
                    New Event
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
                <form id="addEventForm" role="form" data-toggle="validator" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Event Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="eg. Foundation Day"
                               value="" />
                    </div>

                    <div class="form-group">
                        <label for="upcoming_at">Upcoming At</label>
                        <input type="date" class="form-control" name="upcoming_at" id="upcoming_at"
                               placeholder="eg. External URL for your event..." value=""/>
                    </div>

                    <div class="form-group">
                        <label for="title">Event Image</label>
                        <input type="file" class="form-control-file" id="event_file" name="image" placeholder="eg. Foundation Day"
                               value=""/>
                        <small id="event_image_format" class="text-muted font-sm">Supported file format (jpeg, jpg, png, gif)</small>

                    </div>

                    <div class="form-group">
                        <label for="body">Event Content</label>
                        <textarea class="form-control form-control-textarea" name="body" id="body"
                                  placeholder="eg. Specify what event are you posting..." rows="4"></textarea>
                    </div>

                    <button id="btn" type="submit" class="btn btn-success float-right">Create</button>
                </form>

            </div>
        </div>
    </div>
</div>
