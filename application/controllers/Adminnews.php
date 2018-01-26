<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminnews extends CI_Controller
{
    var $data = array();
    var $boardType = 1;

    public function __construct()
    {
        parent::__construct();

        $this->data['ci'] = $this;
        $this->data['cname'] = $this->router->fetch_class();
        $this->data['boardType'] = $this->boardType;
    }

    public function index()
    {
        $this->data['params'] = $this->baselib->GetParams(
            array(
                array( 'key' => 'limit', 'value' => 15 )
                , array( 'key' => 'per_page', 'value' => 0 )
            )
        );
        $this->data['params']['offset'] = $this->data['params']['per_page'];
        unset( $this->data['params']['per_page'] );

        $query = "SELECT count(*) as cnt FROM BOARD";
        $data['total'] = $this->db->query( $query )->row()->cnt;

        $query = "SELECT * FROM BOARD ORDER BY created_at DESC LIMIT {$this->data['params']['offset']}, {$this->data['params']['limit']}";
        $data['lists'] = $this->db->query( $query )->result();

        $this->data['data'] = (object)$data;

        $url_str = http_build_query($this->data['params']);
        $paging = array();
        $paging["base_url"]				= "{$this->baselib->GetDomain()}/{$this->data['cname']}?{$url_str}";
        $paging["total_rows"]			= $data['total'];
        $paging["per_page"]				= $this->data['params']['limit'];

        $paging["uri_segment"]			= 3;

        $this->pagination->initialize($paging);
        $this->data['pagination'] = $this->pagination->create_links();

        $this->viewlib->Output( $this->viewlib->VIEW_HEAD | $this->viewlib->VIEW_FOOT | $this->viewlib->VIEW_SUBHEAD | $this->viewlib->VIEW_CURRENT_PATH
            , $this->data );
    }

    public function ajaxUpdateIsRelease() {
        if ( !$this->menu->CheckPermission( array( $this->menu->ACCOUNT_SYSTEM_MANAGER ), array() ) ) {
            $this->baselib->PrintResultAndMessage(4000, "");
        }

        $this->data['params'] = $this->baselib->GetRequiredParams( array( 'source', 'external_key', 'is_release' ) );
        $this->db->where( 'source', $this->data['params']['source'] )->where( 'external_key', $this->data['params']['external_key'] )
            ->set( 'is_release', $this->data['params']['is_release'] )->update( 'BOARD' );

        $this->baselib->PrintResultAndMessage( 200 );
    }

    public function modify( $source = false, $external_key = false ) {
        if ( !$this->menu->CheckPermission( array( $this->menu->ACCOUNT_SYSTEM_MANAGER ), array() ) ) {
            $this->baselib->AlertByJS( "잘못된 접근입니다." );
        }

        $this->data['one'] = $this->connector_m->get( 'BOARD', array( 'source' => $source, 'external_key' => $external_key ) );

        $this->viewlib->Output( $this->viewlib->VIEW_HEAD | $this->viewlib->VIEW_FOOT | $this->viewlib->VIEW_SUBHEAD | $this->viewlib->VIEW_CURRENT_PATH
            , $this->data );
    }

    public function update() {
        if (!$this->menu->CheckPermission(array($this->menu->ACCOUNT_SYSTEM_MANAGER), array())) {
            $this->baselib->PrintResultAndMessage(4000, "");
        }
        $keys = $this->baselib->GetRequiredParams( array( "source", "external_key" ) );
        $params = $this->baselib->GetParams(
            array(
                array( 'key' => "title", 'value' => "" )
                , array( 'key' => "contents", 'value' => "" )
                , array( 'key' => "title_kr", 'value' => "" )
                , array( 'key' => "contents_kr", 'value' => "" )
                , array( 'key' => "link", 'value' => "" )
                , array( 'key' => "is_release", 'value' => "D" )
                , array( 'key' => 'currency', 'value' => "" )
                , array( 'key' => 'img', 'value' => "" )
                , array( 'key' => 'duedate', 'value' => "" )
            )
        );

        $this->db->where( 'source', $keys['source'] )->where( 'external_key', $keys['external_key'] )->update( 'BOARD', $params );

        $this->baselib->PrintResultAndMessage( 200, "수정되었습니다." );
    }

    public function add() {
        if ( !$this->menu->CheckPermission( array( $this->menu->ACCOUNT_SYSTEM_MANAGER ), array() ) ) {
            $this->baselib->AlertByJS( "잘못된 접근입니다." );
        }

        $this->viewlib->Output( $this->viewlib->VIEW_HEAD | $this->viewlib->VIEW_FOOT | $this->viewlib->VIEW_SUBHEAD | $this->viewlib->VIEW_CURRENT_PATH
            , $this->data );
    }

    public function write() {
        if (!$this->menu->CheckPermission(array($this->menu->ACCOUNT_SYSTEM_MANAGER), array())) {
            $this->baselib->PrintResultAndMessage(4000, "");
        }
        $params = array_merge( $this->baselib->GetRequiredParams( array( "source", "external_key" ) )
                            , $this->baselib->GetParams(
                                array(
                                    array( 'key' => "title", 'value' => "" )
                                    , array( 'key' => "contents", 'value' => "" )
                                    , array( 'key' => "title_kr", 'value' => "" )
                                    , array( 'key' => "contents_kr", 'value' => "" )
                                    , array( 'key' => "link", 'value' => "" )
                                    , array( 'key' => "is_release", 'value' => "D" )
                                    , array( 'key' => 'currency', 'value' => "" )
                                    , array( 'key' => 'img', 'value' => "" )
                                    , array( 'key' => 'duedate', 'value' => "" )
                                    , array( 'key' => 'created_at', 'value' => date( 'Y-m-d H:i:s' ) )
                                )
        ));

        $this->db->insert( 'BOARD', $params );

        $this->baselib->PrintResultAndMessage( 200, "수정되었습니다." );
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

        $path = "uploads/article";

        $explode = explode( '.', $_FILES['upload']['name'] );
        $ext = end( $explode );
        $filename = $this->baselib->GetRandomString( 10, 0 ) . ".{$ext}";
        move_uploaded_file ( $_FILES['upload']['tmp_name'], "{$_SERVER['DOCUMENT_ROOT']}/{$path}/{$filename}" );

        $this->__returnUpload( $this->data['params']['CKEditorFuncNum'], $this->baselib->GetDomain() . "/{$path}/{$filename}", "complete" );
    }
}