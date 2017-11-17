<?php
namespace Admin\Controller;
use Think\Controller;
class NewsController extends Controller {
    public function index($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $Data = M('News');
            $count = $Data->count();
            $p = getpage($count,10);
            $result = $Data->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<span class="empty">暂无公告</span>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Admin/Form/login');
        }
        
    }
    public function add_process($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $Data = M('News');
        
            if($Data->create()){
                //添加时间信息
            $Data->addtime = date("Y-m-d H:i:s" ,time());
            $result = $Data->add();

            if($result){
                $this->success('公告已发布！');
                }else{
                    $this->error('发布错误！');
                }
            }

            }else{
                $this->redirect('/Admin/Form/login');
            }
        }
        public function change_process($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $Data = M('News');

            if($Data->create()){
                //补充时间信息
                $Data->addtime = date("Y-m-d H:i:s" ,time());
                $result = $Data->save();
                
                if($result !== "false"){
                    $this->success('公告已修改！');
                    }else{
                        $this->error('公告修改错误！');
                    }
                }
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    public function change($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $id= $_GET['id'];
            $Data = M('News');
            $result = $Data->find($id);
            $this->assign('list',$result);
            $this->display();
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    public function delete($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $id= $_GET['id'];
            $Data = M('News');
            $result = $Data->where("id='" . $id . "'")->delete();
            $this->success('删除成功！');
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    public function delete_all($usernameA = ''){
      $usernameA = $_SESSION['usernameA'];
      $id = $_GET['id'];
      if(isset($usernameA)){
          $Data = M('News');//获取当期模块的操作对象
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