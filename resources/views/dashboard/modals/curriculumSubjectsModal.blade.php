<!-- Curriculum Subject Modal-->
<div class="modal fade" id="addCurriculumSubjectsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Add Subjects to Curriculum
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
		{{-- Form --}}
		<form id="addCurriculumSubjectForm" role="form">
			@csrf
			<input type="hidden" value="{{$cur_id->id}}" name="curriculum_id">
			<div class="modal-body">
			@if($cur_id->student_department == 'College' || $cur_id->student_department == 'SHS')
				<div class="form-group">
					<label for="term">Term</label>
					<select class="form-control border-radius-2" name="term" required>
						<option disabled selected value="">Select...</option>
						@foreach ($terms as $term)
							<option value=" {{$term->id}}">{{$term->term_name}}</option>
						@endforeach 
					</select>				
				</div>
			@endif
				<div class="form-group">
					<label for="subject">Subject</label>
					<select class="form-control border-radius-2 select2" name="subject[]" multiple required>
					
						@foreach ($subjects as $subject)
							<option value=" {{$subject->id}}">{{$subject->subject_code}} - {{$subject->subject_name}}</option>
						@endforeach 
					</select>
				</div>
			@if($cur_id->student_department == 'College')
				<div class="form-group">
					<label for="prerequisite">Pre-Requisite</label>
					<select class="form-control border-radius-2" name="prerequisite">
						<option disabled selected value="">Select...</option>
						@foreach ($cur_subjects as $cur_subject)
							<option value=" {{$cur_subject->subject_id}}">{{$cur_subject->subjectName}}</option>
						@endforeach 
					</select>
				</div>
			@endif
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button name="addCollegeCurriculum_btn" type="submit" class="btn btn-primary">Add</button>
			</div>
		</form>
		{{-- end Form  --}}
	  </div>
	</div>
  </div>
{{-- End Add Modal --}}


<!-- Curriculum Subject Modal-->
<div class="modal fade" id="editCurriculumSubjectsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Update Curriculum Subjects
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
		{{-- Form --}}
		<form id="editCurriculumSubjectForm" role="form">
			@csrf
			<input type="hidden" value="{{$cur_id->id}}" name="curriculum_id">
			<div class="modal-body">
				@if($cur_id->student_department == 'College')
				<div class="form-group">
					<label for="term">Term</label>
					<select class="form-control border-radius-2" name="term" id="term" required>
						<option disabled selected value="">Select...</option>
					</select>				
				</div>
				@endif
				<div class="form-group">
					<label for="subject">Subject</label>
					<select class="form-control border-radius-2" name="subject" id="subject" required>
						<option disabled selected value="">Select...</option>
					</select>
				</div>
				@if($cur_id->student_department == 'College')
				<div class="form-group">
					<label for="prerequisite">Pre-Requisite</label>
					<select class="form-control border-radius-2" name="prerequisite" id="prerequisite">
						<option disabled selected value="">Select...</option>
					</select>
				</div>

				@endif
				<div class="form-group">
					<label for="subject_type">Offered?</label>
					<select
						class="form-control required"
						id="is_offered"
						name="is_offered">
					
					</select>
				</div>
				
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button name="addCollegeCurriculum_btn" type="submit" class="btn btn-primary">Update</button>
			</div>
		</form>
		{{-- end Form  --}}
	  </div>
	</div>
  </div>
{{-- End Add Modal --}}
