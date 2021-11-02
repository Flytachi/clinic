<?php

class VisitIcdHistoryModel extends VisitModel
{
    public $_icd_history = 'visit_icd_history';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Назначить диагноз</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
            <input type="hidden" name="icd_autor" value="<?= $session->session_id ?>">

            <div class="modal-body">

                <div class="form-group">
                    <label>ICD (МКБ):</label>
                    <select data-placeholder="Выберите диагноз" name="icd_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach($db->query("SELECT * from international_classification_diseases LIMIT 10") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($this->value('icd_id') == $row['id']) ? "selected" : "" ?>><?= $row['decryption'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Назначить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function update()
    {
        global $db, $session;
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $db->beginTransaction();

            $history = Mixin\insert($this->_icd_history,  array('branch_id' => $this->post['branch_id'], 'visit_id' => $pk, 'icd_id' => $this->post['icd_id'], 'responsible_id' => $session->session_id));
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($history) or !intval($object)){
                $this->error("Ошибка при назначении диагноза!");
                $db->rollBack();
            }

            $db->commit();
            $this->success();
        }
    }

    public function success($stat=null)
    {   
        $_SESSION['message'] = '
        <div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message, $stat=null)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }

}


?>