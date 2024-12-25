<?php
require_once("../Controllers/Controller.php");
class UserController extends Controller{

public function login()
{
  $email=$_REQUEST['email'];
  $password=$_REQUEST['password'];
  $this->model->login($email,$password);
}




}
?>