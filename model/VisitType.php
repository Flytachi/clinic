<?php

use Mixin\Model;

class VisitType extends Model
{
    use ResponceRender;
    public $table = 'visit_types';

    public function form()
    {
        ?>
        <form action="<?= $this->urlHook() ?>" method="post">

            <?php $this->csrfToken() ?>

            <div class="form-group">
                <label>Наименование:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите наименование" required value="<?= $this->value('name') ?>">
            </div>

            <div class="form-group row">
            
                <div class="col-md-6">
                    <label class="d-block font-weight-semibold">Бесплатно:</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="free_service_1" name="free_service_1" value="1" <?= ($this->value('free_service_1')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="free_service_1">Услуги (обычные)</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="free_service_2" name="free_service_2" value="1" <?= ($this->value('free_service_2')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="free_service_2">Услуги (консультуции)</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="free_service_3" name="free_service_3" value="1" <?= ($this->value('free_service_3')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="free_service_3">Услуги (операционные)</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="free_laboratory" name="free_laboratory" value="1" <?= ($this->value('free_laboratory')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="free_laboratory">Лаборатория</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="free_diagnostic" name="free_diagnostic" value="1" <?= ($this->value('free_diagnostic')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="free_diagnostic">Диагностика</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="free_physio" name="free_physio" value="1" <?= ($this->value('free_physio')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="free_physio">Физиотерапия</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="free_bed" name="free_bed" value="1" <?= ($this->value('free_bed')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="free_bed">Койка</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="d-block font-weight-semibold">Визиты:</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ambulator" name="is_ambulator" value="1" <?= ($this->value('is_ambulator')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="ambulator">Амбулаторный</label>
                    </div>
                    
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="stationar" name="is_stationar" value="1" <?= ($this->value('is_stationar')) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="stationar">Стационарный</label>
                    </div>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

    public function updateBefore()
    {
        if (!$this->getPost('is_ambulator')) $this->setPostItem('is_ambulator', null);
        if (!$this->getPost('is_stationar')) $this->setPostItem('is_stationar', null);
        if (!$this->getPost('free_service_1')) $this->setPostItem('free_service_1', null);
        if (!$this->getPost('free_service_2')) $this->setPostItem('free_service_2', null);
        if (!$this->getPost('free_service_3')) $this->setPostItem('free_service_3', null);
        if (!$this->getPost('free_laboratory')) $this->setPostItem('free_laboratory', null);
        if (!$this->getPost('free_diagnostic')) $this->setPostItem('free_diagnostic', null);
        if (!$this->getPost('free_physio')) $this->setPostItem('free_physio', null);
        if (!$this->getPost('free_bed')) $this->setPostItem('free_bed', null);
        parent::updateBefore();
    }

}

?>