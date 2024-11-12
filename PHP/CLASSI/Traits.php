<?php
/**
 * traits
 *
 * <ul>
 * Reuse methods in different classes</li>
 * Similar to a class but only to group functionality</li>
 * They can have static members, variables ecct
 * They override inherited methods and are overriden by
 * local methods
 * You can use more than one traits
 *
*/
trait Test {
  public function login(){
    echo 'I am logging in';
  }
    public function logout(){
        echo 'I logged out';
    }
    public function getUserRole(){
        return $_SESSION['userrole'] ?? 'Plebeo';
    }
    public function getUserName(){
        return $_SESSION['username'] ?? 'Martin';
    }
}
class PostController {
    use Test;
    public function display(){
        echo $this->login() . ' as: '.$this->getUserName()."\n";;
        echo 'My role is: '.$this->getUserRole()."\n";
        $this->logout();
    }
}

$pc = new PostController();
$pc->display();