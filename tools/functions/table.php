<?php

class Table
{
    // database handle
    private $db;
    private $limit;
    private $data = "*";
    private $firstBack;
    private $nextLast;
    private $additions;
    private $where;
    private $order_by;
    public $table;

    public function __construct($db, $table) {
        $this->db = $db;
        $this->table = $table;
    }

    public function set_limit(Int $limit = null)
    {
        $this->limit = $limit;
        $this->generate_sql();
        $this->total_pages = ceil($this->db->query($this->sql)->rowCount() / $this->limit);
    }

    public function set_data(String $data = null)
    {
        $this->data = $data;
    }

    public function additions(String $additions = null)
    {
        $this->additions = $additions;
    }

    public function where($where = null)
    {
        $this->where = $where;
    }

    public function order_by($order_by = null)
    {
        $this->order_by = $order_by;
    }

    public function generate_sql()
    {
        $this->sql = "SELECT $this->data FROM $this->table";
        if($this->additions) $this->sql .= " ".$this->additions;
        if($this->where) $this->sql .= " WHERE ".$this->where;
        if($this->order_by) $this->sql .= " ORDER BY ".$this->order_by;
        return 1;
    }

    public function get_table()
    {
        $this->generate_sql();
        $page =  (int)(isset($_GET['table_page'])) ? $_GET['table_page'] : $page = 1;
        $offset = $this->limit * ($page - 1);
        $this->sql .= " LIMIT $this->limit OFFSET $offset";

        return $this->db->query($this->sql)->fetchAll();
    }

    private function create_panel($page)
    {
        $this->self = "";
        $self_uri = $this->gen_self();

        if ($page > 1) {
            $prev_page = $page -1;
            $this->firstBack = "<li class=\"page-item\"><a href=\"$self_uri?table_page=$prev_page\" class=\"page-link\">&larr; &nbsp; Prev</a></li>";
        }

        if ($page <= floor($this->total_pages / 2)) {
            $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri?table_page=$page\" class=\"page-link\">$page</a></li>";
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri?table_page=".($page+1)."\" class=\"page-link\">".($page+1)."</a></li>";
        }else {
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri?table_page=1\" class=\"page-link\">1</a></li>";
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri?table_page=2\" class=\"page-link\">2</a></li>";
        }

        // center
        if ($page <= floor($this->total_pages / 2)) {
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri?table_page=".floor(($this->total_pages+$page)/2)."\" class=\"page-link\">...</a></li>";
        }else {
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri?table_page=".floor(($page)/2)."\" class=\"page-link\">...</a></li>";
        }

        if ($page >= floor($this->total_pages / 2)) {
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri?table_page=".($page-1)."\" class=\"page-link\">".($page-1)."</a></li>";
            $this->self .= "<li class=\"page-item active\"><a href=\"$self_uri?table_page=$page\" class=\"page-link\">$page</a></li>";
        }else {
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri?table_page=".($this->total_pages-1)."\" class=\"page-link\">".($this->total_pages-1)."</a></li>";
            $this->self .= "<li class=\"page-item\"><a href=\"$self_uri?table_page=$this->total_pages\" class=\"page-link\">$this->total_pages</a></li>";
        }

        if ($page < $this->total_pages) {
            $next_page = $page + 1;
            $this->nextLast =  "<li class=\"page-item\"><a href=\"$self_uri?table_page=$next_page\" class=\"page-link\">Next &nbsp; &rarr;</a></li>";
        }

        return $this->firstBack.$this->self.$this->nextLast;
    }

    public function get_panel()
    {
        if ($this->total_pages <= 1) {
            return 0;
        }
        $page =  (int)(isset($_GET['table_page'])) ? $_GET['table_page'] : $page = 1;

        if ($page > $this->total_pages) {
            $page = $this->total_pages;
        } elseif ($page < 1) {
            $page = 1;
        }

        // echo "<div class=\"card card-body border-top-1 border-top-pink text-center\">";
        // echo "  <ul class=\"pagination pagination-flat pagination-rounded align-self-center mt-3\" >";
        echo "  <ul class=\"pagination pagination-flat pagination-rounded align-self-center justify-content-center mt-3\" >";
        echo $this->create_panel($page);
        echo "  </ul>";
        // echo "</div>";
        /*
        <div class="card card-body border-top-1 border-top-pink text-center">

            <ul class="pagination pagination-flat pagination-rounded align-self-center">
                <li class="page-item"><a href="#" class="page-link">&larr; &nbsp; Prev</a></li>
                <li class="page-item active"><a href="#" class="page-link">1</a></li>
                <li class="page-item"><a href="#" class="page-link">2</a></li>
                <li class="page-item disabled"><a href="#" class="page-link">3</a></li>
                <li class="page-item"><a href="#" class="page-link">4</a></li>
                <li class="page-item"><a href="#" class="page-link">Next &nbsp; &rarr;</a></li>
            </ul>

        </div>
        */
    }

    public function gen_self()
    {
        $uri = $_SERVER['PHP_SELF'];
        if (EXT != ".php") {
            $uri = str_replace('.php', '', $_SERVER['PHP_SELF']);
        }
        return $uri;
    }


}

?>