<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class viewlib {
	var $ci;
	var $data = array();

	var $VIEW_ONLY_HEAD_FOOT = 0;
	var $VIEW_HEAD = 1;
	var $VIEW_FOOT = 2;
	var $VIEW_SUBHEAD = 4;
	var $VIEW_CURRENT_PATH = 1024;
	var $VIEW_NONE = 8192;
	
	public function __construct() {		
		$this->ci = & get_instance();
	}
	
	public function Output( $type, $data , $views = array() ) {

		if ( $type & $this->VIEW_HEAD ) {	//print head
			$this->ci->load->view( "/template/head", $data );
		}
		
		if ( $type & $this->VIEW_SUBHEAD ) {	//print subhead
			$this->ci->load->view( "/template/subhead" );
		}
		
		if ( $type & $this->VIEW_CURRENT_PATH ) {

			$class = $this->ci->router->fetch_class();
			$method = $this->ci->router->fetch_method();
			$this->ci->load->view( "/{$class}/{$method}", $data );

//            $log_data=$data;
//            $log_data['ci']='';
//            log_message("debug","[CURRENT_PATH][VIEW] : " .$class." =>".$method);
//            log_message("debug","[CURRENT_PATH][DATA] : " .json_encode($log_data));
        }
		
		foreach ( $views as $view ) {
			$this->ci->load->view( $view, $data );
		}

		if ( $type & $this->VIEW_FOOT ) {	//print foot
			$this->ci->load->view( "/template/foot" );
		}
	}
}