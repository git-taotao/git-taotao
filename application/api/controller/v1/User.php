<?php 
namespace app\api\controller\v1;
 
use app\api\model\User as UserModel;
 
 //api版本号可以在请求头、参数、URL路由参数中传入
class User
{
    // 获取用户信息
    public function read($id = 0)
    {
        $user = UserModel::get($id);
        if ($user) {
            return json($user);
        } else {
            return json(['error' => '用户不存在'], 404);
        }
    }
 
}

 ?>
