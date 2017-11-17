<?php
namespace Admin\Controller;
use Think\Controller;
class jiadianController extends Controller {
    public function index($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $Data = M('jiadian');
            $count = $Data->count();
            $p = getpage($count,10);
            $result = $Data->limit($p->firstRow, $p->listRows)->select();
            $this->assign('empty','<span class="empty">暂无商品</span>');
            $this->assign('list',$result);
            $this->assign('page', $p->show());
            $this->display();
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    public function change($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $id= $_GET['id'];
            $Data = M('jiadian');
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
            $Data = M('jiadian');
            $result = $Data->where("id='" . $id . "'")->delete();
            $this->success('删除成功！');
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
        //
    function delete_all($usernameA = ''){
      $usernameA = $_SESSION['usernameA'];
      $id = $_GET['id'];
      if(isset($usernameA)){
          $Data = M('jiadian');//获取当期模块的操作对象
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
    public function add_process($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $Data = M('jiadian');
            //上传图片
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 2*1024*1024;// 设置附件上传大小:1M
            $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './Public/image/'; // 设置附件上传根目录
            $upload->savePath = '';
            $upload->autoSub = false;//关闭。生成子目录
            // 上传单个文件 
            $info   =   $upload->uploadOne($_FILES['img']);
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功 获取上传文件信息
                if($Data->create()){
                $Data->img = 'image/'.$info['savename'];
                $Data->add();
            //获取全路径
            $fullpath = $upload->rootPath.$info['savename'];
            $image = new \Think\Image(); 
            $image->open($fullpath);
            // 生成一个固定大小为600*600的缩略图并保存为thumb.jpg
            $result = $image->thumb(600, 600,\Think\Image::IMAGE_THUMB_FIXED)->save($fullpath);
                if($result){
                    $this->success('商品已发布！');
                    }else{
                        $this->error('发布错误！');
                    }
                }
            }

        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
    public function change_process($usernameA = ''){
        if (isset($_SESSION['usernameA'])) {
            $Data = M('jiadian');
            //$Data -> create();
            //$Data -> save();
            if($Data->create()){
                if(isset($_FILES['img'])){
                //上传图片
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 2*1024*1024;// 设置附件上传大小:2M
                $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Public/image/'; // 设置附件上传根目录
                $upload->savePath = '';
                $upload->autoSub = false;//关闭。生成子目录
                // 上传单个文件 
                $info   =   $upload->uploadOne($_FILES['img']);
                if($info) {// 上传错误提示错误信息
                    // $this->error($upload->getError());
                    $Data->img = 'image/'.$info['savename'];
                    $fullpath = $upload->rootPath.$info['savename'];
                    $image = new \Think\Image(); 
                    $image->open($fullpath);
                    // 生成一个固定大小600*600的缩略图并替换原图
                    $image->thumb(600, 600,\Think\Image::IMAGE_THUMB_FIXED)->save($fullpath);
                } 
                }
                $result = $Data->save();
                //获取全路径
                
                if($result !== "false"){
                    $this->success('商品已修改！');
                    }else{
                        $this->error('商品修改错误！');
                    }
                }
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }
}