<form id="document_details_form" method="POST">

    @csrf
    @method('PUT')

    @if($has_documents > 0)

        @foreach ($user->student->documents as $item)
    
        <div class="col-md-6 col-sm-12 form-group">
            <label for="last_name">{{ $item->documentType->document_name }}<sup style="color:red">(jpg, jpeg, png, pdf)</sup></label>
            <input onchange="validateFile(this)" type="file" class="form-control" accept="image/jpeg,image/png,application/pdf,image/x-eps" name="document_{{ $item->documentType->id }}"
                placeholder="eg. Rizal" value="{{ $item->documentType->id }}"/>
        </div>
        
        @endforeach
    @endif

    @if(!empty($user->student->oldestEnrollment->student_type) && $user->student->oldestEnrollment->student_type == "Old" && $documents != '')

        @foreach ($documents as $item)

        <div class="col-md-6 col-sm-12 form-group">
            <label for="last_name">{{ $item->document_name }}<sup style="color:red">(jpg, jpeg, png, pdf)</sup></label>
            <input onchange="validateFile(this)" type="file" class="form-control" accept="image/jpeg,image/png,application/pdf,image/x-eps" name="document_{{ $item->id }}"
            placeholder="eg. Rizal" value="{{ $item->id }}"/>
        </div>
        
        @endforeach
    @endif
   
    <hr/>
    <button class="btn btn-sm btn-secondary text-white px-3 py-1" type="submit">Save Changes</button>

</form>
<script>
      function validateFile(input) {

            const fileSize = input.files[0].size / 1024 / 1024; // in MiB
            var fileName, fileExtension;
                fileName = $(input).val();

                if (fileSize > 2) {
                    Swal.fire({
                        title: "Invalid File Size",
                        text: "File size exceeds 2 MiB",
                        icon: "error",
                        showCloseButton: true,
                        confirmButtonColor: "#3085d6",
                        closeButtonColor: "#d33",
                    })
                    $(input).val(''); //for clearing with Jquery

                } else {

                    var validExtensions = ["jpg", "jpeg", "png", "jfif", "pjpeg", "gif", "pjp", "pdf"]; //array of valid extensions
                    fileExtension = fileName.replace(/^.*\./, '');
                    fileExtension = fileExtension.toLowerCase();

                    if ($.inArray(fileExtension, validExtensions) === -1){
                        Swal.fire({
                            title: "Invalid File Type",
                            text: 'File must be "jpg", "jpeg", "png", "pdf',
                            icon: "error",
                            showCloseButton: true,
                            confirmButtonColor: "#3085d6",
                            closeButtonColor: "#d33",
                        })
                        $(input).val('');
                    }else{
                    return true;
                    }
            }
    }

</script>
