<?php
namespace app\upload\controller;
use think\Controller;
use app\lib\exception\UploadException;
use app\upload\model\Uploads as UploadsModel;
use think\Request;
use think\Image;
class Index extends Controller{
    public function index(){
        return $this->fetch();
    }

    public function upload(Request $request){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        $num=request()->param('num');
        // dump($file);die;
        // dump($num);die;
        // dump($error = $_FILES);
        if(empty($file) && !$num){
            throw new UploadException();
        }

        $result = $this->validate(['file' => $file], ['file'=>'require|image|fileSize:6291456'],['file.require' => '请选择上传文件', 'file.image' => '非法图像文件','file.fileSize' => '图片文件大小不能超过6M']);//  20756
        if(true !== $result){
            throw new UploadException([
                'msg'=>$this->error($result)
            ]);
        }


        $image = Image::open($file);
        // 缩略图处理
        $image->thumb(800, 800, Image::THUMB_CENTER);

        // 保存图片
        $saveName = md5($request->time()) . '.' . $image->type();
        $image->save(ROOT_PATH . 'public/uploads/' . $saveName);
        dump($image);
        // $image->save(ROOT_PATH . 'public' . DS . 'uploads'.$saveName);


        /*// 移动到框架应用根目录/public/uploads/ 目录下
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

            // return "上传成功";
            return $info->getRealPath();
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }*/
    }

    public function getUploadsData()
    {
        $data=UploadsModel::where('sign_num','>',0)->select();
        return json($data);
    }
}
