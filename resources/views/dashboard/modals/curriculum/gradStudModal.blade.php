<!-- College Modal-->
<div class="modal fade" id="gradStudCurriculumModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Create New Graduate Studies Curriculum
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
		<form id="addGradStudForm" role="form">
			@csrf
			<input type="hidden" value="Graduate Studies" name="studentDept">
			<div class="modal-body">
				<div class="form-group">
					<label for="curriculumYear">Curriculum Year</label>
					<input
						list="curriculum_year_list"
						type="text"
						class="form-control form-control-rounded"
						id="curriculumYear"
						aria-describedby="curriculumYearHelp"
						name="curriculumYear"
						placeholder="eg. 2020-2022, 2023-2025 2026-2028..."
						required
					/>
					<datalist id="curriculum_year_list">
						@foreach ($distinctCurriculumYears as $distinctCurriculumYear)
							<option value="{{ $distinctCurriculumYear->curriculum_year }}">
						@endforeach
					</datalist>     
				</div>
				<div class="form-group">
					<label for="courseDescription">Curriculum Description</label>
					<textarea class="form-control form-control-textarea" name="curriculumDescription" id="curriculumDescription" placeholder="Curriculum Description..." required></textarea>
				</div>
				<div class="form-group">
					<label for="schoolYear">Student Level</label>
					<select class="form-control border-radius-2" id="level" name="level" required>
						<option disabled selected value="">Select...</option>
						@foreach ($grad_stud_levels as $grad_stud_level)
							<option value="{{ $grad_stud_level->id }}">{{ $grad_stud_level->level_name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="programMajor">Program & Major</label>
					<select class="form-control border-radius-2" id="programMajor" name="programMajor" required>
						<option disabled selected value="">Select...</option>
						@foreach ($programsMajorsGraduateStudies as $programsMajor)
							<option value="{{ $programsMajor->id }}">{{ $programsMajor->programs->program_code." - ".$programsMajor->programs->program_name." (".$programsMajor->majors->major_name.")"}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="schoolYear">School Year</label>
					<select class="form-control border-radius-2" id="schoolYear" name="schoolYear" required>
						<option disabled selected value="">Select...</option>
						@foreach ($schoolYears as $schoolYear)
							<option value="{{ $schoolYear->id }}">{{ $schoolYear->school_years }}</option>
						@endforeach
					</select>
				</div>
			
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

<!-- College Modal-->
<div class="modal fade" id="editGradCurriculumModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Update Graduate Studies Curriculum
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
		<form id="editGradStudForm" role="form">
			@csrf
			<input type="hidden" value="Graduate Studies" name="studentDept">
			<div class="modal-body">
				<div class="form-group">
					<label for="curriculumYear">Curriculum Year</label>
					<input
						list="curriculum_year_list"
						type="text"
						class="form-control form-control-rounded"
						id="upd_gradCurriculumYear"
						aria-describedby="curriculumYearHelp"
						name="curriculumYear"
						placeholder="eg. 2020-2022, 2023-2025 2026-2028..."
						required
					/>
					<datalist id="curriculum_year_list">
						@foreach ($distinctCurriculumYears as $distinctCurriculumYear)
							<option value="{{ $distinctCurriculumYear->curriculum_year }}">
						@endforeach
					</datalist>     
				</div>
				<div class="form-group">
					<label for="courseDescription">Curriculum Description</label>
					<textarea class="form-control form-control-textarea" name="curriculumDescription" id="upd_gradCurriculumDescription" placeholder="Curriculum Description..." required></textarea>
				</div>
				<div class="form-group">
					<label for="schoolYear">Student Level</label>
					<select class="form-control border-radius-2" id="upd_gradLevel" name="level" required>
					</select>
				</div>
				<div class="form-group">
					<label for="programMajor">Program & Major</label>
					<select class="form-control border-radius-2" id="upd_gradProgramMajor" name="programMajor" required>
					</select>
				</div>
				<div class="form-group">
					<label for="schoolYear">School Year</label>
					<select class="form-control border-radius-2" id="upd_gradSchoolYear" name="schoolYear" required>
					</select>
				</div>
			
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button name="editCollegeCurriculum_btn" type="submit" class="btn btn-primary">Update</button>
			</div>
		</form>
		{{-- end Form  --}}
	  </div>
	</div>
  </div>
{{-- End Add Modal --}}
