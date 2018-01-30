<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class langlib
{
    var $ci;
    var $DB_SELECT = array();

    public function __construct()
    {
        $this->ci = &get_instance();

        $language = ( isset( $_COOKIE['lang'] ) ) ? $_COOKIE['lang'] : substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        switch ( $language ) {
            case "ko":
                $this->DB_SELECT['BOARD'] = "IF( title_kr = '' OR title_kr IS NULL, title, title_kr ) as _title, IF( contents_kr = '' OR contents_kr IS NULL, contents, contents_kr ) as _contents";
                $this->DB_SELECT['COMMENT'] = "IF( contents_kr = '' OR contents_kr IS NULL, contents, contents_kr ) as _contents";
                break;
            default :
                $this->DB_SELECT['BOARD'] = "title as _title, contents as _contents";
                $this->DB_SELECT['COMMENT'] = "contents as _contents";
                break;
        }
        $this->DB_SELECT['BOARD'] .= ", UNIX_TIMESTAMP(created_at) as create_timestamp";
        $this->DB_SELECT['COMMENT'] .= ", UNIX_TIMESTAMP(created_at) as create_timestamp";

        //$this->DB_SELECT['BOARD'] = "title as _title, contents as _contents";
        //$this->DB_SELECT['COMMENT'] = "contents as _contents";
    }
}