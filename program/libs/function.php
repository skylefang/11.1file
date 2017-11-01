<?php
class unit{
    // 两个_
    function __construct()
    {
       $this->str='';
       // 把父级id当做了属性
       $this->parentid = null;
    }
    /* 栏目数
     * cateTree($pid,$db,$table,$flag) 对应
     * cateTree(0,$mysql,'category',0)
     * $pid:父栏目  0是整个网站的栏目数
     * $db：数据库叫做资源，用来获取数据  $mysql是资源
     * $table：表名
     * $flag：规定子栏目，用来指明是谁的子栏目 标记
     * function cateTree 用来创建栏目数
     * */
    // 创建栏目数
    function cateTree($pid,$db,$table,$flag,$current=null){
        $flag++;
        // 如果current有值
        if($current){
            $sql = "select * from {$table} where cid={$current}";
            /*$sql = "select pid from {$table} where cid={$current}";*/
            $data = $db->query($sql)->fetch_assoc();
            $this->parentid = $data['pid'];
        }

        // 查询  {$table}  与  $table 效果相同 {} 写上也不会显示
        $sql = "select * from {$table} where pid={$pid}";
        $result = $db->query($sql);

        while($row = $result->fetch_assoc()){
            // str_repeat() 是函数 php是面向过程化的语言 传两个参数，重复什么，谁重复
            // 也可写<option value='{$row['cid']}'>$flag{$row['cname']}</option> 是数字
            $heng = str_repeat('-',$flag);

            // 当前栏目的父级id，变成选中状态  selected使选中
            if($row['cid'] == $this->parentid){
                $this->str .="
                   <option value='{$row['cid']}' selected>{$heng}{$row['cname']}</option>
                  ";
            }else{
                $this->str .="
            
            <option value='{$row['cid']}'>{$heng}{$row['cname']}</option>
            ";
            }

            // 递归
            $this->cateTree($row['cid'],$db,$table,$flag,$current=null);
        }
        return $this->str;
    }

    // 创建表
    function cateTable($db,$table){
        $sql = "select * from $table";
        $data = $db->query($sql)->fetch_all(MYSQLI_ASSOC);
        for($i=0;$i<count($data);$i++){
            $this->str .="
            <tr>
                <td>{$data[$i]['cid']}</td>
                <td>{$data[$i]['cname']}</td>
                <td>{$data[$i]['pid']}</td>
                <td>
                   <a href=\"deleteCategory.php?cid={$data[$i]['cid']}\" 
                   class=\"btn\">删除</a>
                   <a href=\"updateCategory.php?cid={$data[$i]['cid']}\" 
                   class=\"btn btnAdd\">修改</a>
                </td>
            </tr>
            ";
        }
        return $this->str;
    }

    // 选择一个进行修改
    function selectOne($db,$table,$id,$attr){
        $sql = "select $attr from $table where cid='$id'";
        $data = $db->query($sql)->fetch_assoc();
        $cname = $data[$attr];
        return $cname;
    }
}
