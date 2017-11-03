<?php

if ( PRODUCTION  === true){
    //正式环境

}elseif(PRODUCTION === 0){
    // 预正式环境

} else{
    //测试环境
    define('CLOUD_PFX_PATH',APP_PATH.'Common/Lib/Cloud/certs/');
    return [
        'COULD_CONFIG' => [
            'sysSid' => '100009001000',                             //商户号
            'accountSetNo' => '12985739202038',                             //商户号
            'pfxUrl' => CLOUD_PFX_PATH.'100009001000.pfx',          //证书文件路径
            'pfxPwd' => '900724',                                   //证书密码
            'sysUrl' => 'http://122.227.225.142:23661/service/soa', //api测试路径
        ]
    ];

}