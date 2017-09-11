<?php
namespace app\upload\controller;
use think\Controller;
use think\Exception;
use app\upload\model\Uploads as UploadsModel;
class Index extends Controller{
    public function index(){
        return $this->fetch();
    }

    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        $num=request()->param('num');
        // dump($file);die;
        // dump($num);die;
        // dump($error = $_FILES);
        if(!$file && !$num){
            throw new Exception('上传失败');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $data=[
                'sign_num'=>$num,
                'img_url'=>$info->getSaveName()
            ];
            $res=UploadsModel::create($data);
            if(!$res){
                return "上传失败";
            }

            return "上传成功";
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }

    public function getUploadsData()
    {
        $data=UploadsModel::where('sign_num','>',0)->select();
        return json($data);
    }
}