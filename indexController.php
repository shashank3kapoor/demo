<?php
if( !session_id()) {
session_start();	
}
$root = realpath( $_SERVER["DOCUMENT_ROOT"] );

include_once $root."/comcls/Menu.php";
include_once $root."/comcls/db_con.php";

  $method = ( isset( $_POST["method"] ) ) ? "fn_".$_POST["method"] : null;
  $params = ( isset( $_POST["params"] ) ) ? $_POST["params"] : array();
  $exParams = ( isset( $_POST["exParams"] ) ) ? $_POST["exParams"] : array();
  if( $params == 'false' ) {
    $params = false;
  }
  if( $exParams != 'false' && is_array($exParams) ) {
    if( $params != 'false' && is_array($params) ) {
      $params = array_merge( $params, $exParams );
    }
    else {
      $params = $exParams;
    }
  }

  if( is_callable( $method ) ) {
    $method( $params );
  }

  function fn_getMenu( $prms = array() ) {
    $settings = new Element( "settings", "st", "" );
    
    $settings->addMenu( new Menu( "Demo", "dm", "index.php" ) );
    $settings->addMenu( new Menu( "New User", "nu", "#" ) );
    $settings->addMenu( new Menu( "Change Password", "cp", "#" ) );
    $settings->addMenu( new Menu( "Logout", "lg", "#" ) );
    
    $_SESSION["settingsmenu"] = $settings->getElement();
    
    echo json_encode( array( "items"=>$_SESSION["settingsmenu"] ) );
  }
  
  function fn_get_users( $prms = array() ) {
    global $mysqli;
  
    $sql = " SELECT id, loginid, name, status FROM USER WHERE status = 1 ";
    if( isset( $prms['loginid'] ) && ( $prms['loginid'] ) ) {
      $sql.= " AND loginid LIKE '%".$mysqli->real_escape_string( $prms['loginid'] )."%' ";
    }
    if( isset( $prms['name'] ) && ( $prms['name'] ) ) {
      $sql.= " AND name LIKE '%".$mysqli->real_escape_string( $prms['name'] )."%' ";
    }
    if( isset( $prms['dept_id'] ) && ( $prms['dept_id'] ) ) {
      $sql.= " AND dept_id = '".intval( $prms['dept_id'] )."' ";
    }
    if( isset( $prms['email'] ) && ( $prms['email'] ) ) {
      $sql.= " AND email LIKE '%".$mysqli->real_escape_string( $prms['email'] )."%' ";
    }
		
		if( isset( $prms['sortCol'] ) && isset( $prms['sortOrder'] )
			 && ( $prms['sortCol'] != "" ) && ( $prms['sortOrder'] != "" )
			 ) {
			$sql.= " ORDER BY ".$mysqli->real_escape_string( $prms['sortCol'])." ".$mysqli->real_escape_string( $prms['sortOrder']);
		}
		
		if( isset( $prms['pageOffset'] ) && isset( $prms['pageSize'] )
			 && ( $prms['pageOffset'] != "" ) && ( $prms['pageSize'] != "" )
			 ) {
			$sql.= " LIMIT ".intval( $prms['pageSize'])." OFFSET ".intval( $prms['pageOffset']);
		}
    
    $objs = array();
    if( $result = $mysqli->query( $sql ) ) {
        while( $obj = $result->fetch_object() ) {
	    $tmp = array();
	    
	    foreach( $obj as $key => $val ) {
	      $tmp[$key] = $val;
	    }
	    
	    $objs[] = $tmp;
        }
        $result->close();
        
        $sql = " SELECT COUNT(id) AS totl FROM USER WHERE status = 1 ";
    if( isset( $prms['loginid'] ) && ( $prms['loginid'] ) ) {
      $sql.= " AND loginid LIKE '%".$mysqli->real_escape_string( $prms['loginid'] )."%' ";
    }
    if( isset( $prms['name'] ) && ( $prms['name'] ) ) {
      $sql.= " AND name LIKE '%".$mysqli->real_escape_string( $prms['name'] )."%' ";
    }
    if( isset( $prms['dept_id'] ) && ( $prms['dept_id'] ) ) {
      $sql.= " AND dept_id = '".intval( $prms['dept_id'] )."' ";
    }
    if( isset( $prms['email'] ) && ( $prms['email'] ) ) {
      $sql.= " AND email LIKE '%".$mysqli->real_escape_string( $prms['email'] )."%' ";
    }
        
        $totalCount = 0;
        if( $result = $mysqli->query( $sql ) ) {
          if( $obj = $result->fetch_object() ) {
              
              $totalCount = $obj->totl;
          }
          $result->close();
        }
	
        echo json_encode( array( "success"=>true, "items"=>$objs, "totalCount"=>$totalCount ) );
    }
    else {
      echo json_encode( array( "success"=>false ) );
    }
  }
  
?>
