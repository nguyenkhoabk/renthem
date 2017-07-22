<?php
class BS_POST_META extends database {
    public $db_table = "postmeta";

    function __construct()
    {
        global $wpdb;
        $this->db_table = $wpdb->prefix . $this->db_table;
    }

    function getPostMeta($fields = "", $where = "", $order = "")
    {
        return $this->select($this->db_table, $fields, $where, $order);
    }

    function getPostThumbnailId( $post_id )
    {
        return $this->getPostMeta( 'meta_value', "meta_key='_thumbnail_id' AND post_id=" . $post_id );
    }

    function getThePostThumbnail( $post_id )
    {
        $thumbnail_id = $this->getPostThumbnailId( $post_id )[0]['meta_value'];
        $post2 = new BS_POSTS();
        $thumbnail = $post2->getPosts( 'guid', 'id=' . $thumbnail_id );
        return $thumbnail[0]['guid'];
    }
}
