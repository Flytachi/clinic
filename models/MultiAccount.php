<?php

use Mixin\Model;

class MultiAccountModel extends Model
{
    use ResponceRender;
    public $table = 'multi_accounts';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        is_message();
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">

            <div class="form-group row">

                <div class="col-4">
                    <label>Slot:</label>
                    <input type="text" class="form-control" name="slot" placeholder="Enter slot" required value="<?= $this->value('slot') ?>">
                </div>
    
                <div class="col-8">
                    <label>Выбирите пользователя:</label>
                    <select data-placeholder="Enter user" name="user_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach ($db->query("SELECT id, username FROM users WHERE branch_id = $session->branch") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($this->value('user_id') == $row['id']) ? "selected" : "" ?>><?= $row['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
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
        if ($pk) {
            $this->jquery_init();
        }
    }
}

?>