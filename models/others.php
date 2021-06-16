<?php

class LaboratoryUpStatus extends Model
{
    public $table = 'visit';
    public $table2 = 'visit_analyze';

    public function get_or_404($pk)
    {
        global $db;

        foreach ($db->query("SELECT id FROM visit WHERE user_id = $pk AND laboratory IS NOT NULL AND accept_date IS NULL AND completed IS NULL") as $value) {
            $this->post['id'] = $value['id'];
            $this->post['status'] = 2;
            $this->post['accept_date'] = date('Y-m-d H:i:s');
            $this->update();
        }
        $this->success();
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
            }

        }
    }

    public function success()
    {
        render();
    }

}

class NotesModel extends Model
{

     public $table = "notes";

     public function form($pk=null)
     {
        global $patient;
         ?>

         <form method="POST" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-4">
                        <label>Выберите дату:</label>
                        <input type="date" class="form-control" name="date_text">
                    </div>
                    <div class="col-md-4">
                        <label>Выберите время:</label>
                        <input type="time" class="form-control" name="time_text">
                    </div>
                    <div class="col-md-4">
                        <label>Введите описание:</label>
                        <input type="text" class="form-control" name="description">
                    </div>
                </div>

            </div>

             <div class="modal-footer">

                <div class="text-right" style="margin-top: 1%;">
                    <button type="submit" class="btn btn-outline-info btn-sm legitRipple">Сохранить</button>
                </div>

            </div>

         </form>
         <?php
     }

     public function success()
     {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';

        render();
     }

     public function error($message)
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
