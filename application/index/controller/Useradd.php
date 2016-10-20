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
				'yy_time' =>input('time')
			];



			$validate = validate('User');

			if($validate->scene('users_info')->check($info_data) && $validate->scene('users_zixun')->check($zixun_data) && $validate->scene('users_yuyue')->check($yuyue_data)){
				$user=new UsersInfo;
				$yuyue_data['yy_time']=strtotime($yuyue_data['yy_time']);

				$user->save($info_data);
				if($user->zixun()->save($zixun_data) && $user->yuyue()->save($yuyue_data)){
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
