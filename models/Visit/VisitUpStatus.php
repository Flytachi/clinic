<?php

class VisitUpStatus extends Model
{
    public $table = 'visit';

    public function get_or_404($pk)
    {
        if(division_assist() == 1){
            $this->post['assist_id'] = $_SESSION['session_id'];
        }
        if (permission([12, 13])) {
            $this->post['parent_id'] = $_SESSION['session_id'];
            if (in_array(level($_GET['route_id']), [2, 32])) {
                $this->post['grant_id'] = $_SESSION['session_id'];
            }
        }
        $this->post['id'] = $pk;
        $this->post['status'] = 2;
        $this->post['accept_date'] = date('Y-m-d H:i:s');
        $this->dd();
        $this->update();
    }

    public function success()
    {
        render();
        // header("location:/$PROJECT_NAME/views/doctor/$this->url");
        // exit;
    }

}

?>