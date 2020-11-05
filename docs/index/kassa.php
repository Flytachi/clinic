<!-- Highlighted tabs -->
<div class="row">

    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                    <li class="nav-item"><a href="#highlighted-justified-tab1" class="nav-link active" data-toggle="tab">Приём платежей</a></li>
                    <li class="nav-item"><a href="#highlighted-justified-tab2" class="nav-link" data-toggle="tab">История платежей</a></li>
                    <li class="nav-item"><a href="#highlighted-justified-tab3" class="nav-link" data-toggle="tab">Возврат</a></li>
                    <li class="nav-item"><a href="#highlighted-justified-tab4" class="nav-link" data-toggle="tab">Стационар</a></li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane fade show active" id="highlighted-justified-tab1">
                        <!-- Hover rows -->
                        <div class="row">

                            <div class="col-md-5">
                                <div class="card">
                                    <div class="card-header header-elements-inline">
                                        <h5 class="card-title">Приём платежей</h5>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item" data-action="reload"></a>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>ID</th>
                                                        <th>ФИО</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>0007</td>
                                                        <td>Kopyov</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">

                            <div class="card-header header-elements-inline">
                                <h5 class="card-title">Подробнее о пациенте <b>Евгений Копьев</b></h5>
                                <div class="header-elements">
                                    <div class="list-icons">

                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="bg-blue">
                                            <th>Дата и время</th>
                                            <th>Мед услуги</th>
                                            <th>Сумма</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>04.02.2021</td>
                                            <td>Осмотр терапевта</td>
                                            <td>50 000</td>
                                        </tr>
                                        <tr>
                                            <td>04.02.2021</td>
                                            <td>МРТ</td>
                                            <td>300 000</td>
                                        </tr>
                                        <tr>
                                            <td>04.02.2021</td>
                                            <td>Массаж</td>
                                            <td>60 000</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple" data-toggle="modal" data-target="#modal_default">Оплата</button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        </div>
                        <!-- /hover rows -->
                    </div>

                    <div class="tab-pane fade" id="highlighted-justified-tab2">

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

                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label text-success font-weight-semibold animate">ID или имя пациента</label>
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <input type="date" class="form-control">
                                            </div>
                                            <span class="form-text text-success">Выбор даты</span>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-8">

                                <div class="card-header header-elements-inline">
                                    <h5 class="card-title">История платежей</h5>
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
                                                    <th>Скидка</th>
                                                    <th>Возврат</th>
                                                    <th>Расчет</th>
                                                    <th>Сумма</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>02.05.2021 14:30</td>
                                                    <td>Осмотр терапевта</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>Пластик</td>
                                                    <td>50000</td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple ">Загрузить</button>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="highlighted-justified-tab3">

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

                    </div>

                    <div class="tab-pane fade" id="highlighted-justified-tab4">

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
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
<!-- /highlighted tabs -->


<!-- Basic modal -->
<div id="modal_default" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Оплата</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10 offset-md-1">
                                        <form action="#">
                                            <div class="form-group" style="margin-bottom: 0px !important;">
                                                <label class="col-form-label" style="margin-bottom: -5px !important;">Сумма к оплате:</label>
                                                <input type="text" class="form-control" value="300 000" disabled>
                                            </div>

                                            <div class="form-group" style="margin-bottom: 0px !important;">
                                                <label class="col-form-label" style="margin-bottom: -5px !important;">Скидка:</label>
                                                <input type="text" class="form-control" placeholder="%">
                                            </div>


                                            <div class="form-group" style="margin-bottom: 0px !important;">
                                                <label class="col-form-label" style="margin-bottom: -5px !important;">Пластиковая карта:</label>
                                                <input type="text" class="form-control" placeholder="">
                                            </div>

                                            <div class="form-group" style="margin-bottom: 0px !important;">
                                                <label class="col-form-label" style="margin-bottom: -5px !important;">Перечисление:</label>
                                                <input type="text" class="form-control" placeholder="">
                                            </div>

                                            <div class="form-group" style="margin-bottom: 0px !important;">
                                                <label class="col-form-label" style="margin-bottom: -5px !important;">Наличный расчет:</label>
                                                <input type="text" class="form-control" placeholder="" >
                                            </div>



                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-0 font-weight-semibold">
                        <ul>
                            <li style="margin-bottom: -15px !important;">Общая сумма к оплате - 300000</li><br>
                            <li style="margin-bottom: -15px !important;">Скидка-0</li><br>
                            <li style="margin-bottom: -15px !important;">Сумма с скидками-300000</li>
                        </ul>
                    </h6>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn bg-primary">Печать чека</button>
            </div>
        </div>
    </div>
</div>


<div id="modal_default2" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Возврат</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
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
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn bg-primary">Печать чека</button>
            </div>
        </div>
    </div>
</div>
<!-- /basic modal -->
