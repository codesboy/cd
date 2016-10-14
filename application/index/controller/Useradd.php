<?php
namespace app\index\controller;
// use think\Controller;
// use app\index\model\Menu;
use think\Validate;
use think\Db;
use app\index\model\AddForm;
class Useradd extends Base{
	// 填充表单数据
	public function index(){
		$addform=new AddForm;
		// $dev=$addform->linkage(); //信息来源
		$forminfo=$addform->getinfo('from'); //信息来源
		$disease=$addform->getinfo('disease'); //咨询病种
		$zx_tools=$addform->getinfo('zx_tools'); //咨询工具
		$doctors=$addform->getinfo('doctors'); //预约医生
		$num=build_order_no(); //客户编号 预约号
		$addtime=time();

		$this->assign([
            // 'dev'  => $dev,
            'forminfo'  => $forminfo,
            'disease' => $disease,
            'zx_tools' => $zx_tools,
            'doctors' => $doctors,
            'num' => $num,
            'addtime' => $addtime,

        ]);
		return $this->fetch('useradd');
	}

	// 联动
	public function link(){
		if(request()->isPost()){
			$from=$addform->linkage(input('dev')); //信息来源
			return json($form);
		}

	}

	// 新增客户信息
	public function useradd(){

		// dump(input('post.'));
		if(request()->isPost()){
			$data=[
				'username'=>input('name'),
				'age'=>input('age'),
				'sex'=>input('sex'),
				'tel'=>input('tel'),
				// 'tool'=>input('tool'),
				// 'disease'=>input('disease'),
				// 'doctor'=>input('doctor'),
				'addtime'=>input('addtime'),
				// 'comment'=>input('comment'),
				'usersn'=>input('usersn')
			];

			$validate = Loader::validate('User');

			if(!$validate->check($data)){
			    dump($validate->getError());
			}

			dump($data);


			if(Db::name('users_info')->insert($data)){
				return "客户添加成功";		
			}else{
				return "客户添加失败";
			}
		}else{
			return $this->fetch();
		}
	}
}