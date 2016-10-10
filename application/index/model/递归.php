<?php
    //分类级别
    static protected function _cate_level($data, $pid=0, $level=1){
        $array = array();
        foreach ($data as $k => $v){
            if ($v['pid'] == $pid){
                $v['level'] = $level;
                $array[] = $v;
                unset($data[$k]);
                $array = array_merge($array, self::_cate_level($data, $v['id'],$level+1));
            }
        }
        return $array;
    }
    //菜单
    static protected function _get_child($data, $pid=0){
        $array = array();
        foreach ($data as $k => $v){
            if ($v['pid'] == $pid){
                $v['child'] = self::_get_child($data, $v['id']);
                $array[] = $v;
            }
        }
        return $array;
    }
