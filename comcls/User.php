<?php
$root = realpath( $_SERVER["DOCUMENT_ROOT"] );
include_once $root."/comcls/BaseClass.php";
Class User extends BaseClass {
  public $id;
  public $loginid;
  public $name;
  public $password;
  public $dept_id;
  public $email;
  public $status;
  
  public function __construct() {
    $this->cr_date = date( "Y-m-d" );
    $this->status = 1; //Status 0 => 'Deleted', 1 => 'Linked', 2 => 'Unlinked', 3 => 'Archived'
    $this->tablename = "USER";
    $this->keyValue = "id";
    $this->deleteField = "status";
  }
  
  public function getFieldAttrib() {
    $fieldAttrib = array();
    $fieldAttrib["id"] = array( "val"=>$this->id, "type"=>"i" );
    $fieldAttrib["loginid"] = array( "val"=>$this->loginid, "type"=>"s" );
    $fieldAttrib["name"] = array( "val"=>$this->name, "type"=>"s" );
    $fieldAttrib["password"] = array( "val"=>$this->password, "type"=>"s" );
    $fieldAttrib["dept_id"] = array( "val"=>$this->dept_id "type"=>"i" );
    $fieldAttrib["email"] = array( "val"=>$this->email, "type"=>"s" );
    $fieldAttrib["status"] = array( "val"=>$this->status, "type"=>"i" );
    
    return $fieldAttrib;
  }
}
?>