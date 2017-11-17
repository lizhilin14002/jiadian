<?php
namespace Admin\Controller;
use Think\Controller;
class FormController extends Controller{
    //验证码生成
    public function verify_c(){  
        $Verify = new \Think\Verify();  
        $Verify->fontSize = 18;  
        $Verify->length   = 4;  
        $Verify->useNoise = false;  
        $Verify->codeSet = 'abcdefghij';  
        $Verify->imageW = 130;  
        $Verify->imageH = 50;  
        //$Verify->expire = 600;  
        $Verify->entry();  
    }
    //注册逻辑
    // public function register_process(){
    //     $verify = $_POST['verify'];
    //     //验证码检测
    //     if(!check_verify($verify)){  
    //     $this->error("验证码输错了哦！");
    //     }
    //     $User = D('UserAdmin');//向"UserAdmin"表提交数据 “D” 实例化模型类
    //     if($User->create()) {
    //         $result = $User->add();
    //         if($result) {
    //         $this->success('注册成功，请登录！',U('/Home/index'));//若提交完成则显示成功消息
    //         }else{
    //         $this->error('数据添加错误！');
    //         }
    //     }else{
    //     $this->error($User->getError());
    //     }
    // }

    //管理员 登陆逻辑
    public function login_process($usernameA = '', $passwordA = ''){
    $usernameA = $_POST['usernameA'];
    $passwordA = $_POST['passwordA'];
    $verify = $_POST['verify'];
    //验证码检测
    if(!check_verify($verify)){  
    $this->error("验证码错误！");
    }
    //验证中...
    $Data = M('Useradmin');
    $result = $Data->where("username='" . $usernameA . "' AND password='" . $passwordA . "'")->find();

    if($result){
        session('usernameA',$usernameA);
        $this->success('登录成功！',U('/Admin/jiadian'));//若提交完成则显示成功消息
    }else{
        $this->error('用户名或密码错误！');//否则提示
    }
    }
    //管理员 退出登录 逻辑
    public function logout(){
        if(isset($_SESSION['usernameA'])){
            session('usernameA',null);
            session('[destroy]');
            $this->success('用户已退出！', U('/Admin/Form/login'));
        }else{
            $this->redirect('/Admin/Form/login');
        }
    }

}