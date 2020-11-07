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
                        <?php
                            include 'tabs/kassa_1.php';
                        ?>
                    </div>

                    <div class="tab-pane fade" id="highlighted-justified-tab2">
                        <?php
                            include 'tabs/kassa_2.php';
                        ?>
                    </div>

                    <div class="tab-pane fade" id="highlighted-justified-tab3">
                        <?php
                            include 'tabs/kassa_3.php';
                        ?>
                    </div>

                    <div class="tab-pane fade" id="highlighted-justified-tab4">
                        <?php
                            include 'tabs/kassa_4.php';
                        ?>
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
