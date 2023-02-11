<!-- SHS Modal-->
<div class="modal fade" id="elemCurriculumModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Create New Elementary Curriculum
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
		<form id="addelemForm" role="form">
			@csrf
			<input type="hidden" value="Elementary" name="studentDept">
			<div class="modal-body">
				<div class="form-group">
					<label for="curriculumYear">Curriculum Year</label>
					<input
						list="curriculum_year_list"
						type="text"
						class="form-control form-control-rounded"
						id="elemcurriculumYear"
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
					<textarea class="form-control form-control-textarea" name="curriculumDescription" id="elemcurriculumDescription" placeholder="Curriculum Description..." required></textarea>
				</div>
				<div class="form-group">
					<label for="schoolYear">Student Level</label>
					<select class="form-control border-radius-2" id="elemlevel" name="level" required>
						<option disabled selected value="">Select...</option>
						@foreach ($elem_levels as $elem_level)
							<option value="{{ $elem_level->id }}">{{ $elem_level->level_name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="programMajor">Program</label>
					<select class="form-control border-radius-2" id="programMajor" name="programMajor" required>
						<option disabled selected value="">Select...</option>
						@foreach ($programsMajorsElementary as $programsMajor)
							<option value="{{ $programsMajor->id }}">{{ $programsMajor->programs->program_code." - ".$programsMajor->programs->program_name." (".$programsMajor->majors->major_name.")"}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="schoolYear">School Year</label>
					<select class="form-control border-radius-2" id="elemschoolYear" name="schoolYear" required>
						<option disabled selected value="">Select...</option>
						@foreach ($schoolYears as $schoolYear)
							<option value="{{ $schoolYear->id }}">{{ $schoolYear->school_years }}</option>
						@endforeach
					</select>
				</div>
			
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button name="addelemCurriculum_btn" type="submit" class="btn btn-primary">Add</button>
			</div>
		</form>
		{{-- end Form  --}}
	  </div>
	</div>
  </div>
{{-- End Add Modal --}}

<!-- College Modal-->
<div class="modal fade" id="editelemCurriculumModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Update Elementary Curriculum
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
		<form id="editelemForm" role="form">
			@csrf
			<input type="hidden" value="Elementary" name="studentDept">
			<div class="modal-body">
				<div class="form-group">
					<label for="curriculumYear">Curriculum Year</label>
					<input
						list="curriculum_year_list"
						type="text"
						class="form-control form-control-rounded"
						id="upd_elemcurriculumYear"
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
					<textarea class="form-control form-control-textarea" name="curriculumDescription" id="upd_elemcurriculumDescription" placeholder="Curriculum Description..." required></textarea>
				</div>
				<div class="form-group">
					<label for="schoolYear">Student Level</label>
					<select class="form-control border-radius-2" id="upd_elemlevel" name="level" required>
					</select>
				</div>
				<div class="form-group">
					<label for="programMajor">Program</label>
					<select class="form-control border-radius-2" id="upd_elemprogramMajor" name="programMajor" required>
					</select>
				</div>
				<div class="form-group">
					<label for="schoolYear">School Year</label>
					<select class="form-control border-radius-2" id="upd_elemschoolYear" name="schoolYear" required>
					</select>
				</div>
			
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button name="editelemCurriculum_btn" type="submit" class="btn btn-primary">Update</button>
			</div>
		</form>
		{{-- end Form  --}}
	  </div>
	</div>
  </div>
{{-- End Add Modal --}}
