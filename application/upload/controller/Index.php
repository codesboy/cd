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

    private function upload(){
        // 获取表单上传文件
        $file = request()->file('file');
        $num=request()->param('num');

        // 针对getimagesize(): Read error!异常
        try {
            // 上传文件验证
            $result = $this->validate(['file' => $file], ['file'=>'require|image|fileSize:6291456'],['file.require' => '请选择上传文件', 'file.image' => '非法图像文件','file.fileSize' => '图片文件大小不能超过6M']);//  20756
        } catch (\Exception $e) {
            throw new UploadException([
                'code'=>0,
                'msg'=>$e->getMessage()
            ]);
        }

        // 验证不通过
        if(true !== $result){
            throw new UploadException([
                'msg'=>$this->error($result)
            ]);
        }

        $image = Image::open($file);
        // 图片压缩处理
        $image->thumb(800, 800, Image::THUMB_CENTER);

        // 唯一文件名 微妙md5加密
        $saveName = md5(uniqid(microtime(true),true)) . '.' . $image->type();
        // 保存图片
        $image->save(ROOT_PATH . 'public/uploads/' . $saveName);
        if(empty($image)){
            return;
        }

        $arr=[];
        $arr['sign_num']=$num;
        $arr['img_url']=$saveName;
        return $arr;

    }


    public function saveUploadFile(){
        $data=$this->upload();
        if(!empty($data)){
            $res=UploadsModel::create($data);
            if(!$res){
                throw new UploadException([
                    'msg'=>'上传失败',
                    'code'=>400,
                    'errorCode'=>6000
                ]);
            }else{
                throw new UploadException([
                    'msg'=>'上传成功',
                    'code'=>200,
                    'errorCode'=>0
                ]);
            }
        }
    }

    public function getUploadsData()
    {
        $data=UploadsModel::where('sign_num','>',0)->select();
        return $this->fetch();
        // return json($data);
    }

    public function test(){
        var_dump(getimagesize('C:\Users\admin\Desktop\2.jpg'));
    }


}
