<?php
namespace Home\Controller;
use Think\Controller;
class FormController extends Controller{
    //验证码生成
    public function verify_c(){  
        $Verify = new \Think\Verify();  
        $Verify->fontSize = 18;  
        $Verify->length   = 4;  
        $Verify->useNoise = false;  
        $Verify->codeSet = '0123456789';  
        $Verify->imageW = 130;  
        $Verify->imageH = 50;  
        //$Verify->expire = 600;  
        $Verify->entry();  
    }
    //注册逻辑
    public function register_process(){
        $verify = $_POST['verify'];
        //验证码检测
        if(!check_verify($verify)){  
        $this->error("验证码输错了哦！");
        }
        $User = D('User');//向"think_form"表提交数据 “D” 实例化模型类
        if($User->create()) {
            //追加会员等级信息：默认为普通会员
            $User->rank= "初级会员" ;
            $result = $User->add();
            if($result) {
            $this->success('注册成功，请登录！',U('/Home/Form/login'));//若提交完成则显示成功消息
            }else{
            $this->error('数据添加错误！');
            }
        }else{
        $this->error($User->getError());
        }
    }
    //商品添加至购物车 逻辑
    public function addcart(){
        $Cart = M('Cart');//向"think_form"表提交数据 “D” 实例化模型类
        if($Cart->create()) {
            //追加当前时间信息：time
            $Cart->time=date("Y-m-d H:i:s" ,time());
            $Cart->zongjia=($Cart->price)*($Cart->number);
            $result = $Cart->add();
            if($result) {
            $this->success('商品已添加至购物车！');//若提交完成则显示成功消息
            }else{
            $this->error('购物车添加错误！');
            }
        }else{
        $this->error($Cart->getError());
        }
    }
    //购物车查看
    public function cart($username = ''){
        $username = $_SESSION['username'];
        if(isset($username)){
            $Data = M('Cart');
            $where ="username='" . $username . "'";
            $count = $Data->where($where)->count();
            $p = getpage($count,10);
            $result = $Data->where($where)->limit($p->firstRow, $p->listRows)->select();
            //渲染sql语句;在Cart表内 寻找满足条件 username 的数据 并 列出
                $this->assign('empty','<span class="empty">暂无商品</span>');
                $this->assign('list',$result);
                $this->assign('page', $p->show());
                $this->display();
        }else{
            $this->error('请登录后查看购物车！',U('/Home/form/login'));//否则提示
        }
    }
    //订单查看
    public function orderlist($username = ''){
        $username = $_SESSION['username'];
        if(isset($username)){
            $Data = M('Orderlist');
            $where ="username='" . $username . "'";
            $count = $Data->where($where)->count();
            $p = getpage($count,10);
            $result = $Data->where($where)->limit($p->firstRow, $p->listRows)->select();
            //渲染sql语句;在Cart表内 寻找满足条件 username 的数据 并 列出
                $this->assign('empty','<span class="empty">暂无订单</span>');
                $this->assign('list',$result);
                $this->assign('page', $p->show());
                $this->display();
        }else{
            $this->error('请登录后查看订单！',U('/Home/form/login'));//否则提示
        }
    }
    //显示顾客评论> IndexController > phone

    //顾客提交评论
    public function addcomment($username = ''){
        $username = $_SESSION['username'];
        if(isset($username)){
            $Comment = M('comment');
            if($Comment->create()){
                $Comment->addtime = date("Y-m-d H:i:s" ,time());
                $result = $Comment->add();
                if($result){
                    $this->success('评论已发布！');//若提交完成则显示成功消息
                }else{
                    $this->error('发布错误！');
                }
            }
        }else{
            $this->error('请登录后提交评论！');
        }
    }
    //购买逻辑 （购物车->订单）
    public function cart_orderlist($username = ''){
        $username = $_SESSION['username'];
        if(isset($username)){
            //取数据准备
            $Cart = M('Cart');
            $where ="username='" . $username . "'";
            $Cartresult = $Cart->where($where)->field('id',true)->select();
            //从Cart 数据表中取（当前用户的）（排除id字段的）数据
            $Orderlist = M('Orderlist');
            //追加默认信息:在数据库中设定默认值
            //将购物车数据导入到订单表中
            $Orderlist->addAll($Cartresult,array(),true);
            //删除在原购物车表中的数据
            $result = $Cart->where($where)->delete();
            //结果判断
            if($result){
                $this->success('购买成功，转到订单页面！',U('/Home/index'));
            }else{
                $this->error('订单添加错误！');
            }
        }else{
            $this->error('请登录后进行操作！',U('/Home/index'));//否则提示
        }
    }

    public function cart_orderlist_all($username = ''){
        $username = $_SESSION['username'];
        $id = $_GET['id'];
        if(isset($username)){
            //取数据准备
            $Cart = M('Cart');
            if(is_array($id)){
                $where = 'id in('.implode(',',$id).')';
              }else{
                $where = 'id='.$id;
              }
            $Cartresult = $Cart->where($where)->field('id',true)->select();
            //从Cart 数据表中取（当前用户的）（排除id字段的）数据
            $Orderlist = M('Orderlist');
            //追加默认信息:在数据库中设定默认值
            //将购物车数据导入到订单表中
            $Orderlist->addAll($Cartresult,array(),true);
            //删除在原购物车表中的数据
            $result = $Cart->where($where)->delete();
            //结果判断
            if($result){
                $this->success("成功购买{$result}件商品,请填写收货地址",U('/Home/Form/address'));
            }else{
                $this->error('订单添加错误！');
            }
        }else{
            $this->error('请登录后进行操作！',U('/Home/index'));//否则提示
        }
    }
    //购物车-顾客删除记录
    public function cart_delete($username = ''){
        $username = $_SESSION['username'];
        $id = $_GET['id'];
        if(isset($username)){
            $Data = M('Cart');
            $result = $Data->where("id='" . $id . "'")->delete();
            //渲染sql语句;在Cart表内 寻找满足条件 id 的数据 并 删除
            $this->success('删除成功！');

        }else{
            $this->error('请登录后进行操作！',U('/Home/index'));//否则提示
        }
    }
    //购物车 全部删除
    function cart_delete_all($username = ''){
      $username = $_SESSION['username'];
      $id = $_GET['id'];
      if(isset($username)){
          $Cart = M('Cart');//获取当期模块的操作对象
          //判断id是数组还是一个数值
          if(is_array($id)){
            $where = 'id in('.implode(',',$id).')';
          }else{
            $where = 'id='.$id;
          }
          $list=$Cart->where($where)->delete();
          if($list!==false) {
            $this->success("成功删除{$list}条！");
          }else{
            $this->error('删除失败！');
          }
      }else{
            $this->error('请登录后进行操作！',U('/Home/index'));//否则提示
    }
    }
    //登陆逻辑
    public function login_process($username = '', $password = ''){
    $username = $_POST['user'];
    $password = $_POST['password'];
    $verify = $_POST['verify'];
    //验证码检测
    if(!check_verify($verify)){  
    $this->error("验证码输错了哦！");
    }
    //进行验证
    $Data = M('user');
    $where = "username='" . $username . "' AND password='" . $password . "'";
    $result = $Data->where($where)->select();

    if($result){
        //读取会员等级信息
        $rank = $Data->where($where)->getfield('rank');

        session('username',$username);
        session('userrank',$rank);

        $this->success('登录成功！',U('/Home/index'));//若提交完成则显示成功消息
    }else{
        $this->error('用户名或密码错误！');//否则提示
    }
    }
    //顾客 退出登录 逻辑
    public function logout(){
        if(isset($_SESSION['username'])){
            session('username',null);
            session('userrank',null);
            session('[destroy]');
            $this->success('用户已退出！', U('/Home/index'));
        }else{
            $this->redirect('/Home/index');
        }
    }
    //商品搜索 逻辑
    public function searchresult(){
        $name = $_GET['name'];
        $jiadian = M('jiadian');
        $where = "name like'" . "%".$name."%" . "'";
        $count = $jiadian->where($where)->count();
        $p = getpage($count,10);
        $result = $jiadian->where($where)->limit($p->firstRow, $p->listRows)->select();

        $this->assign('empty','<span class="empty">暂无商品</span>');
        $this->assign('list',$result);
        $this->assign('name',$name);
        $this->assign('page', $p->show());
        $this->display();
    }
    //添加地址
    public function add_address($username = ''){
        $username = $_SESSION['username'];
        $Orderlist = M('Orderlist');//向"think_form"表提交数据 “D” 实例化模型类
        if($Orderlist->create()) {
            //追加当前时间信息：time
            $Orderlist->address=$_POST['address'];
            $where ="address = '未填写'";
            $result = $Orderlist->where($where)->save();
            if($result) {
            $this->success('地址添加成功，正在跳转订单页',U('/Home/Form/orderlist'));//若提交完成则显示成功消息
            }else{
            $this->error('地址添加失败！');
            }
        }else{
        $this->error($Cart->getError());
        }
    }
}