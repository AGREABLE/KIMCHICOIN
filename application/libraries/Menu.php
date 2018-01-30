<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu {
	var $ci;
	var $data = array();
	var $list = array();
	var $current = array();
	var $accountType = 0;

	var $accountTypeData = array();

	var $ACCOUNT_SYSTEM_MANAGER = 99;
	var $ACCOUNT_PARTNER_BOSS = 50;
	var $ACCOUNT_PARTNER_STAFF = 1;
    var $ACCOUNT_NONE = 0;
	
	public function __construct() {		
		$this->ci = & get_instance();		
		date_default_timezone_set('Asia/Seoul');

		$path = explode( "/", explode( "?", $_SERVER['REQUEST_URI'] )[0] );
        array_shift( $path );

        $this->current[2]['v'] = strtolower( ( $this->ci->router->fetch_directory() ) ? str_replace("/", "", $this->ci->router->fetch_directory()) : "" );
		$this->current[0]['v'] = ( $this->current[2]['v'] == "" ) ? $path[0] : strtolower( $this->ci->router->fetch_class() );
		$this->current[1]['v'] = strtolower( $this->ci->router->fetch_method() );

		if ( isset( $_SESSION['account'] ) ) {
			$this->accountType = $_SESSION['account']->account_type;
		}

		$this->__setDefaultAccountData();
		$this->__setMenu();
		$this->__checkPermission();
	}
	
	private function __setDefaultAccountData() {
		$this->accountTypeData[$this->ACCOUNT_SYSTEM_MANAGER] = array( 'base_controller' => 'main' );
		$this->accountTypeData[$this->ACCOUNT_PARTNER_BOSS] = array( 'base_controller' => 'main' );
        $this->accountTypeData[$this->ACCOUNT_PARTNER_STAFF] = array( 'base_controller' => 'main' );
        $this->accountTypeData[$this->ACCOUNT_NONE] = array( 'base_controller' => 'main' );
	}
	
	private function __setMenu() {
		$this->list = array(
			//'Dashboard' => array( 'v' => 'dashboard', 'icon' => 'fa fa-dashboard', 'available_account_type' => array($this->ACCOUNT_SYSTEM_MANAGER, $this->ACCOUNT_PARTNER_BOSS), 'sub' => NULL, 'visible' => true ),
			'ALL' => array( 'v' => 'main', 'icon' => 'fa fa-user', 'available_account_type' => array($this->ACCOUNT_NONE, $this->ACCOUNT_PARTNER_STAFF, $this->ACCOUNT_PARTNER_BOSS, $this->ACCOUNT_SYSTEM_MANAGER), 'sub' => NULL, 'visible' => true )
            ,'BTC' => array( 'v' => 'btc', 'icon' => 'fa fa-user', 'available_account_type' => array($this->ACCOUNT_NONE, $this->ACCOUNT_PARTNER_STAFF, $this->ACCOUNT_PARTNER_BOSS, $this->ACCOUNT_SYSTEM_MANAGER), 'sub' => NULL, 'visible' => true )
            ,'ETH' => array( 'v' => 'eth', 'icon' => 'fa fa-user', 'available_account_type' => array($this->ACCOUNT_NONE, $this->ACCOUNT_PARTNER_STAFF, $this->ACCOUNT_PARTNER_BOSS, $this->ACCOUNT_SYSTEM_MANAGER), 'sub' => NULL, 'visible' => true )
            ,'XRP' => array( 'v' => 'xrp', 'icon' => 'fa fa-user', 'available_account_type' => array($this->ACCOUNT_NONE, $this->ACCOUNT_PARTNER_STAFF, $this->ACCOUNT_PARTNER_BOSS, $this->ACCOUNT_SYSTEM_MANAGER), 'sub' => NULL, 'visible' => true )
            ,'EOS' => array( 'v' => 'eos', 'icon' => 'fa fa-user', 'available_account_type' => array($this->ACCOUNT_NONE, $this->ACCOUNT_PARTNER_STAFF, $this->ACCOUNT_PARTNER_BOSS, $this->ACCOUNT_SYSTEM_MANAGER), 'sub' => NULL, 'visible' => true )
            ,'SNT' => array( 'v' => 'snt', 'icon' => 'fa fa-user', 'available_account_type' => array($this->ACCOUNT_NONE, $this->ACCOUNT_PARTNER_STAFF, $this->ACCOUNT_PARTNER_BOSS, $this->ACCOUNT_SYSTEM_MANAGER), 'sub' => NULL, 'visible' => true )
            ,'ADA' => array( 'v' => 'ada', 'icon' => 'fa fa-user', 'available_account_type' => array($this->ACCOUNT_NONE, $this->ACCOUNT_PARTNER_STAFF, $this->ACCOUNT_PARTNER_BOSS, $this->ACCOUNT_SYSTEM_MANAGER), 'sub' => NULL, 'visible' => true )
            ,'ADMINNEWS' => array( 'v' => 'adminnews', 'icon' => 'fa fa-user', 'available_account_type' => array($this->ACCOUNT_SYSTEM_MANAGER), 'sub' => NULL, 'visible' => true )
		);
		
		foreach ( $this->list as $mainMenuName => $mainMenu ) {
			if ( $mainMenu['v'] == $this->current[0]['v'] ) {
				$this->current[0]['name'] = $mainMenuName;
				if ( $mainMenu['sub'] != NULL ) {
					foreach ( $mainMenu['sub'] as $subMenuName => $subMenu ) {
						if ( $subMenu['v'] == $this->current[1]['v'] ) {
							$this->current[1]['name'] = $subMenuName;
							break;
						}
					}
				}
				break;
			}
		}
	}
	
	private function __isAvailableMenu() {
		$isAvailable = false;
		foreach ( $this->list as $mainMenu ) {
			if ( $mainMenu['v'] == $this->current[0]['v'] && in_array( $this->accountType, $mainMenu['available_account_type'] ) ) {
				$isAvailable = true;
				if ( $mainMenu['sub'] != NULL ) {
					foreach ( $mainMenu['sub'] as $subMenu ) {
						if ( $subMenu['v'] == $this->current[1]['v'] && !in_array( $this->accountType, $subMenu['available_account_type'] ) ) {
							$isAvailable = false;
							break;
						}
					}
				}
				break;
			}
		}
		
		$ignoreClass = array(	//로그인 후 사용자타입마다 권한 무시한 class
				$this->ACCOUNT_SYSTEM_MANAGER => array( ),
				$this->ACCOUNT_PARTNER_BOSS => array( ),
				$this->ACCOUNT_PARTNER_STAFF=> array(),
                $this->ACCOUNT_NONE=> array( )
		);
		
		if ( in_array( $this->current[0]['v'], $ignoreClass[$this->accountType] ) ) {
			$isAvailable = true;
		}
		
		return $isAvailable;
	}
	
	private function __checkPermission() {		
		$ignoreDir = array();
        $ignoreClass = array();
		if ( !in_array( $this->current[2]['v'], $ignoreDir ) ) {	
			if ( !in_array( $this->current[0]['v'], $ignoreClass ) ) {
				if ( !$this->__isAvailableMenu() ) {
					redirect( "/{$this->accountTypeData[$this->accountType]['base_controller']}" );
				}
			}
		}
	}
	
	public function SetSubMenu( $v, $name ) {
		$this->current[1]['v'] = $v;
		$this->current[1]['name'] = $name;
	}
	
	public function CheckPermission( $superTypes, $availableTypes = array(), $availableAccountId = 0 ) {
		if ( in_array( $this->accountType, $superTypes ) ) {
			return true;
		} else if ( in_array( $this->accountType, $availableTypes ) ) {
			if ( !$availableAccountId || $_SESSION['account']->id == $availableAccountId ) {
				return true;
			}
		}
		return false;
	}
}