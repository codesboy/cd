<?php
/**
 * @authors Rehack (565195693@qq.com)
 * @link    http://rehack.cn
 * @date    2016-10-23 21:49:10
 * @version $Id$
 */

namespace app\index\controller;
use think\Validate;
use app\index\model\Consumption as cpmodel;

class Consumption extends Base{
    // 获取消费详情
    public function getcpdetail(){
        if(Request()->isPost()){
            $uid=input('uid');
            $cp=cpmodel::where('uid',$uid)
            ->join('wangdian_zixun w','w.id=wdzx_id')
            ->join('qiantai_zixun q','q.id=qtzx_id')
            ->join('doctors d','d.id=doctor_id')
            ->join('disease dis','dis.id=disease_id')
            ->field('w.name wd,q.name qt,doctor,disease_name,money,ill_desc,jz_time')
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
            // return input('post.');
            $addcondata=input('post.');
            $validate = validate('User');
            if($validate->scene('users_consumption')->check($addcondata)){
                cpmodel::create($addcondata);
                // dump(input('post.'));
                return '该用户消费记录添加成功！';
            }else{
                return $validate->getError();
                exit;
            }
        }
    }
}
