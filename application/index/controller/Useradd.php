<?php
namespace app\index\controller;
// use app\index\model\Menu;
use think\Validate;
use think\Db;
use app\index\model\AddForm;
use app\index\model\UsersInfo;
class Useradd extends Base{
	// 填充表单数据
	public function index(){
		$addform=new AddForm;
		$dev=$addform->getinfo('dev_from'); //开发渠道
		$forminfo=$addform->getinfo('from'); //信息来源
		$disease=$addform->getinfo('disease'); //咨询病种
		$zx_tools=$addform->getinfo('zx_tools'); //咨询工具
		$doctors=$addform->getinfo('doctors'); //预约医生


		$this->assign([
            'dev'  => $dev,
            'forminfo'  => $forminfo,
            'disease' => $disease,
            'zx_tools' => $zx_tools,
            'doctors' => $doctors,

        ]);
		return $this->fetch('useradd');
	}

	// 联动
	public function link($id){
		$addform=new AddForm;
		// dump(input('post.'));
		$from=$addform->linkage($id); //信息来源
		return json($from);

	}

	// 新增客户
	public function useradd(){

		$num=build_order_no(); //客户编号 预约号

		// dump(input('post.'));
		if(request()->isPost()){
			$info_data=[
				'username'=>input('name'),
				'age'=>input('age'),
				'sex'=>input('sex'),
				'tel'=>input('tel'),
				'dev_id'=>input('dev'),
				'from_id'=>input('from'),
				'tool_id'=>input('tool'),
				'addtime'=>time(),
				'usersn'=>$num
			];

			$zixun_data=[
				'zx_tool_id' =>input('tool'),
				'zx_disease_id' =>input('disease'),
				'zx_comment' => input('comment'),
				'zx_time' =>time(),
			];

			$yuyue_data=[
				'yy_disease_id' =>input('disease'),
				'yy_doctor_id' =>input('doctor'),
				'yy_time' =>strtotime(input('time'))
			];

			// dump($zixun_data);
			// exit;

			// $validate = Loader::validate('Useradd');
			$validate = validate('User');

			$users_info_scene=$validate->scene('users_info')->check($info_data);
			$users_zixun_scene=$validate->scene('users_zixun')->check($zixun_data);
			$users_yuyue_scene=$validate->scene('users_yuyue')->check($yuyue_data);


			dump($info_data);
			exit;

			if(!$users_info_scene || !$users_zixun_scene || !$users_yuyue_scene){
			    // $this->error($validate->getError());
			    return $validate->getError();
			    exit;
			}else{
				$user=new UsersInfo;
				$user->save($info_data);
				if($user->zixun()->save($zixun_data) && $user->yuyue()->save($yuyue_data)){
					return "客户添加成功!";
					// return $this->success('客户添加成功!','');
				}else{
					return "客户添加失败!";
				}
			}

		}else{
			return '非法操作！';
			exit;
		}
	}
}
