<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once './httpful.phar';

class httprequestlib {
	var $ci;
	var $data = array();
	
	public function __construct() {		
		$this->ci = & get_instance();
	}

	private function __http_build_query_multi( $params ) {
		$output = array();
		$walk = function( $item, $key, $parent_key = '' ) use ( &$output, &$walk ) {
	
			is_array( $item )
			? array_walk( $item, $walk, $key )
			: $output[] = http_build_query( array( ( $parent_key ?  $parent_key . "[]" : $key ) => $item ) );
	
		};
		
		if ( is_array( $params ) ) {
			array_walk( $params, $walk );
		}
	
		return ( count( $output ) > 0 ) ? implode( '&', $output ) : "";
	}
	
	public function Get( $api, $params = array(), $errorCase = 0 ) {
		return $this->Request( 'get', $api, $params, $errorCase );
	}
	
	public function Post( $api, $params = array(), $errorCase = 0 ) {
		return $this->Request( 'post', $api, $params, $errorCase );		
	}
	
	public function Put( $api, $params = array(), $errorCase = 0 ) {
		return $this->Request( 'put', $api, $params, $errorCase );		
	}
	
	public function Delete( $api, $params = array(), $errorCase = 0 ) {
		return $this->Request( 'delete', $api, $params, $errorCase );		
	}
	
	public function Request( $func, $api, $params, $errorCase ) {
		$user_id = ( isset( $_SESSION['account'] ) ) ? $_SESSION['account']->id : 0;
		$response = \Httpful\Request::$func( $api )
									->addHeader( 'userid', $user_id )
									->sendsType(\Httpful\Mime::FORM)
									->body( $this->__http_build_query_multi( $params ) )
									->send();

		if ( $response->code == 200 ) {
			$body = json_decode( $response->body );
			if ( $body->error_code == 200 ) {
				$result = ( isset( $body->data ) ? $body->data : $body );
				$result->error_code = $body->error_code;
				$result->error_msg = ( isset( $body->error_msg ) ) ? $body->error_msg : "";
				return $result;
			} else {
				return $this->processError( $response, $errorCase );
			}
		} else {
			return $this->processError( $response, $errorCase );
		}
		
	}
	
	public function processError( $response, $errorCase ) {
		$result = array();
		$result['error_code'] = 0;
		$result['error_msg'] = "error";
		
		if ( $response->code == 200 ) {
			$body = json_decode( $response->body );
			$result['error_code'] = $body->error_code;
			$result['error_msg'] = ( isset( $body->error_msg ) ) ? $body->error_msg : "";
		} else {
			$result['error_code'] = $response->code;
		}
		
		switch ( $errorCase ) {
			case 0:	//redirect
				echo var_dump( $result );
				die();
				break;
			case 1:
				echo json_encode( $result );
				die();
				break;
			case 2:
				return (object)$result;
				break;
		}
	}

	public function Url_get_contents($Url) {
		if (!function_exists('curl_init')){
			die('CURL is not installed!');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);

        log_message("debug","[Url_get_contents][PATH] :" .$this->ci->router->fetch_class()." =>".$this->ci->router->fetch_method());
        log_message("debug","[Url_get_contents][URL] :" .$Url);
        log_message('debug',"[Url_get_contents][DATA] :". json_encode($output));
		return $output;
	}
}