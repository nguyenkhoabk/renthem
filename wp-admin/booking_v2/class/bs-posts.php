<?php
class BS_POSTS extends database {

    public $db_table = "posts";

    function __construct()
    {
        global $wpdb;
        $this->db_table = $wpdb->prefix . $this->db_table;
    }

    function getPosts($fields = "", $where = "", $order = "")
    {
        return $this->select($this->db_table, $fields, $where, $order);
    }
}
