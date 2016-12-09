<?php
namespace app\credit\controller;
use app\system\controller\Base;
use app\system\model\AddForm;
use think\Validate;
// use think\Db;
use app\credit\model\CreditUsers;
use app\credit\model\CreditConsumption;
use \PHPExcel;
use \PHPExcel_IOFactory;
class Creditdata extends Base{
    public function index(){
        $addform=new AddForm;
        $disease=$addform->getinfo('disease'); //病种

        $this->assign([
            'disease' => $disease
        ]);
        return $this->fetch();
    }

    // 得到积分客户数据
    // private function getCreditsDate(){
    public function getCreditsDate(){

        // 分页条件
        $page=input('page');
        $rows=input('rows');
        $offset=($page-1)*$rows;

        // 筛选条件
        $pointsRange="";
        // $pointsRangeArr=[];
        $startpoint=input('startpoint');
        $endpoint=input('endpoint');
        if(!empty($startpoint) || !empty($endpoint)){
            // $pointsRange='SUM(get_credit)-SUM(used_credit) BETWEEN :startpoint AND :endpoint ';
            $pointsRange="sumg BETWEEN $startpoint AND $endpoint";
            // $pointsRangeArr=['startpoint'=>$startpoint,'endpoint'=>$endpoint];
        }

        // 模糊查询
        $keywords=input('name');
        $fuzzy=[];
        if(!empty($keywords)){
            $fuzzy['u.name']=['like',"%{$keywords}%"];
            $fuzzy['u.telephone']=['like',"%{$keywords}%"];
        }

        // 排序条件
        $sort=input('sort')?input('sort'):'u.id';
        $order=input('order')?input('order'):'desc';

        $CreditUsersModel=new CreditUsers;

        $credit_users=CreditUsers::view('client_credit_users u','id,name,telephone,sex,age,create_time,comment,pid,update_time')
            ->view('credit_users',['name'=>'tjr','telephone'=>'tjrtel'],'credit_users.id=u.pid','left')
            ->view('credit_consumption',['SUM(account_payable)'=>'suma','SUM(used_credit)'=>'sumu','SUM(real_pay)'=>'sumr','SUM(get_credit)-SUM(used_credit)'=>'sumg'],'uid=u.id','left')
            ->whereOr($fuzzy)
            // ->whereTime('u.create_time','d')
            // ->where('SUM(get_credit)-SUM(used_credit)','BETWEEN',[$startpoint,$endpoint])

            // ->having('sumg','BETWEEN',[$startpoint,$endpoint])
            // ->having($pointsRange,$pointsRangeArr)
            ->having($pointsRange)
            // ->having('SUM(get_credit)-SUM(used_credit) BETWEEN :startpoint AND :endpoint',['startpoint'=>1,'endpoint'=>7])
            ->group('u.id')
            ->order([$sort=>$order])
            ->limit($offset,$rows)
            ->select();
            // ->select(false);

        return $credit_users;
    }


    // 处理数据返回给前端使用
    public function returnCreditData(){
        if(Request()->isPost()){


            $credit_users=$this->getCreditsDate();

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
            // dump(input('post.'));die;

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
                    'pay_time'=>null,
                    'account_payable'=>0,
                    'used_credit'=>0,
                    'real_pay'=>0,
                    'get_credit'=>$p_credit,
                    'comment'=>'积分来自 '.input('name').'('.input('telephone').')的消费！'
                ]

            ];

            // 验证器
            $validate = validate('Credit');
            // 下线客户资料写入数据库

            if($validate->scene('addparent')->check($credituserdata) && $validate->scene('addchild')->check($creditconsumptiondata)){
                // return '1';
                // exit;
                $credit_user=new CreditUsers;
                $credit_user->save($credituserdata);//写入基本信息
                // 获取自增ID
                $getid=$credit_user->id;
                $creditconsumptiondata[0]['uid']=$getid;
                if($creditconsumptiondata[1]['get_credit']==0){
                    $creditconsumptiondata[1]['comment']='下线未消费';
                }
                if($getid && $pay){
                    // 推荐者和被推荐者积分记录写入数据库
                    $credit_re=new CreditConsumption;
                    if($credit_re->saveAll($creditconsumptiondata)){
                        return '添加成功!';
                    }else{
                        return '添加失败,请及时联系管理员!';
                    }
                }else{
                    return '下线添加成功,暂未消费,未获得积分！';
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
            $alblePoints=(int)input('alblePoints');// 剩余积分
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
                        'uid'=>$sid,
                        // 'uid'=>33,
                        'disease_id'=>$disease_id,
                        'pay_time'=>$pay_time,
                        'account_payable'=>$account_payable,
                        'used_credit'=>$usePointsNum,
                        'real_pay'=>$real_pay,
                        'get_credit'=>$get_credit,
                        'comment'=>$comment
                    ],
                    [
                        'uid'=>$pid,
                        // 'uid'=>55,
                        'disease_id'=>0,
                        'pay_time'=>0,
                        'account_payable'=>0,
                        'used_credit'=>0,
                        'real_pay'=>0,
                        'get_credit'=>$tjrGetPoints,
                        'comment'=>'积分来自 '.$name.'('.$tel.')的消费！'
                    ]
                ];

                $twoData11=[
                    'self'=>[
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
                    'parent'=>[
                        'uid'=>$pid,
                        // 'uid'=>55,
                        'disease_id'=>0,
                        'pay_time'=>0,
                        'account_payable'=>0,
                        'used_credit'=>0,
                        'real_pay'=>0,
                        'get_credit'=>$tjrGetPoints,
                        'comment'=>'积分来自'.$name.'('.$tel.')的消费！'
                    ]
                ];

                // 验证多条数据
                foreach($twoData as $value){
                    $result   = $validate->scene('addpoints')->check($value);
                    if(!$result){
                        return $validate->getError();
                        exit;
                    }
                    if($points->saveAll($twoData)){
                        return '添加成功!';
                    }else{
                        return '添加失败,请及时联系管理员!';
                    }
                }
                /*if($validate->scene('addpoints')->batch()->check($twoData)){
                // if($validate->scene('addpoints')->check($twoData)){
                    // 推荐者和被推荐者积分记录写入数据库
                    if($points->saveAll($twoData)){
                        return '添加成功!';
                    }else{
                        return '添加失败,请及时联系管理员!';
                    }
                }else{
                    return $validate->getError();
                }*/
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

    // 修改客户资料
    public function edit(){
        if(Request()->isPost()){
            $data=input('post.');
            // 验证器
            $validate = validate('Credit');
            if($validate->scene('edit')->check($data)){
                $user=new CreditUsers;
                if($user->isUpdate(true)->save($data)>0){
                    return '修改成功';
                }else{
                    return '修改失败';
                }
            }else{
                return $validate->getError();
            }

        }else{
            exit;
        }
    }

    // 导出数据到excel
    public function export(){
        $objPHPExcel=new PHPExcel;
        // dump($objPHPExcel);die;
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                     ->setLastModifiedBy("Maarten Balliauw")
                                     ->setTitle("Office 2007 XLSX Test Document")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Test result file");
        // Add some data
        $oSheet = $objPHPExcel->getActiveSheet(); //获取当前活动sheet标签
        $oSheet->setTitle('成都贝臣齿科客户积分情况表');
        $oSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//居中
        $oSheet->getColumnDimension('B')->setWidth(20);//单独设置列宽
        $oSheet->getStyle('A1:J1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $oSheet->getStyle('A1:J1')->getFill()->getStartColor()->setARGB("#0cedffb");//表头背景颜色
        $oSheet->getStyle('A1:J1')->getFont()->setBold(true);//表头字体加粗


        // 批量设置列宽
        $arr=range('A','J');
        // var_dump($arr);
        // exit;
        for($i=0;$i<count($arr);$i++){
            $oSheet->getColumnDimension($arr[$i])->setWidth(20);
        }


        // echo $this->returndata()->data;die;
        $data=$this->getCreditsDate();
        // dump($data);die;
        // 填充数据
        // $oSheet->fromArray($row); //此方法占内存
        $j=2;
        foreach ($data as $key => $value) {
            $oSheet->setCellValue('A'.$j,$value['name'])
            ->setCellValue('B'.$j,$value['telephone'])
            ->setCellValue('C'.$j,$value['sex'])
            ->setCellValue('D'.$j,$value['age'])
            ->setCellValue('E'.$j,$value['suma'])
            ->setCellValue('F'.$j,$value['sumu'])
            ->setCellValue('G'.$j,$value['sumr'])
            ->setCellValue('H'.$j,$value['sumg'])
            ->setCellValue('I'.$j,$value['tjr'])
            ->setCellValue('J'.$j,$value['create_time']);
            $j++;
        }
        //

        //插入表头
        // $oSheet->insertNewRowBefore(1,1);
        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A1', '姓名')
                                ->setCellValue('B1', '手机号码')
                                ->setCellValue('C1', '性别')
                                ->setCellValue('D1', '年龄')
                                ->setCellValue('E1', '应付总消费金额')
                                ->setCellValue('F1', '总使用积分')
                                ->setCellValue('G1', '实际总消费金额')
                                ->setCellValue('H1', '剩余积分')
                                ->setCellValue('I1', '推荐者')
                                ->setCellValue('J1', '登记时间');

        $date=date("Ymd");
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="成都贝臣齿科客户积分情况表'.$date.'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        // header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0



        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}
