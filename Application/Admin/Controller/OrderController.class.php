<?php
namespace Admin\Controller;
use Think\Controller;
class OrderController extends Controller {
    public function index($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $Data = M('Orderlist');
            $count = $Data->count();
            $p = getpage($count,10);
            $result = $Data->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<span class="empty">暂无订单</span>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Admin/Form/login');
        }
        
    }
    public function changestatus($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
        $id= $_GET['id'];
        $Data = M('Orderlist');
        $where ="id='" . $id . "'";
        $result = $Data-> where($where)->setField('status','已处理');
            if($result){
                $this->success('状态调整成功！');
            }else{
                $this->error('状态调整失败！');
            }
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
}