<div class="row">
	<div class="col-md-6">

	</div>

	<div class="col-md-6">

	</div>
</div>
<!-- /vertical form options -->

<!-- Fieldset legend -->
<div class="row">
	<div class="col-md-6">

		

	</div>

	<div class="col-md-6">

		

	</div>
</div>
<!-- /fieldset legend -->

<!-- 2 columns form -->
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Регистрация пациента</h5>
		<div class="header-elements">
			<div class="list-icons">
        		<a class="list-icons-item" data-action="collapse"></a>
        		<a class="list-icons-item" data-action="reload"></a>
				<div class="col-lg-4">
					<div>
						<div class="text-center">
							<button type="button" class="btn btn-primary"><i class="icon-user-plus mr-2"></i> Добавить</button>
						</div>
					</div>
				</div>
        		
        	</div>
    	</div>
	</div>

	<div class="card-body">
		<form action="#">
			<div class="row">
				<div class="col-md-4">
					<fieldset>
						<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Добавить пациента</legend>

						<div class="form-group">
							<label>Имя пациента:</label>
							<input type="text" class="form-control" placeholder="Введите имя">
						</div>

						<div class="form-group">
							<label>Фамилия пациента:</label>
							<input type="text" class="form-control" placeholder="Введите Фамилия">
						</div>
						<div class="form-group">
							<label>Отчество пациента:</label>
							<input type="text" class="form-control" placeholder="Введите Отчество">
						</div>
						<div class="form-group">
					        <label>Дата рождение:</label>
					      <div class="input-group">
						    <span class="input-group-prepend">
							 <span class="input-group-text"><i class="icon-calendar22"></i></span>
						     </span>
						     <input type="date" class="form-control daterange-single" value="03/18/2013">
					    </div>
				        </div>

						<div class="form-group">
							<label>Выбирите регион:</label>
							<select data-placeholder="Выбрать регион" class="form-control form-control-select2" data-fouc>
								<option></option>
								<optgroup label="Бухоро вилояти">
									<option value="AK">Бухоро ш</option>
									<option value="HI">Жондор</option>
									<option value="CA">Вобкент</option>
									<option value="NV">Шофиркон</option>
									<option value="WA">Гиждувон</option>
									<option value="WA">Бухоро т</option>
									<option value="WA">Когон т</option>
									<option value="WA">Когон ш</option>
									<option value="WA">Қаравулбозор</option>
									<option value="WA">Қоракўл</option>
									<option value="WA">Олот</option>
									<option value="WA">Ромитан</option>
								</optgroup>
								<optgroup label="Тошкент вилояти">
									<option value="AZ">Чилонзор</option>
									<option value="CO">Миробод</option>
									<option value="WY">Олмазор</option>
									<option value="WY">Юнусобод</option>
								</optgroup>
								<optgroup label="Наманган вилояти">
									<option value="AL">Наманган</option>
									<option value="AR">Наманган</option>
									<option value="KY">Наманган</option>
								</optgroup>
								<optgroup label="Фарғона вилояти">
									<option value="CT">Фарғона</option>
									<option value="DE">Фарғона</option>
									<option value="WV">Фарғона</option>
								</optgroup>
							</select>
						</div>
	
					</fieldset>
				</div>

				<div class="col-md-8">
					<fieldset>
	                	<legend class="font-weight-semibold"><i class="icon-user"></i> Данные пациента</legend>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Серия паспорта:</label>
									<input type="text" placeholder="Серия паспорта" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Номер паспорта:</label>
									<input type="number" placeholder="Введите номер" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Место работ:</label>
									<input type="text" placeholder="Введите место работ" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Должность:</label>
									<input type="text" placeholder="Введите должность" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Телефон номер:</label>
									<input type="number" placeholder="+9989" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Рабочий телефон:</label>
									<input type="number" placeholder="+9989" class="form-control">
								</div>
							</div>
							     
							<div class="col-md-6">
								<div class="form-group">
		                            <label>Выбирите категорию:</label>
		                            <select data-placeholder="Выбрать категорию" class="form-control form-control-select2" data-fouc>
		                            	<option></option>
		                                <option value="Консультация">Консультация</option> 
		                                <option value="Диагностика">Диагностика</option> 
		                                <option value="Неврология">Неврология</option> 
		                                <option value="Лаборатория">Лаборатория</option> 
		                            </select>
	                            </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
		                            <label>Выбирите Услугу:</label>
		                            <select data-placeholder="Выбрать Услугу" class="form-control form-control-select2" data-fouc>
		                            	<option></option>
		                                <option value="Консультация терапевта">Консультация терапевта</option> 
		                                <option value="Консультация травмотолога">Консультация травмотолога</option> 
		                                <option value="Консультация кардиолога">Консультация кардиолога</option> 
		                                <option value="Консультация Ортапеда">Консультация Ортапеда</option> 
		                            </select>
	                            </div>
							</div>
							
							<div class="col-md-5">
								<div class="form-group">
									<label>Адрес проживание:</label>
									<input type="text" class="form-control" placeholder="Введите адрес">
								</div>	
							</div>
							
							<div class="col-md-5">
								<div class="form-group">
									<label>Адрес по прописке:</label>
									<input type="text" class="form-control" placeholder="Введите адрес">
								</div>
							</div>


							<div class="col-md-2" style="margin-top: 5px;">
				                <div class="form-check" style="margin-bottom: 10px;">
									<label class="form-check-label">
										<input type="checkbox" class="form-check-input" checked="">
										Мужчина
									</label>
								</div>
								<div class="form-check">
									<label class="form-check-label">
										<input type="checkbox" class="form-check-input" checked="">
										Женщина
									</label>
								</div>
							</div>
							
							<!-- <div class="form-group col-12">
								<label>Добавить фото:</label>
								<input type="file" class="form-control-uniform-custom">
							</div> -->

					</fieldset>
				</div>


				<div class="col-md-3">
					<div class="form-group">
						<label>Специалист 	:</label>
						<input type="text" placeholder="Специалист" class="form-control">
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>№ кабинета:</label>
						<input type="text" placeholder="№ кабинета" class="form-control">
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>№ очереда:</label>
						<input type="text" placeholder="№ очереда" class="form-control">
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>ID:</label>
						<input type="id" placeholder="ID номер" class="form-control">
					</div>
				</div>
			</div>

			<div class="text-right">
				<button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
			</div>
		</form>
	</div>
</div>
<!-- /2 columns form -->
<div class="card">
	<div class="card-header header-elements-inline">
		<h4 class="card-title">Список пациентов</h4>
		<div class="header-elements">
			<div class="list-icons">
        		<a class="list-icons-item" data-action="collapse"></a>
        		<a class="list-icons-item" data-action="reload"></a>
        		
        	</div>
    	</div>
	</div>
    <table class="table table-hover table-columned">
		<thead>
			<tr>
				<th>ID</th>
				<th>Имя</th>
				<th>Фамилия</th>
				<th>Отчество</th>
				<th>Дата рождение</th>
				<th>Телефон</th>
				<th>Мед услуга</th>
				<th>Дата визита</th>
				<th>Тип визита</th>
				<th class="text-center">Действия</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>5</td>
				<td>6</td>
				<td>7</td>
				<td>7</td>
				<td class="text-center">
				<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				<div class="dropdown-menu dropdown-menu-right">
						<a href="#" class="dropdown-item"><i class="icon-file-text"></i>В Регистратуру</a>
						<a href="#" class="dropdown-item"><i class="icon-file-text2"></i> История пациента</a>
						<a href="#" class="dropdown-item"><i class="icon-paste2"></i>Заключения врача</a>
						<a href="#" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
					</div>
				</td>
			</tr>
			</tbody>
	</table>
</div>