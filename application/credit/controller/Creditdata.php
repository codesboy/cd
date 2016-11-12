<?php
namespace app\credit\controller;
use app\index\controller\Base;
use app\index\model\AddForm;
use think\Validate;
// use think\Db;
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

    // 返回主数据
    public function returnCreditData(){
        if(Request()->isPost()){
            // 分页条件
            $page=input('page');
            $rows=input('rows');
            $offset=($page-1)*$rows;

            // 筛选条件
            $name=input('name');
            $startpoint=input('startpoint')?input('startpoint'):0;
            $endpoint=input('endpoint')?input('endpoint'):10000;

            // 排序条件
            $sort=input('sort')?input('sort'):'u.id';
            $order=input('order')?input('order'):'desc';

            // $credit_users=CreditUsers::limit($offset,$rows)->order([$sort=>$order])->select();
            $CreditUsersModel=new CreditUsers;
            /*$credit_users=$CreditUsersModel->alias('u')
                ->join('client_credit_consumption c','c.uid=u.id')
                ->join('client_credit_users p','p.id=u.pid','left')
                ->field('u.id,u.name,p.name tjr,p.telephone tjrtel,u.sex,u.age,u.telephone,sum(c.account_payable) suma,sum(c.used_credit) sumu,sum(c.real_pay) sumr,sum(c.get_credit)-sum(c.used_credit) sumg,u.create_time')
                ->where('u.name|u.telephone','like',"%$name%")
                // ->where('sumg','between',[$startpoint,$endpoint])
                ->group('u.id')
                ->order([$sort=>$order])
                ->limit($offset,$rows)
                ->select();*/

            $credit_users=CreditUsers::view('client_credit_users u','id,name,telephone,sex,age,create_time')
                ->view('credit_users',['name'=>'tjr','telephone'=>'tjrtel'],'credit_users.id=u.pid','left')
                ->view('credit_consumption',['sum(account_payable)'=>'suma','sum(used_credit)'=>'sumu','sum(real_pay)'=>'sumr','sum(get_credit)-sum(used_credit)'=>'sumg'],'uid=u.id','left')
                ->where('u.name|u.telephone','like',"%$name%")
                // ->where('sumg','between',[$startpoint,$endpoint])
                ->group('u.id')
                // ->where('sumg','between',[10,50])
                ->order([$sort=>$order])
                ->limit($offset,$rows)
                ->select();
            // dump($credit_users);die;


            // return $credit_users;exit;
            // $credit_users=CreditUsers::select();
            // $credit_users=CreditUsers::paginate(3);
            // dump($credit_users->creditConsumptions);
            // exit;
            // 获取客户的所有积分记录
            /*foreach($credit_users as $key=>$user){
                // echo $key."<br>";
                $credit = CreditUsers::find($user['id']);//一个客户 obj
                // dump($credit);
                // dump($credit->creditConsumptions);
                // exit;
                $detail=$credit->creditConsumptions()->field('sum(account_payable) suma,sum(used_credit) sumu,sum(real_pay) sumr,sum(get_credit)-sum(used_credit) sumg')->order(['suma'=>'desc'])->select();//一个客户的积分列表 array
                // dump($detail);
                // dump($detail[0]['suma']);
                $credit->tjr=CreditUsers::where('id',$credit['pid'])->value('name,id','id');
                // $credit->tjr=CreditUsers::where('id',$credit['pid'])->value('name');
                $credit->suma=$detail[0]['suma'];
                $credit->sumu=$detail[0]['sumu'];
                $credit->sumr=$detail[0]['sumr'];
                $credit->sumg=$detail[0]['sumg'];
                $result[]=$credit->toArray();
                // $credit->append(['update_time'])->toArray();
                // $result=array_merge($credit,$detail);
            }*/
            // exit;
            // dump($credit);
            $total=CreditUsers::count('id');
            $allCreditData=[
                'total'=>$total,
                'rows'=>$credit_users
            ];
            // exit;
            return json($allCreditData);
            // return $credit;

        }else{
            return 'Hello World!';
        }

    }
    // 获取客户详细消费积分列表
    public function getCreditDetail($uid){
        if(Request()->isPost()){
            $uid=input('uid');
            $credit_users=CreditUsers::get($uid);
            // dump($credit_users);exit;
            // var_dump($credit_users->creditConsumptions);
            $total=$credit_users->creditConsumptions()->count();
            $creditList=$credit_users->creditConsumptions()->alias('c')
            ->join('disease d','d.id=c.disease_id','left')
            // ->order('id','desc')
            ->field('disease_name,account_payable,used_credit,real_pay,get_credit,comment,pay_time,create_time')
            ->select();
            $creditDetailData=[
                'total'=>$total,
                'rows'=>$creditList
            ];
            return (json($creditDetailData));
        }else{
            return 'Hello World!';
        }
    }





    // 新增下线
    public function addChild(){
        if(Request()->isPost()){

            // 下线本次消费金额

            $pay=(float)input('money');

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

            $getid=0;

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

            // 验证器
            $validate = validate('Credit');
            // 下线客户资料写入数据库

            if($validate->scene('addparent')->check($credituserdata) && $validate->scene('addchild')->check($creditconsumptiondata)){
                // return '1';
                // exit;
                $credit_user=new CreditUsers;
                $credit_user->save($credituserdata);
                // 获取自增ID
                $getid=$credit_user->id;
                $creditconsumptiondata[0]['uid']=$getid;
                if($creditconsumptiondata[1]['get_credit']==0){
                    $creditconsumptiondata[1]['comment']='下线未消费';
                }
                if($getid){
                    // 推荐者和被推荐者积分记录写入数据库
                    $credit_re=new CreditConsumption;
                    if($credit_re->saveAll($creditconsumptiondata)){
                        return '添加成功!';
                    }else{
                        return '添加失败,请及时联系管理员!';
                    }
                }else{
                    return '添加失败,请及时联系管理员!';
                }
            }else{
                return $validate->getError();
            }
        }else{
            return 'Hello World!';
            exit;
        }
    }

    // 积分管理
    public function manPoints(){
        if(Request()->isPost()){
            $disease_id=input('disease_id');//本次消费项目
            $account_payable=input('money');//本次消费金额，即本次应付金额
            $pay_time=input('pay_time');//本次消费时间
            $usePointsNum=input('usePointsNum');//本次所使用积分
            $alblePoints=input('alblePoints');// 剩余积分
            $isAddParC=input('isAddParC');//是否为该客户的介绍人累积积分 0否 1是
            $pid=input('pid');//该客户的推荐人的id号
            $sid=input('sid');//自己的id号
            $name=input('name');//姓名
            $tel=input('tel');//手机号
            $comment=input('comment');//备注

            $tjrRate=0.05;//推荐人积分率
            $selfRate=0.01;//自身积分率
            $creditRate=1;//积分抵扣率 1积分可低一元钱



            // 计算推荐人所得到的积分=本次应付金额*推荐人积分率
            if($isAddParC==1){
                $tjrGetPoints=round($account_payable*$tjrRate);
            }else{
                $tjrGetPoints=0;
            }


            // 计算自己得到的积分和实际支付金额
            if($usePointsNum>$alblePoints){ //本次使用积分超出所剩余积分
                return '非法操作！本次使用积分已经超出所剩余积分!';
                exit;
            }else{
                $real_pay=$account_payable-$usePointsNum*$creditRate;//本次实付金额=本次应付金额-积分抵扣金额

                if($real_pay>0){
                    $get_credit=round($real_pay*$selfRate);//本次自己得到的积分=本次实付金额*自身积分率
                }else{
                    $get_credit=0;
                    $real_pay=0;//避免实际支付金额为负数 倒贴钱
                }
            }

            // 其推荐人存在并且为其累积积分 插入两条记录
            // 验证器
            $validate = validate('Credit');
            $points=new CreditConsumption;
            if($pid>0 && $tjrGetPoints>0){
                $twoData=[
                    [
                        // 'uid'=>$sid,
                        'uid'=>33,
                        'disease_id'=>$disease_id,
                        'pay_time'=>$pay_time,
                        'account_payable'=>$account_payable,
                        'used_credit'=>$usePointsNum,
                        'real_pay'=>$real_pay,
                        'get_credit'=>$get_credit,
                        'comment'=>$comment
                    ],
                    [
                        // 'uid'=>$pid,
                        'uid'=>55,
                        'disease_id'=>0,
                        'pay_time'=>0,
                        'account_payable'=>0,
                        'used_credit'=>0,
                        'real_pay'=>0,
                        'get_credit'=>$tjrGetPoints,
                        'comment'=>'积分来自'.$name.'('.$tel.')的消费！'
                    ]
                ];
                if($validate->scene('addpoints')->batch()->check($twoData)){
                // if($validate->scene('addpoints')->check($twoData)){
                    // 推荐者和被推荐者积分记录写入数据库
                    if($points->saveAll($twoData)){
                        return '添加成功!';
                    }else{
                        return '添加失败,请及时联系管理员!';
                    }
                }else{
                    return $validate->getError();
                }
            }else{ //否则只为自己插入一条积分记录
                $singleData=[
                    'uid'=>$sid,
                    'disease_id'=>$disease_id,
                    'pay_time'=>$pay_time,
                    'account_payable'=>$account_payable,
                    'used_credit'=>$usePointsNum,
                    'real_pay'=>$real_pay,
                    'get_credit'=>$get_credit,
                    'comment'=>$comment
                ];
                if($validate->scene('addpoints')->check($singleData)){
                    // 推荐者和被推荐者积分记录写入数据库

                    if($points->save($singleData)){
                        return '添加成功!';
                    }else{
                        return '添加失败,请及时联系管理员!';
                    }
                }else{
                    return $validate->getError();
                }
            }
        }
    }
}
