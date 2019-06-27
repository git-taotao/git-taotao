<?php
namespace app\index\controller;
use think\Controller;
use think\Request;

class Index extends Controller
{
    public function index()
    {
        // return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
        
        // return $this->fetch();
        
        return view(); //没有继承think\Controller 用return view();二者用法一样
        //无参数。return view();
        //会自动定位模板文件：当前模块/默认视图目录（view）/以当前控制器（小写）为名的目录/当前方法（小写）.html
        
        //有参数。
        //a、return view(‘edit’);//跨模板渲染文件。模板渲染文件（edit.html）
        //b、return view(‘regist/lala’);//跨控制器。控制器名（小写）/模板渲染文件（lala.html）
        //c、return view(‘admin@regist/lala’);//跨模板（跨模块）。模块名@控制器名（小写）/模板渲染文件（lala.html）
        

    }
    //请求接口
    /**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}
//自定义验证码
 public function  getCode(){
    $string='0123456789';
    $str='';
    for ($i=0; $i <6 ; $i++) { 
        $str.=$string[rand(0,strlen($string)-1)];
    }
    return $str;
 }

//发送短信
    public function sendSms(){
        //调用成员方法获取随机验证码
        $code=$this->getCode();
        //接收手机号
        $phone=input("post.phone");

        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
          
        $smsConf = array(
            'key'   => '1cd775fd58fed40e12c1df0fe27b2995', //您申请的APPKEY
            'mobile'    => "{$phone}", //接受短信的用户手机号码
            'tpl_id'    => '168329', //您申请的短信模板ID，根据实际情况修改
            'tpl_value' =>"#code#={$code}" //您设置的模板变量，根据实际情况修改
        );
         //调用接口
        $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信
         
        if($content){
            $result = json_decode($content,true);
            $error_code = $result['error_code'];
            if($error_code == 0){
                //状态为0，说明短信发送成功
                // return "短信发送成功,短信ID：".$result['result']['sid'];
                session('code',$code);
                return 1;
            }else{
                //状态非0，说明失败
                $msg = $result['reason'];
                return "短信发送失败(".$error_code.")：".$msg;
            }
        }else{
            //返回内容异常，以下可根据业务逻辑自行修改
            return "请求发送短信失败";
        }
    } 

    //验证
    public function check(){
        $val=input("post.val");
        if ($val==session("code")) {
            return 1;
        }else{
            return 2;
        }
    }
}
