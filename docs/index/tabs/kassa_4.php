<div class="row">

    <div class="col-md-4">

        <div class="card">
            <div class="card-body">

                <div class="form-group form-group-float">
                    <label class="form-group-float-label text-success font-weight-semibold animate">ID или имя пациента</label>
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="text" class="form-control border-success" placeholder="Введите ID или имя">
                        <div class="form-control-feedback text-success">
                            <i class="icon-search4"></i>
                        </div>
                    </div>
                    <span class="form-text text-success">Выбор пациента</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width:20%;">ID</th>
                                <th>ФИО</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>8525</td>
                                <td>Евгений Копьев</td>

                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <div class="col-md-8">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Стационар</h5>
            <div class="header-elements">
                <div class="list-icons">

                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width:20%;">Баланс пациента</th>
                            <th>Предоплата</th>
                            <th>Возврат</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group form-group-float">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input type="text" class="form-control border-success" value="АВТО" disabled>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-group-float">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input type="text" class="form-control border-success" placeholder="" >
                                        <div class="form-control-feedback text-success">
                                            <i class="icon-checkmark-circle2"></i>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group form-group-float">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input type="text" class="form-control border-success" placeholder="" >
                                        <div class="form-control-feedback text-success">
                                            <i class="icon-checkmark-circle2" data-toggle="modal" data-target="#modal_default2"></i>
                                        </div>

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple ">Экспорт в PDF</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>
