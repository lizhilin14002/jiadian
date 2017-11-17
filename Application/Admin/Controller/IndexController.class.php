<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
        	$jiadian = M('jiadian');
            $jiadiancount = $jiadian->count();
            $Order = M('Orderlist');
            $Ordercount = $Order->count();
            $Comment = M('Comment');
            $Commentcount = $Comment->count();
            $User = M('User');
            $Usercount = $User->count();
            $News = M('News');
            $Newscount = $News->count();
            $this->assign('jiadian',$jiadiancount);
            $this->assign('Order',$Ordercount);
            $this->assign('Comment',$Commentcount);
            $this->assign('User',$Usercount);
            $this->assign('News',$Newscount);
            $this->display();
        }else{
            $this->redirect('/Admin/Form/login');
        }
        
    }
}