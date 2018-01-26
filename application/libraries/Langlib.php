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
                $this->DB_SELECT['BOARD'] = "title_kr as _title, contents_kr as _contents";
                $this->DB_SELECT['COMMENT'] = "contents_kr as _contents";
                break;
            default :
                $this->DB_SELECT['BOARD'] = "title as _title, contents as _contents";
                $this->DB_SELECT['COMMENT'] = "contents as _contents";
                break;
        }
        $this->DB_SELECT['BOARD'] = "title as _title, contents as _contents";
        $this->DB_SELECT['COMMENT'] = "contents as _contents";
    }
}