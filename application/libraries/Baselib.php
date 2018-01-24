<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class baselib {
	var $ci;
	var $data = array();
	var $DAY_OF_THE_WEEK = array("일", "월", "화", "수", "목", "금", "토");
	var $telPrefix = array( "02", "031", "032", "033", "041", "042", "043", "044", "051", "052", "053", "054", "055", "061", "062", "063", 
			"064", "0502", "0503", "0504", "0505", "0506", "0507", "070", "010", "011", "016", "017", "018", "019" );
	var $phonePrefix = array( "010", "011", "016", "017", "018", "019" );
	var $mailDomain = array( "naver.com", "hotmail.com", "hanmail.net", "yahoo.co.kr", "paran.com", "nate.com", "empal.com", "dreamwiz.com", 
			"hanafos.com", "korea.com", "chol.com", "gmail.com", "lycos.co.kr", "netian.com", "hanmir.com", "sayclub.com" );
	var $ALPHABAT= array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	
	var $errorMsg = array();
	
	public function __construct() {		
		$this->ci = & get_instance();
		$this->__setErrorMsg();

		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
	}
	
	private function __setErrorMsg() {
		$this->errorMsg[4] = "입력하신 정보가 부족합니다.";
		$this->errorMsg[101] = "가입되어있는 이메일주소 입니다.";
		$this->errorMsg[102] = "이메일 형식에 맞지 않습니다.";
		$this->errorMsg[200] = "완료되었습니다.";
		$this->errorMsg[400] = "데이터가 없습니다.";
		$this->errorMsg[601] = "입력정보를 확인해주세요.";
		$this->errorMsg[1000] = "옳바르지 않은 데이터를 입력하였습니다.";
		$this->errorMsg[2001] = "진행중인 내역이 있습니다.";
		$this->errorMsg[2002] = "통화 녹음 파일을 선택해주세요.";
        $this->errorMsg[4000] = "권한이 없습니다.";
        $this->errorMsg[6001] = "고객사 사용자로 등록된 이메일 입니다.";
        $this->errorMsg[6002] = "이미 등록된 고객사 입니다.";
        $this->errorMsg[8000] = "서버 에러";
        $this->errorMsg[8900] = "처리할 수 없는 요청입니다.";
        $this->errorMsg[9000] = "에러가 발생하였습니다. 계속 발생할 경우 매니저에게 문의해주세요.";
	}
	
	public function InputGetPost( $fieldname, $initValue = false, $error_code = false ) {
		$value = $this->ci->input->get_post( $fieldname );
		if ( $value == NULL || $value === false ) {
			if ( $error_code ) {
				$this->PrintResultAndMessage( $error_code );
			}
			$value = $initValue;
		}
		
		return $value;
	}
	
	public function PrintResultAndMessage($error_code = 0, $error_msg = "", $data = array(), $version = "1.0")
	{
		if  ( !$error_msg && isset( $this->errorMsg[$error_code] ) ) {
			$error_msg = $this->errorMsg[$error_code];
		}
		$r = json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'data' => $data, 'version' => $version), JSON_NUMERIC_CHECK);
		echo($r);
		die();
	}

	public function AlertByJS( $message, $url = false, $error_code = 0 ) {
		if ( $message == "" && $error_code > 0 ) {
			$message = $this->errorMsg[$error_code];
		}
		
		if ( $url ) {
			if ( $message == "" )
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><script>window.location='{$url}';</script>";
			else
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><script>alert('{$message}');window.location='{$url}';</script>";
		}
		else {
			if ( $message == "" ) 
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />window.history.back();</script>";
			else
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><script>alert('{$message}');window.history.back();</script>";
		}
		die();
	}
	
	public function GetDayOfWeek( $date ) {
		$DAY_OF_THE_WEEK = array("일", "월", "화", "수", "목", "금", "토");
		return $DAY_OF_THE_WEEK[ date('w', strtotime( $date ) ) ];
	}
	
	public function GetRandomString($length, $type)
	{
		switch($type){
			case 0:
				$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
				break;
			case 1:
				$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				break;
			case 2:
				$chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
				break;
			case 3:
				$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 4:
				$chars = 'abcdefghijklmnopqrstuvwxyz';
				break;
			case 5:
				$chars = '1234567890';
				break;
			default:
				return false;
		}
		$chars_length = (strlen($chars) - 1);
		$string = '';
		for ($i = 0; $i < $length; $i = strlen($string)){
			$string .= $chars{rand(0, $chars_length)};
		}
		return $string;
	}
	
	public function Pagination( $offset, $limit, $total_count ) {
		$showingPageCnt = 5;
		
		$s = $offset + 1;
		$e = ( $offset + $limit < $total_count ) ? $offset + $limit : $total_count - $offset;
		
		$current = ( $offset / $limit ) + 1;
		$spage = (int)( ( $current - 1 ) / $showingPageCnt ) * $showingPageCnt + 1;
		$leftpage = ( $current <= $showingPageCnt ) ? false : (int)( ( $current -  1 ) / $showingPageCnt ) * $showingPageCnt;
		$sspage = ( $spage == 1 ) ? false : 1;
		$last = ( (int)( ( $total_count - 1 ) / $limit ) + 1 );
		$epage = ( ( $spage + ( $showingPageCnt - 1 ) ) < $last ) ? ( $spage + ( $showingPageCnt - 1 ) ) : $last;
		$rightpage = ( $epage == $last ) ? false : (int)( ( $current +  ( $showingPageCnt - 1 ) ) / $showingPageCnt ) * $showingPageCnt + 1;
		$eepage = ( $epage == $last ) ? false : $last;
		
		$pagination = ""
			//. "<p class='widget-email-count'>Showing {$s} - {$e} of {$total_count} items</p>"
			. "<ul class='pagination pagination-sm widget-email-pagination pagination-link'>";
		
		if ( $leftpage ) {
			$pagination .= "<li class='prev' data-page='{$leftpage}'><a><i class='fa fa-chevron-left'></i></a></li>";
		} else {
			$pagination .= "<li class='prev disabled'><a><i class='fa fa-chevron-left'></i></a></li>";
		}
		
		for ( $i = $spage; $i <= $epage; $i++ ) {
			if ( $i == $current ) {
				$pagination .= "<li class='prev active'><a>{$i}</a></li>";
			} else {
				$pagination .= "<li class='prev' data-page='{$i}'><a>{$i}</a></li>";
			}
		}
		
		if ( $rightpage ) {
			$pagination .= "<li class='prev' data-page='{$rightpage}'><a><i class='fa fa-chevron-right'></i></a></li>";
		} else {
			$pagination .= "<li class='prev disabled'><a><i class='fa fa-chevron-right'></i></a></li>";
		}
		
		$pagination .= "</ul>";
		
		return $pagination;
	}
	
	public function PaginationScript( $offset, $limit, $total_count, $params ) {
		$showingPageCnt = 5;
		
		$s = $offset + 1;
		$e = ( $offset + $limit <= $total_count ) ? $offset + $limit : $total_count - $offset;
		
		$current = ( $offset / $limit ) + 1;
		$spage = (int)( ( $current - 1 ) / $showingPageCnt ) * $showingPageCnt + 1;
		$leftpage = ( $current <= $showingPageCnt ) ? false : (int)( ( $current -  1 ) / $showingPageCnt ) * $showingPageCnt;
		$sspage = ( $spage == 1 ) ? false : 1;
		$last = ( (int)( ( $total_count - 1 ) / $limit ) + 1 );
		$epage = ( ( $spage + ( $showingPageCnt - 1 ) ) < $last ) ? ( $spage + ( $showingPageCnt - 1 ) ) : $last;
		$rightpage = ( $epage == $last ) ? false : (int)( ( $current +  ( $showingPageCnt - 1 ) ) / $showingPageCnt ) * $showingPageCnt + 1;
		$eepage = ( $epage == $last ) ? false : $last;
		
		$pagination = ""
			. "<p class='widget-email-count'>Showing {$s} - {$e} of {$total_count} items</p>
					<ul class='pagination pagination-sm widget-email-pagination pagination-func'>";
		
		if ( $leftpage ) {
			$params['offset'] = $limit * ( $leftpage - 1 );
			$p = json_encode( $params );
			$pagination .= "<li class='prev' onClick='getList({$p})'><a><i class='fa fa-chevron-left'></i></a></li>";
		} else {
			$pagination .= "<li class='prev disabled'><a><i class='fa fa-chevron-left'></i></a></li>";
		}
		
		for ( $i = $spage; $i <= $epage; $i++ ) {
			if ( $i == $current ) {
				$pagination .= "<li class='prev active'><a>{$i}</a></li>";
			} else {
				$params['offset'] = $limit * ( $i - 1 );
				$p = json_encode( $params );
				$pagination .= "<li class='prev' onClick='getList({$p})'><a>{$i}</a></li>";
			}
		}
		
		if ( $rightpage ) {
			$params['offset'] = $limit * ( $rightpage - 1 );
			$p = json_encode( $params );
			$pagination .= "<li class='prev' onClick='getList({$p})'><a><i class='fa fa-chevron-right'></i></a></li>";
		} else {
			$pagination .= "<li class='prev disabled'><a><i class='fa fa-chevron-right'></i></a></li>";
		}
		
		$pagination .= "</ul>";
		
		return $pagination;
	}
	
	public function Thumbnail($url, $filename, $width = 150, $height = true) {
	
		// download and create gd image
		$image = ImageCreateFromString(file_get_contents($url));
	
		// calculate resized ratio
		// Note: if $height is set to TRUE then we automatically calculate the height based on the ratio
		$height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;
	
		// create image
		$output = ImageCreateTrueColor($width, $height);
		ImageCopyResampled($output, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));

		// save image
		if ( exif_imagetype( $url ) == IMAGETYPE_JPEG ) {
			ImageJPEG($output, $filename);
		} else if ( exif_imagetype( $url ) == IMAGETYPE_PNG ) {
			imagepng($output, $filename);
		} else {
			return false;
		}
	
		// return resized image
		return $output; // if you need to use it
	}

	public function GetDomain() {
		$url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
		$url .= ( $_SERVER["SERVER_PORT"] !== 80 && $_SERVER["SERVER_PORT"] !== "80" ) ? ":".$_SERVER["SERVER_PORT"] : "";
		return $url;
	}
	
	public function CalcTime( $time ) {
		$t = time() - strtotime( $time );
		
		if ( $t < 60 * 60 ) {
			return (int)( $t / 60 ) . "분전";
		} else if ( $t < 60 * 60 * 24 ) {
			return (int)( $t / ( 60 * 60 ) ) . "시간전";
		} else if ( $t < 60 * 60 * 24 * 31 ) {
			return (int)( $t / ( 60 * 60 * 24 ) ) . "일전";
		} else {
			return date( 'Y년 m월 d일', strtotime( $time ) );
		}
	}
	
	public function GetParams( $keyValues ) {
		$params = array();
		foreach ( $keyValues as $keyValue ) {
			$key = $keyValue['key'];
			$value = $keyValue['value'];
			$params[$key] = ( isset( $_REQUEST[$key] ) ) ? $_REQUEST[$key] : $value;
		}
		return $params;
	}
	
	public function AlertMissingParamsByPopup( $name, $msg = "입력정보가 부족합니다." ) {
		echo "<html>
				<head>
					<meta charset='utf-8'>
					<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js\"></script>
					<script>
					$(document).ready( function() {
						window.opener.$('.border-bold').removeClass( 'border-bold' );
						window.opener.$('input[name=\"{$name}\"]').addClass( 'required' );
						window.opener.$('input[name=\"{$name}\"]').addClass( 'border-bold' );
						window.opener.$('input[name=\"{$name}\"]').focus();
						window.opener.alert( '{$msg}' );
						window.close();
					});
					</script>
				</head>
			</html>";
		die();
	}
	
	public function GetRequiredParams( $names, $showAlert = false ) {
		$params = array();
		for ( $i = 0; $i < count( $names ); $i++ ) {
			if ( ( isset( $_REQUEST[$names[$i]] ) &&  $_REQUEST[$names[$i]] != "" ) &&
				( !is_array( $_REQUEST[$names[$i]] ) || ( is_array( $_REQUEST[$names[$i]] ) && count( $_REQUEST[$names[$i]] ) ) ) ) {
				$params[$names[$i]] = $_REQUEST[$names[$i]];
			} else {
			    if ( $showAlert ) {
			        $this->AlertMissingParamsByPopup( $names[$i] );
                } else {
                    $this->PrintResultAndMessage(4, "", array( $names[$i] ));
                }
			}
		}
		return $params;
	}

    public function GetStrsBetween($s,$s1,$s2=false,$offset=0) {
        /*====================================================================
         Function to scan a string for items encapsulated within a pair of tags

         getStrsBetween(string, tag1, <tag2>, <offset>

         If no second tag is specified, then match between identical tags

         Returns an array indexed with the encapsulated text, which is in turn
         a sub-array, containing the position of each item.

         Notes:
         strpos($needle,$haystack,$offset)
         substr($string,$start,$length)

         ====================================================================*/

        if( $s2 === false ) { $s2 = $s1; }
        $result = array();
        $L1 = strlen($s1);
        $L2 = strlen($s2);

        if( $L1==0 || $L2==0 ) {
            return false;
        }

        do {
            $pos1 = strpos($s,$s1,$offset);

            if( $pos1 !== false ) {
                $pos1 += $L1;

                $pos2 = strpos($s,$s2,$pos1);

                if( $pos2 !== false ) {
                    $key_len = $pos2 - $pos1;

                    $this_key = substr($s,$pos1,$key_len);

                    if( !array_key_exists($this_key,$result) ) {
                        $result[$this_key] = array();
                    }

                    $result[$this_key][] = $pos1;

                    $offset = $pos2 + $L2;
                } else {
                    $pos1 = false;
                }
            }
        } while($pos1 !== false );

        return $result;
    }

    public function GetFirstKeyInArray( $array ) {
        if ( is_array( $array ) ) {
            reset( $array );
            return key( $array );
        }
        return false;
    }

	public function IsJSON( $string ){
		return is_string($string) && is_array(json_decode($string, true)) ? true : false;
	}
	
	public function HttpPost( $url, $post_data = array(), $header = array() ) {
		$result = array();
		
		$curlsession = curl_init ();
		curl_setopt ($curlsession, CURLOPT_URL, $url);
		curl_setopt ($curlsession, CURLOPT_POST, 1);
		curl_setopt ($curlsession, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt ($curlsession, CURLOPT_RETURNTRANSFER, 1);
		if ( $header ) {
			curl_setopt( $curlsession, CURLOPT_HTTPHEADER, $header );
		}
		curl_setopt( $curlsession, CURLOPT_HEADER, 1 );
		$response = curl_exec ($curlsession);
		$result['header'] = substr( $response, 0, curl_getinfo( $curlsession, CURLINFO_HEADER_SIZE ) );
		$result['res'] = substr( $response, curl_getinfo( $curlsession, CURLINFO_HEADER_SIZE ) );
		
		$result['errno'] = curl_errno($curlsession); //에러정보 출력
		$result['error'] = curl_error($curlsession); //에러정보 출력
		
		curl_close($curlsession);
		
		return $result;
	}
	
	public function HttpGet( $url, $header = array() ) {
		$result = array();
		
		$curlsession = curl_init ();
		curl_setopt ($curlsession, CURLOPT_URL, $url);
		curl_setopt ($curlsession, CURLOPT_RETURNTRANSFER, 1);
		if ( $header ) {
			curl_setopt( $curlsession, CURLOPT_HTTPHEADER, $header );
		}
		curl_setopt( $curlsession, CURLOPT_HEADER, 1 );
		$response = curl_exec ($curlsession);
		$result['header'] = substr( $response, 0, curl_getinfo( $curlsession, CURLINFO_HEADER_SIZE ) );
		$result['res'] = substr( $response, curl_getinfo( $curlsession, CURLINFO_HEADER_SIZE ) );
		
		$result['errno'] = curl_errno($curlsession); //에러정보 출력
		$result['error'] = curl_error($curlsession); //에러정보 출력
		
		curl_close($curlsession);
		
		return $result;
	}

	public function GetDataFromApiResponse( $result, $msg1, $msg2 ) {
        if ( $result['errno'] || !$this->IsJSON( $result['res'] ) ) {
            $this->PrintResultAndMessage( 8000, $msg1, $result );
        }
        $result = json_decode( $result['res'], true );
        if ( $result['error_code'] != 200 ) {
            $this->PrintResultAndMessage( 8000, $msg2, $result );
        }

        return $result['data'];
    }
	
	public function SendSms( $recipients, $msg ) {
		$sender = "07079187052";
		$recipients = str_replace( "-", "", str_replace( " ", "", $recipients ) );
		
		$username = "isili";
		$key = "AREfnZjgjZpQEcy";
		
		/* Server의 인코딩이 utf-8일때 다음 구문을 사용하세요*/
		/* UTF-8 */
		$message = base64_encode(iconv("utf-8", "euc-kr", $msg));
		
		/* Server의 인코딩이 euc-kr일때 사용하세요. */
		/* EUC-KR  */
		//$message = base64_encode($message);
		
		$postvars = "message=" . urlencode($message)
		. "&sender=" . urlencode($sender)
		. "&username=" . urlencode($username)
		. "&recipients=" . urlencode($recipients)
		. "&key=" . urlencode($key);
		
		
		$url = "https://directsend.co.kr/index.php/api/v1/sms";
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		$response = curl_exec($ch);
		curl_close ($ch);
		
		/*
		 * response의 실패
		 *  {"status":101}
		 */
		
		/*
		 * response 성공
		 * {"status":0}
		 * 성공 코드번호.
		 */
		
		/*
		 ** status code
		 0   : 정상발송
		 100 : POST validation 실패
		 101 : sender 유효한 번호가 아님
		 102 : recipient 유효한 번호가 아님
		 103 : api key or user is invalid
		 104 : recipient count = 0
		 105 : message length = 0
		 106 : message validation 실패
		 205 : 잔액부족
		 999 : Internal Error.
		 **
		 */
		
		$data = json_decode( $response );

		if ( $data->status == 0 ) {
			return true;
		} else {
			return false;
		}
	}
}