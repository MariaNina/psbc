
{{-- Update Branch Modal --}}
<div
    class="modal fade"
    id="collegeAttendanceModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                
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

                 {{-- Alert --}}
                 <div class="alert alert-danger errorAlert" hidden>
                </div>
                {{-- end alert --}}
                <label for="rate">Hourly Rate:</label>
              
                <form id="updateCollegeAttendance" role="form" data-toggle="validator">
                    @csrf
                    <input type="text" id="salary_amount" name="salary_amount" readonly>
                    <input type="hidden" name="cutoff_id" id="cutoff_id" value="">
                    <div class="table-responsive">
                    <table class="table" id="filtertable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Day</th>
                            <th>No. of Hour</th>
                            <th>Rate</th>
                        </tr>
                        </thead>
                        <tbody class="table_body">

                        </tbody>
                    </table>
                    </div>
                    <button id="btnUpdate" type="submit" class="btn btn-success float-right">Save</button>
                </form>

            </div>
        </div>
    </div>
</div>