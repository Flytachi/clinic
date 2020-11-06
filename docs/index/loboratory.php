<div class="card">
					<div class="card-header bg-white header-elements-inline">
						<h6 class="card-title">Добавить Услугу <span class="text-muted font-size-base ml-2">Направит пациента</span></h6>
						
					</div>

                	<form class="wizard-form steps-enable-all" action="#" data-fouc>
						<h6>Пациент</h6>
						<fieldset>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Выбрать Группу:</label>
										<select name="location" data-placeholder="Выбрать категорию" class="form-control form-control-select2" data-fouc>
											<option></option>
											<optgroup label="Выбрать категорию">
												<option value="1">Лаборатория</option>
												<option value="2">Консултация</option>
												<option value="3">Физиотерапия</option>
												<option value="4">Нейрохирургия</option>
												<option value="2">Травмотология</option>
											</optgroup>

											
										</select>
									</div>
								</div>

								
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Мед Услуги:</label>
										<select name="position" data-placeholder="Выбрать услугу" class="form-control form-control-select2" data-fouc>
											<option></option>
											<optgroup label="Наши Услуги">
												<option value="1">Осмотр Терапевта</option>
												<option value="2">Осмотр Травмотолога</option>
												<option value="3">Осмотр Нейрохирурга</option>
												<option value="4">Осмотр Эндокринолога</option>
											</optgroup>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Имя Специалиста:</label>
										<input type="text" name="name" class="form-control">
									</div>
								</div>

								
							</div>

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Кабинет Врача:</label>
										<input type="text" name="tel" class="form-control" 
									</div>
								</div>

								
							</div>
						</fieldset>

						<h6>Создать Пакет</h6>
						<fieldset>
							<div class="card">
						<div class="card-header header-elements-inline">
						<h5 class="card-title">Создать пакет услуг</h5>
						
						</div>
<button type="button" data-toggle="modal" data-target="#modal_default333" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple">Создать пакет</button>		
		<!-- Basic modal -->
				<div id="modal_default333" class="modal fade" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Создать пакет</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
									
									<div class="card">
							

							<div class="card-body">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Название пакета</label>
									<input type="text" class="form-control"  placeholder="Название пакета">
								</div>
<h6>Список услуг</h6>
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Выберите группу услуг</label>
									<input type="text" class="form-control"  placeholder="Группа услуг">
								</div>

								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Выберите услугу</label>
									<input type="text" class="form-control"  placeholder="Услуга">
								</div>
								
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Количество</label>
									<input type="number" class="form-control"  placeholder="Количество">
								</div>


	<button type="button" class="btn btn-outline bg-primary border-primary text-primary-800 btn-icon border-2 ml-2 legitRipple"><i class="icon-check"></i>Добавить</button>

<p>
</p>
								<div class="form-group form-group-float">
									<h6>Выбранные услуги</h6>
								</div>

								<table class="table">
												<thead>
													<tr class="bg-blue">
														<th>Услуга</th>
														
														<th>Количество</th>
														<th>Действия</th>
													</tr>
												</thead>
									<tbody>
										<tr>
											<td>Название услуги</td>
											
											<td>
											<div class="form-group form-group-float mt-2">
									<input type="number" class="form-control" readonly  placeholder="Количество">
											</div>
								</td>
											
											<td>
											
											<button type="button" class="btn btn-outline bg-danger border-danger text-danger-800 btn-icon border-2 ml-2 legitRipple"><i class="icon-trash"></i></button>
											<button type="button" class="btn btn-outline bg-primary border-primary text-primary-800 btn-icon border-2 ml-2 legitRipple"><i class="icon-pencil"></i></button>
											
											</td>
											
										</tr>
										
										
										
									</tbody>
								</table>
						
							</div>
						</div>
									
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
								<button type="button" class="btn bg-primary">Сохранить</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /basic modal -->
		
		
		<div class="card-body">
						
						
						<div class="bootstrap-duallistbox-container row moveonselect"> <div class="box1 col-md-6"> <label for="bootstrap-duallistbox-nonselected-list_" style="display: none;"></label> <input class="filter form-control" type="text" placeholder="Filter"> <div class="btn-group buttons"> <button type="button" class="btn moveall btn-light legitRipple" title="Move all"> <i class="icon-arrow-right22"></i> <i class="icon-arrow-right22"></i> </button> <button type="button" class="btn move btn-light legitRipple" title="Move selected"> <i class="icon-arrow-right22"></i> </button> </div> <select multiple="multiple" id="bootstrap-duallistbox-nonselected-list_" class="form-control" name="_helper1" style="height: 302px;"><option value="option1" selected="">Classical mechanics</option><option value="option2">Electromagnetism</option><option value="option4">Relativity</option><option value="option5" selected="">Quantum mechanics</option><option value="option7">Astrophysics</option><option value="option8" selected="">Biophysics</option><option value="option9">Chemical physics</option><option value="option10">Econophysics</option><option value="option11">Geophysics</option><option value="option12">Medical physics</option><option value="option13">Physical chemistry</option><option value="option14" selected="">Continuum mechanics</option><option value="option15">Electrodynamics</option><option value="option16" selected="">Quantum field theory</option><option value="option17">Scattering theory</option><option value="option18" selected="">Chaos theory</option><option value="option19" selected="">Newton's laws of motion</option><option value="option20">Thermodynamics</option></select> <span class="info-container"> <span class="info">Showing all 18</span> <button type="button" class="btn clear1 float-right btn-light btn-xs legitRipple">show all</button> </span> </div> <div class="box2 col-md-6"> <label for="bootstrap-duallistbox-selected-list_" style="display: none;"></label> <input class="filter form-control" type="text" placeholder="Filter"> <div class="btn-group buttons"> <button type="button" class="btn remove btn-light legitRipple" title="Remove selected"> <i class="icon-arrow-left22"></i> </button> <button type="button" class="btn removeall btn-light legitRipple" title="Remove all"> <i class="icon-arrow-left22"></i> <i class="icon-arrow-left22"></i> </button> </div> <select multiple="multiple" id="bootstrap-duallistbox-selected-list_" class="form-control" name="_helper2" style="height: 302px;"></select> <span class="info-container"> <span class="info">Empty list</span> <button type="button" class="btn clear2 float-right btn-light btn-xs legitRipple">show all</button> </span> </div></div><select multiple="multiple" class="form-control listbox-tall" data-fouc="" style="display: none;">
							<option value="option1" selected="">Classical mechanics</option>
							<option value="option2">Electromagnetism</option>
							<option value="option4">Relativity</option>
							<option value="option5" selected="">Quantum mechanics</option>
							<option value="option7">Astrophysics</option>
							<option value="option8" selected="">Biophysics</option>
							<option value="option9">Chemical physics</option>
							<option value="option10">Econophysics</option>
							<option value="option11">Geophysics</option>
							<option value="option12">Medical physics</option>
							<option value="option13">Physical chemistry</option>
							<option value="option14" selected="">Continuum mechanics</option>
							<option value="option15">Electrodynamics</option>
							<option value="option16" selected="">Quantum field theory</option>
							<option value="option17">Scattering theory</option>
							<option value="option18" selected="">Chaos theory</option>
							<option value="option19" selected="">Newton's laws of motion</option>
							<option value="option20">Thermodynamics</option>
						</select>
					</div>
				</div>
						</fieldset>

						<h6>Завершить</h6>
				<fieldset>
					<div class="card">
								<div class="card-header header-elements-inline">
									<h5 class="card-title">Услуга пациента</h5>
									<div class="header-elements">
										<div class="list-icons">
											<a class="list-icons-item" data-action="collapse"></a>
											<a class="list-icons-item" data-action="reload"></a>
										</div>
									</div>
								</div>
						<div class="table-responsive">
							<table class="table table-xl">
									<thead>
										<tr class="bg-blue">
											<th>ID</th>
											<th>ФИО</th>
											<th>Услуга/Пакет</th>
											<th>Состав услуги или пакета</th>
											<th>Стоимость</th>
										</tr>
									</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>2</td>
										<td>
										<span class="badge badge-success">Услуга</span>
										<span class="badge badge-warning">Пакет</span>
										</td>
										<td>5</td>
										<td>6</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</fieldset>	
			</form>
	            </div>
	            <!-- /starting step -->

