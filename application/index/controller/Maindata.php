<?php
namespace app\index\controller;
use app\index\model\AddForm;
use app\index\model\UsersInfo;
// use think\Db;
use \PHPExcel;
use \PHPExcel_IOFactory;
class Maindata extends Base
{
	public function index()
	{
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
            'name'=>11

        ]);


		return $this->fetch();
	}

	// 信息来源联动
	public function link($id){
		$addform=new AddForm;
		// dump(input('post.'));
		$from=$addform->linkage($id); //信息来源
		return json($from);

	}



	// 得到用户数据
	private function getUserData(){
		$user=new UsersInfo;
		// 分页条件
		$page=input('page');
		$rows=input('rows');
		$offset=($page-1)*$rows;

		// 排序条件
		$sort=input('sort')?input('sort'):'u.id';
		$order=input('order')?input('order'):'desc';

		// 筛选条件
		$name=input('name');
		// $startmoney=input('startmoney')?input('startmoney'):0;
		// $money_where=input('startmoney');
		$startmoney=input('startmoney')?input('startmoney'):0;
		$endmoney=input('endmoney')?input('endmoney'):100000000;

		$data=$user->alias('u')
			// ->join('consumption con','con.uid=u.id')
			->join('(select a.*,sum(money) summoney from (select * from client_consumption ORDER BY jz_time desc) a group by a.uid ) con','con.uid=u.id')
			->join('client_province p','p.province_id=u.province_id','LEFT')
			->join('client_city c','c.city_id=u.city_id','LEFT')
			->join('client_county co','co.county_id=u.county_id','LEFT')
			->join('client_dev_from d','d.id=u.dev_id','LEFT')
			->join('client_source s','s.id=u.from_id','LEFT')
			->join('client_zx_tools z','z.id=u.tool_id','LEFT')
			->join('client_wangdian_zixun w','w.id=wdzx_id','LEFT')
			->join('client_qiantai_zixun q','q.id=qtzx_id','LEFT')
			->join('client_doctors doc','doc.id=doctor_id','LEFT')
			->join('client_disease dis','dis.id=disease_id','LEFT')
			->field('u.id,u.name,u.sex,u.birthday,u.age,u.telephone,p.province_name,c.city_name,co.county_name,d.dev,source_name,z.tool,wd_name wdname,qt_name qtname,doc.doctor,disease_name,jz_time,summoney,addtime')
			// ->group('u.id')
			->where('name|telephone','like',"%$name%")
			->where('summoney','between',[$startmoney,$endmoney])
			->order([$sort=>$order])
			->limit($offset,$rows)
			->select();
		$data1=$user->view('UsersInfo','id,name,sex,birthday,age,telephone,addtime')
			->view('Province','province_name','Province.province_id=UsersInfo.province_id')
			->view('City','city_name','City.city_id=UsersInfo.city_id')
			->view('County','county_name','County.county_id=UsersInfo.county_id')
			->view('DevFrom','dev','DevFrom.id=dev_id')
			->view('Source','source_name','Source.id=UsersInfo.from_id')
			->view('ZxTools','tool','ZxTools.id=tool_id')
			->view('Consumption',["sum('money')"=>'summoney'],'uid=UsersInfo.id')
			->view('WangdianZixun','wd_name wdname','WangdianZixun.id=wdzx_id')
			->view('QiantaiZixun','qt_name qtname','QiantaiZixun.id=qtzx_id')
			->view('Doctors','doctor','Doctors.id=Consumption.doctor_id')
			->view('Disease','disease_name','Disease.id=disease_id')
			->order('UsersInfo.addtime desc,Consumption.jz_time desc')
			->group('UsersInfo.id')
			->select(false);

		return $data;
	}

	// 处理全部用户数据给前端使用
	public function returndata(){
		if(Request()->isPost()){
			$data=$this->getUserData();
			$total=UsersInfo::count();
			$result=[
				'total'=>$total,
				'rows'=>$data
			];
			//重要，easyui的标准数据格式，数据总数和数据内容在同一个json中

	        $result=json($result);
			return $result;

			// dump($result);

		}else{
			return 'Hello World!';
		}
	}

	// 读取用户数据
	/*public function read($id=''){
	    $user = GetMainData::all();
	    dump($user);//array
	}*/

	/*public function updateUser(){
	    // if (Request()->isPost()) {
	        // $userid=input('uid');
	        $user=new UsersInfo;
	        $oneUser=$user->field('name,sex,birthday,telephone')->find(5);
	        // $oneUser=$user->field('name,sex,birthday,telephone')->get(5);

	        $data=$oneUser->toArray();

	       // dump($data);die;
	        // $this->assign('data',$data);
	        // return $this->fetch('maindata/index');


	        // $view = new View();
	        $view = new View();
			$view->name = 'thinkphp';
	        return $view->fetch('index');
	    // }
	}*/

	// 导出Excel
	public function export(){
		$objPHPExcel=new \PHPExcel;
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
		$oSheet->getColumnDimension('R')->setWidth(20);//设置列宽
		$oSheet->getStyle('A1:R1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
		$oSheet->getStyle('A1:R1')->getFill()->getStartColor()->setARGB("#0cedffb");//表头背景颜色
		$oSheet->getStyle('A1:R1')->getFont()->setBold(true);//表头字体加粗
		$arr=range('D','K');
		// var_dump($arr);
		// exit;
		for($i=0;$i<count($arr);$i++){
			$oSheet->getColumnDimension($arr[$i])->setWidth(20);
		}


		// echo $this->returndata()->data;die;
		$data=$this->getUserData();
		// dump($data);die;
		// 填充数据
		// $oSheet->fromArray($row); //此方法占内存
		$j=2;
		foreach ($data as $key => $value) {
			$oSheet->setCellValue('A'.$j,$value['name'])
			->setCellValue('B'.$j,$value['telephone'])
			->setCellValue('C'.$j,$value['sex'])
			->setCellValue('D'.$j,$value['birthday'])
			->setCellValue('E'.$j,$value['age'])
			->setCellValue('F'.$j,$value['province_name'])
			->setCellValue('G'.$j,$value['city_name'])
			->setCellValue('H'.$j,$value['county_name'])
			->setCellValue('I'.$j,$value['dev'])
			->setCellValue('J'.$j,$value['source_name'])
			->setCellValue('K'.$j,$value['tool'])
			->setCellValue('L'.$j,$value['wdname'])
			->setCellValue('M'.$j,$value['qtname'])
			->setCellValue('N'.$j,$value['doctor'])
			->setCellValue('O'.$j,$value['disease_name'])
			->setCellValue('P'.$j,$value['jz_time'])
			->setCellValue('Q'.$j,$value['summoney'])
			->setCellValue('R'.$j,$value['addtime']);
			$j++;
		}
		//

		//插入表头
		// $oSheet->insertNewRowBefore(1,1);
		$objPHPExcel->setActiveSheetIndex(0)
		                        ->setCellValue('A1', '姓名')
		                        ->setCellValue('B1', '手机号码')
		                        ->setCellValue('C1', '性别')
		                        ->setCellValue('D1', '出生日期')
		                        ->setCellValue('E1', '年龄')
		                        ->setCellValue('F1', '所在省份')
		                        ->setCellValue('G1', '所在市区')
		                        ->setCellValue('H1', '所在区县')
		                        ->setCellValue('I1', '开发渠道')
		                        ->setCellValue('J1', '信息来源')
		                        ->setCellValue('K1', '咨询工具')
		                        ->setCellValue('L1', '最近一次网电咨询师')
		                        ->setCellValue('M1', '最近一次前台咨询师')
		                        ->setCellValue('N1', '最近一次接诊医生')
		                        ->setCellValue('O1', '最近一次就诊病种')
		                        ->setCellValue('P1', '最近一次就诊时间')
		                        ->setCellValue('Q1', '消费总金额(元)')
		                        ->setCellValue('R1', '登记时间');

		$date=date("Ymd");
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="成都贝臣齿科客户消费情况表'.$date.'.xls"');
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
