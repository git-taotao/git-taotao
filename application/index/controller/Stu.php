<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\index\model\User as U;

class Stu extends Controller
{
	 public function index()
    {	
    	// $list=db('user')->select();
    	$list=Db::table('user')->select();
			// echo "<pre>";
			// print_r($list);
		$this->assign('list',$list);
		$this->assign('title','学生信息表');
    	return view();
    }
	public function add(){
			return $this->fetch();
	}
	public function edit($id){
		//使用模型
		// $user=new U;    //实例化模型
        // $list=$user->find($id);
        $list=U::get($id);   //不实例化模型
        // $list=$user->get($id);
        return view('edit',['v'=>$list]);

        //查询构造器
		// $list=db('user')->find($id);
		// $this->assign('v',$list);
		// return $this->fetch();
	}
	public function update(){
		$id=input('id');
		$data['name']=input('name');
		$data['age']=input('age');
		$data['class']=input('class');
		$data['sex']=input('sex');
		// print_r($data);
		// 查询构造器
		$m=db('user')->where("id",$id)->update($data);
		return $m;
	}
	public function del(){
		$id=$_POST['id'];
		//助手函数db()
		$m=db('user')->where('id',$id)->delete();
		return $m;
	}
	public function do_add(){
		$data['name']=input('post.name');
		$data['age']=input('post.age');
		$data['class']=input('post.class');
		$data['sex']=input('post.sex');
		$data['addtime']=time();

		//使用模型进行增
		$user=new U();
		$user->data($data);
		$user->save();
		// 获取自增ID
		return $user->id;
		//添加多条数据
		//$user=new U();
		// $list = [
		// 	['name'=>'thinkphp','email'=>'thinkphp@qq.com'],
		// 	['name'=>'onethink','email'=>'onethink@qq.com']
		// 	];
		// $user->saveAll($list);
	}

	//试用路由，
	public function shi($name){
		echo $name;
		echo url('index/stu/shi',['name'=>'haitao']);  //url()助手函数若不带参数，则输出本页面的路由
	} 






}