<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
        $Data = M('jiadian');
        $focus = $Data->order('id desc')->limit(6)->field('id,name,img')->select();
        $focus4= $Data->order('id')->limit(4)->field('id,name,img')->select();
        $focus5= $Data->order("rand()")->limit(3)->field('id,name,img')->select();
        $focus6= $Data->order("rand()")->limit(3)->field('id,name,img')->select();
        $this->assign('focus',$focus);
        $this->assign('focus4',$focus4);
        $this->assign('focus5',$focus5);
        $this->assign('focus6',$focus6);

        $Data2 = M('slideshow');
        $focus2 = $Data2->select();
        $this->assign('result',$focus2);

        $Data3 = M('news');
        $focus3 = $Data3->order('id desc')->limit(5)->field('id,title,addtime')->select();
        $this->assign('newsempty','<span class="empty">暂无公告</span>');
        $this->assign('newslist',$focus3);

        $this->display();
    }
    public function jiadian(){
    $id= $_GET['id'];

    $Data = M('jiadian');
    $result = $Data->find($id);//读取其中第一个
    $this->assign('result',$result);

    $commentData = M('Comment');
    $where ="jiadianid='" . $id . "'";
    $commentResult = $commentData->where($where)->select();//读取其中第一个
    $this->assign('empty','<span class="empty">暂无评论</span>');
    $this->assign('comment',$commentResult);
    
    $this->display();
    }
    public function news(){
    $id= $_GET['id'];

    $Data = M('news');
    $result = $Data->find($id);//读取其中第一个
    $this->assign('result',$result);
    
    $this->display();
    }

}