<?php defined('ROOT') or exit('hacker');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>数据字典</title>
<style>
body {font-family: '微软雅黑'}
.table  {border: 1px solid #000; border-collapse: collapse; width: 100%; margin: 10px 0}
.table td  {border: 1px solid #000;text-indent: 5px; word-break: break-all}
.table th  {border: 1px solid #000; background: #ccc; color: #333; height: 30px;}
.table tr:nth-child(odd){
    background-color:#E5E5E5;
}
</style>
</head>
<body>
<div style="width: 19%;float: left;position:fixed;top: 0;height: 100%;overflow: scroll;">
    <ul style="line-height: 25px;font-size: 10px;">
        <?php foreach ($data as $item) {?>
            <li>
                <a href="#<?php echo $item['TABLE_NAME']; ?>" style="color: black;"><?php echo $item['TABLE_NAME']; ?>[<?=$item['TABLE_COMMENT'];?>]</a>
            </li>
        <?php }?>
    </ul>
</div>

<div style="width: 80%;float: right;">
    <h1 align="center"><?=$database;?> <a href="index.php">返回</a></h1>
    <h3 align="right">查看历史文件:
        <select id="history_file">
            <?php foreach ($file_list as $item) {?>
                <option value="<?=$item;?>"><?=time_format($item);?></option>
            <?php }?>
        </select>
    </h3>
    <?php foreach ($data as $item) {?>
        <h2 id="<?php echo $item['TABLE_NAME']; ?>"><?php echo $item['TABLE_NAME']; ?>  [<?=$item['TABLE_COMMENT'];?>]</h2>
        <table class="table">
            <colgroup>
                <col><col><col><col><col width="180">
            </colgroup>
            <tr>
                <th>字段名称</th>
                <th style="width: 40%;">字段备注</th>
                <th>字段类型</th>
                <th>字段索引</th>
                <th>字段默认值</th>
                <th>字段编码</th>
            </tr>
            <?php foreach ($item['COLUMN'] as $v) {?>
                <tr>
                    <td><?php echo $v['COLUMN_NAME']; ?></td>
                    <td><?php echo $v['COLUMN_COMMENT']; ?></td>
                    <td><?php echo $v['COLUMN_TYPE']; ?></td>
                    <td><?php switch($v['COLUMN_KEY']){
                            case 'PRI':
                                echo $v['COLUMN_KEY'].'主键索引, 主键约束';
                                break;
                            case 'UNI':
                                echo $v['COLUMN_KEY'].'唯一索引, 唯一约束';
                                break;
                            case 'MUL':
                                echo $v['COLUMN_KEY'].'一般索引, 可以重复';
                                break;
                            default:
                                break;
                        } ?></td>
                    <td align="center"><?php echo $v['COLUMN_DEFAULT']; ?></td>
                    <td align="center"><?php echo $v['COLLATION_NAME']; ?></td>
                </tr>
            <?php }?>
        </table>
    <?php }?>
</div>

<script type="text/javascript">
(function(){

    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]);
        return null;
    }

    var history_file=document.getElementById('history_file');

    history_file.onchange=function(){
        var val = this.options[this.selectedIndex].value;

        var act  = getQueryString('act');
        var file = getQueryString('file');


        var url=window.location.origin+window.location.pathname+'?act='+act+'&file='+file+'&hisotry='+val;

        window.location=url;

    }

})();
</script>
</body>
</html>