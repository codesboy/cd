<?php
namespace app\system\controller;
use think\Validate;
use app\system\model\Consumption as cpmodel;

class Consumption extends Base{
    // 获取消费详情
    public function getcpdetail(){
        if(Request()->isPost()){
            $uid=input('uid');
            $cp=cpmodel::where('uid',$uid)
            ->join('client_wangdian_zixun w','w.id=wdzx_id','left')
            ->join('client_qiantai_zixun q','q.id=qtzx_id','left')
            ->join('client_doctors d','d.id=doctor_id','left')
            ->join('client_disease dis','dis.id=disease_id','left')
            ->field('w.wd_name wd,q.qt_name qt,doctor,disease_name,money,ill_desc,jz_time,create_time')
            ->order('jz_time','desc')
            ->select();

            $total=cpmodel::where('uid',$uid)->count('id');
            $summoney=cpmodel::where('uid',$uid)->sum('money');
            $detaildata=[
                'total'=>$total,
                'rows'=>$cp,
                'footer'=>[
                    ['footer'=>'总复诊次数','money'=>$total],
                    ['footer'=>'总消费金额(￥)','money'=>$summoney]
                ]

            ];
            return json($detaildata);
        }
        // dump($cp);
    }


    // 添加客户就诊/消费记录
    public function addcon(){
        if(Request()->isPost()){
            $cons=new cpmodel();
            // return input('post.');die;
            $addcondata=input('post.');
            $validate = validate('User');
            if($validate->scene('users_consumption')->check($addcondata)){
                $cons->save($addcondata);
                // dump(input('post.'));
                return '该用户消费记录添加成功！';
            }else{
                return $validate->getError();
                exit;
            }
        }
    }
}
