<!-- SHS Modal-->
<div class="modal fade" id="jhsCurriculumModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Create New Junior Highschool Curriculum
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
		<form id="addjhsForm" role="form">
			@csrf
			<input type="hidden" value="JHS" name="studentDept">
			<div class="modal-body">
				<div class="form-group">
					<label for="curriculumYear">Curriculum Year</label>
					<input
						list="curriculum_year_list"
						type="text"
						class="form-control form-control-rounded"
						id="jhscurriculumYear"
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
					<textarea class="form-control form-control-textarea" name="curriculumDescription" id="jhscurriculumDescription" placeholder="Curriculum Description..." required></textarea>
				</div>
				<div class="form-group">
					<label for="schoolYear">Student Level</label>
					<select class="form-control border-radius-2" id="jhslevel" name="level" required>
						<option disabled selected value="">Select...</option>
						@foreach ($jhs_levels as $jhs_level)
							<option value="{{ $jhs_level->id }}">{{ $jhs_level->level_name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="programMajor">Program</label>
					<select class="form-control border-radius-2" id="programMajor" name="programMajor" required>
						<option disabled selected value="">Select...</option>
						@foreach ($programsMajorsJHS as $programsMajor)
							<option value="{{ $programsMajor->id }}">{{ $programsMajor->programs->program_code." - ".$programsMajor->programs->program_name." (".$programsMajor->majors->major_name.")"}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="schoolYear">School Year</label>
					<select class="form-control border-radius-2" id="jhsschoolYear" name="schoolYear" required>
						<option disabled selected value="">Select...</option>
						@foreach ($schoolYears as $schoolYear)
							<option value="{{ $schoolYear->id }}">{{ $schoolYear->school_years }}</option>
						@endforeach
					</select>
				</div>
			
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button name="addjhsCurriculum_btn" type="submit" class="btn btn-primary">Add</button>
			</div>
		</form>
		{{-- end Form  --}}
	  </div>
	</div>
  </div>
{{-- End Add Modal --}}

<!-- College Modal-->
<div class="modal fade" id="editjhsCurriculumModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Update Junior Highschool Curriculum
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
		<form id="editjhsForm" role="form">
			@csrf
			<input type="hidden" value="JHS" name="studentDept">
			<div class="modal-body">
				<div class="form-group">
					<label for="curriculumYear">Curriculum Year</label>
					<input
						list="curriculum_year_list"
						type="text"
						class="form-control form-control-rounded"
						id="upd_jhscurriculumYear"
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
					<textarea class="form-control form-control-textarea" name="curriculumDescription" id="upd_jhscurriculumDescription" placeholder="Curriculum Description..." required></textarea>
				</div>
				<div class="form-group">
					<label for="schoolYear">Student Level</label>
					<select class="form-control border-radius-2" id="upd_jhslevel" name="level" required>
					</select>
				</div>
				<div class="form-group">
					<label for="programMajor">Program</label>
					<select class="form-control border-radius-2" id="upd_jhsprogramMajor" name="programMajor" required>
					</select>
				</div>
				<div class="form-group">
					<label for="schoolYear">School Year</label>
					<select class="form-control border-radius-2" id="upd_jhsschoolYear" name="schoolYear" required>
					</select>
				</div>
			
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button name="editjhsCurriculum_btn" type="submit" class="btn btn-primary">Update</button>
			</div>
		</form>
		{{-- end Form  --}}
	  </div>
	</div>
  </div>
{{-- End Add Modal --}}
