<?php
return array(
    //'配置项'=>'配置值'
    'TMPL_L_DELIM'=>'<{', //左模版标签
    'TMPL_R_DELIM'=>'}>', //右模版标签

    /* 'URL_MODEL' => '2', */

    'URL_ROUTER_ON'   => true, //开启路由
    'URL_ROUTE_RULES' => array( //定义路由规则 
        /* 'Index/:id\d$'    => 'Index/read', */
        /* 'Index/:name$'    => 'Index/read', */
        /* 'Index/:year\d/:month\d'  => 'Index/archive', */
        /* '/^Index\/(\d+)$/' => 'Index/read?id=:1', */
        /* '/^Index\/(\w+)$/' => 'Index/read?name=:1', */
        /* '/^Index\/(\d{4})\/(\d{2})$/' => 'Index/archive?year=:1&month=:2', */
    ),

    //数据库配置信息 thinkPHP默认支持sae云,所以基本配置不需要
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'cityuit', // 数据库名
    'DB_USER'   => 'xxxxxx', // 用户名
    'DB_PWD'    => 'xxxxxx', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PARAMS' =>  array(), // 数据库连接参数
    'db_prefix' => 'tp_', // 数据库表前缀 
    'db_charset'=> 'utf8', // 字符集
    'db_debug'  =>  true, // 数据库调试模式 开启后可以记录sql日志

    //使用方法：S('name',$value,$time)
    'DATA_CACHE_TYPE'       =>  'Memcache',  // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
    'DATA_CACHE_TIME'       =>  7200,      // 数据缓存有效期默认7200秒 0表示永久缓存

    /* 'SHOW_PAGE_TRACE' => true, //开启事务查看 */ 
    /* 必须关闭才能通过微信接口验证 */

    //自定义常量

    'PUBLIC_LINE' => "http://localhost/csxyxzs-master/Public/",   //服务器下的Public绝对路径
    'START_DATE_OF_SCHOOL' => 'xxxxxx',   //开学前一天日期，每学期需要手动修改
   //校网接口*/
    'CITY_LINK' => 'http://yourserver:port/api/',//校网接口
    /* 'CITY_LINK' => 'http://xxxxxx',   //校网登录验证接口 */
	 'WECHAT_TOKEN' => "xxxxxx", 
   /* 'WECHAT_APPID' => "xxxxxx",      //AppID(应用ID) 为了安全只有在使用的时候设置 */
      
    /* 'WECHAT_APPSECRET' => "xxxxxx",      //AppSecret(应用密钥) */
       
    /* 'BAIDUAPI_KEY' => "7eccb198bf75c8e9ecf3ca29cc84cffd",   //百度api接口 */
    /* 'AUTH_CODE_KEY' => "xxxxxx",     //为加密算法提供key值 */
    /* 'AUTH_CODE_TIME' => "",     //key值有效时间 */
);
