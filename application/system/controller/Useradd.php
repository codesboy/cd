<?php
namespace app\system\controller;
// use app\system\model\Menu;
use think\Validate;
use think\Db;
use app\system\model\AddForm;
use app\system\model\UsersInfo;
class Useradd extends Base{
	// 填充表单数据
	public function index(){
		$addform=new AddForm;
		$dev=$addform->getinfo('dev_from'); //开发渠道
		// $from=$addform->getinfo('from'); //信息来源
		$disease=$addform->getinfo('disease'); //病种
		$zx_tools=$addform->getinfo('zx_tools'); //咨询工具
		$doctors=$addform->getinfo('doctors'); //医生
		$province=$addform->getinfo('province'); //省份列表
		$wdzxs=$addform->getinfo('wangdian_zixun'); //网电咨询师
		$qtzxs=$addform->getinfo('qiantai_zixun'); //前台咨询师

		$this->assign([
            'dev'  => $dev,
            // 'from'  => $from,
            'disease' => $disease,
            'zx_tools' => $zx_tools,
            'doctors' => $doctors,
            'province' => $province,
            'wdzxs' => $wdzxs,
            'qtzxs' => $qtzxs,

        ]);
		return $this->fetch('useradd');
	}

	// 信息来源联动
	public function link($id){
		$addform=new AddForm;
		// dump(input('post.'));
		$from=$addform->linkage($id); //信息来源
		return json($from);

	}
	// 市级联动
	public function citylink($province_id){
		$citys=db('city')->where('province_id',$province_id)->field('city_id,city_name')->select();
		return json($citys);

	}

	// 区县联动
	public function countylink($city_id){
		$countys=db('county')->where('city_id',$city_id)->field('county_id,county_name')->select();
		return json($countys);

	}

	// 新增客户
	public function useradd(){

		$num=build_order_no(); //客户编号 预约号

		// dump(input('post.'));
		if(request()->isPost()){
			$info_data=[
				'name'=>input('name'),
				'sex'=>input('sex'),
				'birthday'=>input('birthday'),
				'telephone'=>input('telephone'),
				'province_id'=>input('province_id'),
				'city_id'=>input('city_id'),
				'county_id'=>input('county_id'),
				'dev_id'=>input('dev_id'),
				'from_id'=>input('from_id'),
				'tool_id'=>input('tool_id'),
				// 'age'=>getAge(input('birthday')),
				// 'addtime'=>time(),
				'usersn'=>$num
			];

			$consumption_data=[
				'wdzx_id'=>input('wdzx_id'),
				'qtzx_id'=>input('qtzx_id'),
				'doctor_id'=>input('doctor_id'),
				'disease_id'=>input('disease_id'),
				'jz_time'=>input('jz_time'),
				'money'=>input('money'),
				'ill_desc'=>input('ill_desc')
			];

			// dump($consumption_data);
			// exit;



			$validate = validate('User');

			if($validate->scene('users_info')->check($info_data) && $validate->scene('users_consumption')->check($consumption_data)){
			// if($validate->scene('users_info')->check($info_data)){
				$user=new UsersInfo;

				$user->save($info_data);
				if($user->consumptions()->save($consumption_data)){
					return "客户添加成功!";
					// return $this->success('客户添加成功!','');
				}else{
					return "客户添加失败!";
				}
			}else{
				// $this->error($validate->getError());
				return $validate->getError();
				exit;
			}

		}else{
			return '非法操作！';
			exit;
		}
	}
}
