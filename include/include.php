<?php
######################加载视图VIEW#######################extract($_GET);#无用?? URL包含参数
$whiteList=config('whiteList');
$passLogin=\core\Route::match($whiteList);

if(!$passLogin) {

	\core\Common::AUTH();
/*
	$isAdmin=in_array($USER,$adminArray);
	if($isAdmin) define('ADMIN',true);

	\Ctrl\Pool::userOnline($USER);

    $needVip=\core\Route::match($vipList);
    if($needVip) \Ctrl\Pool::userVip($USER);*/
}