<div class="row">

    <div class="col-md-4">
        <div class="card">

            <div class="card-body">

                <div class="form-group form-group-float">
                    <label class="form-group-float-label text-danger font-weight-semibold animate">ID или имя пациента</label>
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="text" class="form-control border-danger" placeholder="Введите ID или имя">
                        <div class="form-control-feedback text-danger">
                            <i class="icon-search4"></i>
                        </div>
                    </div>
                    <span class="form-text text-danger">Выбор пациента</span>
                </div>

            </div>

        </div>
    </div>

    <div class="col-md-8">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Возврат</h5>
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
                        <th style="width:20%;">Дата и время</th>
                        <th>Мед услуги</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>02.05.2021 14:30</td>
                        <td>Осмотр терапевта</td>
                        <td>50000</td>
                        <td>Проведен/Пластик</td>
                        <td><button type="button" class="btn btn-sm btn-danger legitRipple" data-toggle="button">Отменить</button></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple ">Печать чека</button>
                        </td>
                    </tr>

                </tbody>
            </table>
            </div>

        </div>

    </div>

</div>
