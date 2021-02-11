<?php


    class GoodsModel extends Model
    {
        public $table = 'goods';

        public function form_template($pk = null)
        {
            ?>
            <form method="post" action="<?= add_url() ?>" onsubmit="//TempFunc()" enctype="multipart/form-data">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">

                <div class="form-group">
                    <label>Шаблон:</label>
                    <input type="file" class="form-control" name="template" required id="url_template">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-outline-primary">Сохранить</button>
                </div>

            </form>
            <?php
        }

        public function clean()
        {
            if($_FILES['template']){
                $this->post['template'] = read_excel($_FILES['template']['tmp_name']);
                $this->save_excel();
            }
            $this->post = Mixin\clean_form($this->post);
            $this->post = Mixin\to_null($this->post);
            if($this->post['user_level'] and !$this->post['division_id']){
                $this->post['division_id'] = null;
            }
            return True;
        }

        public function clean_excel()
        {
            // if ($this->post['user_level']) {
            //     switch ($this->post['user_level']) {
            //         case 'A':
            //             $this->post['user_level'] = 1;
            //             break;
            //         case 'B':
            //             $this->post['user_level'] = 5;
            //             break;
            //         case 'D':
            //             $this->post['user_level'] = 10;
            //             break;
            //         case 'L':
            //             $this->post['user_level'] = 6;
            //             break;
            //     }
            // }
            return True;
        }

        public function save_excel()
        {
            foreach ($this->post['template'] as $key_p => $value_p) {
                if ($key_p) {
                    foreach ($value_p as $key => $value) {
                        $pick = $pirst[$key];
                        // switch ($pick) {
                        //     case 'role':
                        //         $pick = "user_level";
                        //         break;
                        //     case 'service':
                        //         $pick = "name";
                        //         break;
                        // }
                        $this->post[$pick] = $value;
                    }
                    if($this->clean_excel()){
                        prit($this->post);
                        $object = Mixin\insert($this->table, $this->post);
                        if (!intval($object)){
                            $this->error($object);
                        }
                    }
                }else {
                    $pirst = $value_p;
                    unset($this->post['template']);
                }
            }
            $this->success();
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

    class ProductsModel extends Model
    {
        public $table = 'products';

        public function form_template($pk = null)
        {
            ?>
            <form method="post" action="<?= add_url() ?>" onsubmit="//TempFunc()" enctype="multipart/form-data">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">

                <div class="form-group">
                    <label>Шаблон:</label>
                    <input type="file" class="form-control" name="template" required id="url_template">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-outline-primary">Сохранить</button>
                </div>

            </form>
            <?php
        }

        public function clean()
        {
            if($_FILES['template']){
                $this->post['template'] = read_excel($_FILES['template']['tmp_name']);
                $this->save_excel();
            }
            $this->post = Mixin\clean_form($this->post);
            $this->post = Mixin\to_null($this->post);
            if($this->post['user_level'] and !$this->post['division_id']){
                $this->post['division_id'] = null;
            }
            return True;
        }

        public function clean_excel()
        {
            // if ($this->post['user_level']) {
            //     switch ($this->post['user_level']) {
            //         case 'A':
            //             $this->post['user_level'] = 1;
            //             break;
            //         case 'B':
            //             $this->post['user_level'] = 5;
            //             break;
            //         case 'D':
            //             $this->post['user_level'] = 10;
            //             break;
            //         case 'L':
            //             $this->post['user_level'] = 6;
            //             break;
            //     }
            // }
            return True;
        }

        public function save_excel()
        {
            foreach ($this->post['template'] as $key_p => $value_p) {
                if ($key_p) {
                    foreach ($value_p as $key => $value) {
                        $pick = $pirst[$key];
                        // switch ($pick) {
                        //     case 'role':
                        //         $pick = "user_level";
                        //         break;
                        //     case 'service':
                        //         $pick = "name";
                        //         break;
                        // }
                        $this->post[$pick] = $value;
                    }
                    if($this->clean_excel()){
                        prit($this->post);
                        // $this->stop();
                        $object = Mixin\insert($this->table, $this->post);
                        if (!intval($object)){
                            $this->error($object);
                        }
                    }
                }else {
                    $pirst = $value_p;
                    unset($this->post['template']);
                }
            }
            $this->success();
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

    class SupliersModel extends Model
    {
        public $table = 'supliers';

        public function form_template($pk = null)
        {
            ?>
            <form method="post" action="<?= add_url() ?>" onsubmit="//TempFunc()" enctype="multipart/form-data">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">

                <div class="form-group">
                    <label>Шаблон:</label>
                    <input type="file" class="form-control" name="template" required id="url_template">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-outline-primary">Сохранить</button>
                </div>

            </form>
            <?php
        }

        public function clean()
        {
            if($_FILES['template']){
                $this->post['template'] = read_excel($_FILES['template']['tmp_name']);
                $this->save_excel();
            }
            $this->post = Mixin\clean_form($this->post);
            $this->post = Mixin\to_null($this->post);
            if($this->post['user_level'] and !$this->post['division_id']){
                $this->post['division_id'] = null;
            }
            return True;
        }

        public function clean_excel()
        {
            // if ($this->post['user_level']) {
            //     switch ($this->post['user_level']) {
            //         case 'A':
            //             $this->post['user_level'] = 1;
            //             break;
            //         case 'B':
            //             $this->post['user_level'] = 5;
            //             break;
            //         case 'D':
            //             $this->post['user_level'] = 10;
            //             break;
            //         case 'L':
            //             $this->post['user_level'] = 6;
            //             break;
            //     }
            // }
            return True;
        }

        public function save_excel()
        {
            foreach ($this->post['template'] as $key_p => $value_p) {
                if ($key_p) {
                    foreach ($value_p as $key => $value) {
                        $pick = $pirst[$key];
                        // switch ($pick) {
                        //     case 'role':
                        //         $pick = "user_level";
                        //         break;
                        //     case 'service':
                        //         $pick = "name";
                        //         break;
                        // }
                        $this->post[$pick] = $value;
                    }
                    if($this->clean_excel()){
                        prit($this->post);
                        $object = Mixin\insert($this->table, $this->post);

                        // echo $object;

                        // $this->stop();
                        if (!intval($object)){
                            $this->error($object);
                        }
                    }
                }else {
                    $pirst = $value_p;
                    unset($this->post['template']);
                }
            }
            $this->success();
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
