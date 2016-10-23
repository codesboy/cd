<?php
/**
 * @authors Rehack (565195693@qq.com)
 * @link    http://rehack.cn
 * @date    2016-10-23 21:49:10
 * @version $Id$
 */

namespace app\index\controller;
use app\index\model\Consumption as cpmodel;

class Consumption extends Base{
    // 获取消费详情
    public function getcpdetail(){
        // if(Request()->isGet()){
            $uid=input('uid');
            $cp=cpmodel::where('uid',$uid)
            ->join('wangdian_zixun w','w.id=wdzx_id')
            ->join('qiantai_zixun q','q.id=qtzx_id')
            ->join('doctors d','d.id=doctor_id')
            ->join('disease dis','dis.id=disease_id')
            ->field('w.name wd,q.name qt,doctor,disease_name,money,ill_desc,jz_time')
            ->select();
            return json($cp);
        // }
        // dump($cp);
    }
}
