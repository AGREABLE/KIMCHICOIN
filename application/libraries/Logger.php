<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by IntelliJ IDEA.
 * User: philip
 * Date: 2016. 11. 27.
 * Time: 오전 2:17
 */
class logger  {

    var $ci;

    public function __construct() {
        $this->ci = & get_instance();
        $class = $this->ci->router->fetch_class();
        $method = $this->ci->router->fetch_method();

        log_message("debug","[Controllers][Logger]  : " .$class." =>".$method);
    }

    public function logger_info($message = null, array $arrData = null) {
        $msg = '';

        if ($arrData) {
            $msg .= 'input_post: ' . str_replace(array("\n", "\r", "    "), '', print_r($arrData, true));
        }

        $msg .= 'msg: ' . $message . ' ';

        log_message('info', $msg);
    }

    public function logger_debug(array $arrData = null ,$message = null ) {
        $msg = '';

        if ($arrData) {
            $msg .= 'input_post: ' . str_replace(array("\n", "\r", "    "), '', print_r($arrData, true));
        }
        if ($message) {
            $msg .= 'msg: ' . $message . ' ';
        }

        log_message('debug', $msg);
    }

    public function logger_error($message = null, array $arrData = null) {
        $msg = '';

        if ($arrData) {
            $msg .= 'input_post: ' . str_replace(array("\n", "\r", "    "), '', print_r($arrData, true));
        }

        if ($message) {
            $msg .= 'msg: ' . $message . ' ';
        }
        log_message('error', $msg);
    }

    /**
     * Logs exception to log file as 'error'
     * Requires $config['log_threshold'] to be >= 1 (application/config/config.php)
     * @param Exception $oException
     */
    public function logException(Exception $oException) {
        $strMessage = '';
        $strMessage .= $oException->getMessage() . ' ';
        $strMessage .= $oException->getCode() . ' ';
        $strMessage .= $oException->getFile() . ' ';
        $strMessage .= $oException->getLine();
        $strMessage .= "\n" .  $oException->getTraceAsString();

        log_message('error', $strMessage);
    }

}