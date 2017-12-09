<?php
/*
*mysql表结构处理类
*创建数据表，增加，编辑，删除表中字段
*
*/
class MysqlManage{
    /*
    *创建数据库，并且主键是aid
    *table要查询的表名
    */
    function createTable($table){
        $sql="CREATE TABLE IF NOT EXISTS`$table`(`aid` INT NOT NULL primarykey) ENGINE = InnoDB;";
        M()->execute($sql);
        $this->checkTable($table);
    }

    /*
    *检测表是否存在，也可以获取表中所有字段的信息
    *table要查询的表名
    *return表里所有字段的信息
    */
    function checkTable($table){
        $sql="desc `$table`";
        $info=M()->execute($sql);
        return $info;
    }

    /*
    *检测字段是否存在，也可以获取字段信息(只能是一个字段)
    *table表名
    *field字段名
    */
    function checkField($table,$field){
        $sql='desc `$table` $field';
        $info=M()->execute($sql);
        return $info;
    }

    /*
    *添加字段
    *table表名
    *info字段信息数组array
    *return字段信息array
    */
    function addField($table,$info){
        $sql="alter table` $table` add";
        $sql.=$this->filterFieldInfo();
        M()->execute($sql);
        $this->checkField($table,$info['name']);
    }

    /*
    *修改字段
    *不能修改字段名称，只能修改
    */
    function editField($table,$info){
        $sql="altertable`$table`modify";
        $sql.=$this->filterFieldInfo($info);
        M()->execute($sql);
        $this->checkField($table,$info['name']);
    }

    /*
    *字段信息数组处理，供添加更新字段时候使用
    *info[name]字段名称
    *info[type]字段类型
    *info[length]字段长度
    *info[isNull]是否为空
    *info['default']字段默认值
    *info['comment']字段备注
    */
    public function filterFieldInfo($info){
        if(!is_array($info))
            return $newInfo=array();
        $newInfo['name']=$info['name'];
        $newInfo['type']=$info['type'];
        switch($info['type']){
            case 'varchar':
            case 'char':
                $newInfo['length']=empty($info['length'])?100:$info['length'];
                $newInfo['isNull']=$info['isNull']==1?'NULL':'NOTNULL';
                $newInfo['default']=empty($info['default'])?'':'DEFAULT'.$info['default'];
                $newInfo['comment']=empty($info['comment'])?'':'COMMENT'.$info['comment'];
            case 'int':
                $newInfo['length']=empty($info['length'])?7:$info['length'];
                $newInfo['isNull']=$info['isNull']==1?'NULL':'NOTNULL';
                $newInfo['default']=empty($info['default'])?'':'DEFAULT'.$info['default'];
                $newInfo['comment']=empty($info['comment'])?'':'COMMENT'.$info['comment'];
            case 'text':
                $newInfo['length']='';
                $newInfo['isNull']=$info['isNull']==1?'NULL':'NOTNULL';
                $newInfo['default']='';
                $newInfo['comment']=empty($info['comment'])?'':'COMMENT'.$info['comment'];
        }
        $sql=$newInfo['name'].''.$newInfo['type'];
        $sql.=(!empty($newInfo['length']))?($newInfo['length'])."":'';
        $sql.=$newInfo['isNull'].'';
        $sql.=$newInfo['default'];
        $sql.=$newInfo['comment'];
        return $sql;
    }

    /*
    *删除字段
    *如果返回了字段信息则说明删除失败，返回false，则为删除成功
    */
    function dropField($table,$field){
        $sql="alter table `$table` drop column $field";
        M()->execute($sql);
        $this->checkField($table,$field);
    }
    /*
    *获取指定表中指定字段的信息(多字段)
    */
    function getFieldInfo($table,$field){
        $info=array();
        if(is_string($field)){
            $this->checkField($table,$field);
        }else{
            foreach($field as $v){
                $info[$v]=$this->checkField($table,$v);
            }
        }
        return $info;
    }
}