<?php
namespace app\credit\controller;
use app\index\controller\Base;
use app\index\model\AddForm;
use app\credit\model\CreditUsers;
use app\credit\model\CreditConsumption;
class Creditdata extends Base{
    public function index(){
        $addform=new AddForm;
        $disease=$addform->getinfo('disease'); //病种

        $this->assign([
            'disease' => $disease
        ]);
        return $this->fetch();
    }

    public function returnCreditData(){
        // $arr=[
        //     'total'=>12,
        //     'rows'=>[]
        // ];
        $arr=CreditUsers::all();

        return json($arr);
    }

    public function addChild(){
        if(Request()->isPost()){
            // dump(input('post.'));
            exit;
            // 下线本次消费金额
            $pay=input('money');

            // 推荐人积分率5%
            $p_rate=0.05;

            // 自身积分率1%
            $s_rate=0.01;

            // 推荐者得到的积分 消费金额的5%
            $p_credit=round($pay*$p_rate);

            // 本人得到的积分 消费金额的1%
            $s_credit=round($pay*$s_rate);

            // 下线基本资料
            $credituserdata=[
                'name'=>input('name'),
                'sex'=>input('sex'),
                'age'=>input('age'),
                'telephone'=>input('telephone'),
                'pid'=>input('pid'),
                'comment'=>input('comment')
            ];

            // 下线客户资料写入数据库
            $credit_user=new CreditUsers;

            $credit_user->save($credituserdata);

            // 获取自增ID
            $getid=$credit_user->id;

            /*return $getid;
            exit;*/


            $creditconsumptiondata=[
                [
                    'uid'=>$getid,
                    'disease_id'=>input('disease_id'),
                    'pay_time'=>input('pay_time'),
                    'account_payable'=>$pay,
                    'used_credit'=>0,
                    'real_pay'=>$pay,
                    'get_credit'=>$s_credit,
                    'comment'=>input('comment')
                ],
                [
                    'uid'=>input('pid'),
                    'disease_id'=>0,
                    'pay_time'=>input('pay_time'),
                    'account_payable'=>0,
                    'used_credit'=>0,
                    'real_pay'=>0,
                    'get_credit'=>$p_credit,
                    'comment'=>'积分来自'.input('name').'的消费！'
                ]

            ];

            // 推荐者和被推荐者积分记录写入数据库
            $credit_re=new CreditConsumption;
            // $credit_user->creditConsumptions()->saveAll($creditconsumptiondata);
            $credit_re->saveAll($creditconsumptiondata);


        }else{
            return 'Hello World!';
            exit;
        }
    }
}
