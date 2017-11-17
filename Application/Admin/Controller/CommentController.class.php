<?php
namespace Admin\Controller;
use Think\Controller;
class CommentController extends Controller {
    public function index($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $Data = M('Comment');
            $count = $Data->count();
            $p = getpage($count,10);
            $result = $Data->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<span class="empty">暂无评论</span>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    public function delete($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $id= $_GET['id'];
            $Data = M('Comment');
            $result = $Data->where("id='" . $id . "'")->delete();
            $this->success('删除成功！');
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    function delete_all($usernameA = ''){
      $usernameA = $_SESSION['usernameA'];
      $id = $_GET['id'];
      if(isset($usernameA)){
          $Data = M('Comment');//获取当期模块的操作对象
          //判断id是数组还是一个数值
          if(is_array($id)){
            $where = 'id in('.implode(',',$id).')';
          }else{
            $where = 'id='.$id;
          }
          $list=$Data->where($where)->delete();
          if($list!==false) {
            $this->success("成功删除{$list}条！");
          }else{
            $this->error('删除失败！');
          }
      }else{
            $this->redirect('/Admin/Form/login');
    }
    }
}