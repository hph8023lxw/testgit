<?php
/**
 * Created by PhpStorm.
 * User: 何鹏辉
 * Date: 2017/11/18
 * Time: 19:34
 * Remark: ******
 */

//$content =  file_get_contents('log.txt');var_dump($content);die();

$param = $_REQUEST;

$jsonData = json_encode($param);
writeLog(json_encode($jsonData));

echo $jsonData;
/**
 * @remark  写入文件
 * @param string $content
 * @param string $file
 */
function writeLog($content = '' , $file = 'log.txt'){
    if(!is_string($content)) throw new Exception('write file data type is error');
    $myFile = fopen($file , 'w');
    fwrite($myFile , $content);
    fclose($myFile);
}

/*if(!empty($sign)){
    echo json_encode('签名验证成功');
}else{
    echo json_encode('签名验证失败');
}*/
die();