
<!-- Edit Grades Modal-->
<div
    class="modal fade"
    id="editGradesModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Edit Grades
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
                <form id="editGrades" role="form"  data-toggle="validator">
                    @csrf
                    <div id="gradeList"></div>
                    <button id="btn" type="submit" class="btn btn-success float-right">Save Grade</button>
                </form>

            </div>
        </div>
    </div>
</div>
