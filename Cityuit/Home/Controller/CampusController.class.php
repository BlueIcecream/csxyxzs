<?php
namespace Home\Controller;
use Think\Controller;
/*
 *第二排按钮，校园服务控制实现
 */
class CampusController extends Controller {
    public function index(){
    }

    /*
     *发送提醒输入图书接口
     */
    public function askLibrary($weChat){
        $weChat->text("请输入书名（也可以输入关键字）。\n\n或输入【exit】退出操作。")->reply();
        S($weChat->getRevFrom().'_do','library','120');      //提醒输入图书时间预设2分钟 
    }

    /*
     *收到图书关键字信息处理
     */
    public function dealLibrary($weChat, $title){
        $book = array(
            "0"=>array(
                'Title'=>$title.' 查询结果',
                'Description'=>"点击查看查询结果，输入【exit】退出查询操作",
                'PicUrl'=> C('PUBLIC_LINE').'Image/library.jpg',
                'Url'=> $_SERVER['HTTP_HOST'].U("Campus/queryLibrary?title=$title")
            ),
         );
        $weChat->news($book)->reply();
    }


    /*
     *图书馆图书查询处理
     */
    public function queryLibrary(){
        $title = I("title", "");
        /* $p = I('p') ? I('p') : 2; */
        $Library = M('library_books');
        $where['title'] = array('like', '%'.$title.'%');
        $bookArr = $Library->where($where)->select();
        $this->assign('book',$bookArr);     
        $this->assign('total', count($bookArr));
        $this->assign('per', 35);
        $this->assign('p', $p);
        $this->display();
    }

    /*
     *图书馆图书查询处理，app接口
     */
    public function appLibrary(){
        $title = I("title", "");
        $Library = M('Library');
        $where['title'] = array('like', '%'.$title.'%');
        $book = $Library->where($where)->select();
        $bookArr = array("book"=>$book);
        echo json_encode($bookArr, JSON_UNESCAPED_UNICODE);
    }

    /*
     *如果是文本收到快递，默认删除缓存单号
     */
    public function resetExpress($weChat){
        S($weChat->getRevFrom().'_spress',null);
        $this->askExpress($weChat);
    }


    /*
     *快递消息处理
     */
    public function dealExpress($weChat){
        if($expressid = S($weChat->getRevFrom().'_spress')){
            //如果缓存里有快递单号，直接返回
            $this->checkExpress($weChat, $expressid);
        }else{
            $this->askExpress($weChat);
        }
    }

    /*
     *发送提醒输入快递单号接口
     */
    public function askExpress($weChat){
        $weChat->text("请输入快递单号（不用输入快递公司）。\n\n或输入【exit】退出操作。")->reply();
        S($weChat->getRevFrom().'_do','express','300');     
    }

    /*
     *发送快递查询接口
     */
    public function checkExpress($weChat, $expressid){
        $url = "http://m.kuaidi100.com/index_all.html?postid=".$expressid;
        $title = '快递单号：'.$expressid;
        $ex = array(
            "0"=>array(
                'Title'=> $title,
                'Description'=>"为了方便查询，自动记录单号。\n\n查询其它快递单号，回复【快递】",
                'PicUrl'=> C('PUBLIC_LINE').'Image/kuaidi.png',
                'Url'=> $url,
            ),
         );
        $weChat->news($ex)->reply();
        S($weChat->getRevFrom().'_do',null);   //删除操作缓存
    }

    /*
     *处理食堂查询
     */
    public function askShiting($weChat){
        $weChat->text("请输入查询几食堂\n\n或输入【exit】退出操作。")->reply();
        S($weChat->getRevFrom().'_do','shitang','120');      //缓存查几食堂 
    }

    /*
     *返回食堂信息
     */
    public function dealShitang($weChat, $num){
        $Shitang = M('Shitang');
        if(strpos($num, "2")!==false || strpos($num, "二")!==false){   //查询二食堂
            $where['location']="二食堂";
            $num = "二食堂";
        }else if(strpos($num, "3")!==false || strpos($num, "三")!==false){
            $where['location']="三食堂";
            $num = "三食堂";
        }else{
            $weChat->text("食堂不存在，请重新输入\n例：'2'或者'二'再或者'二食堂'\n\n或输入【exit】退出操作。")->reply();
            exit;
        }
        $shitangArr = $Shitang->where($where)->select();
        $this->showShitang($weChat, $shitangArr, $num);
    }

    /*
     *发送食堂档口信息格式化
     */
    public function showShitang($weChat, $shitangArr, $num){
        $shitangstring = $num."档口：\n";
        $arr = array();
        for($i=0 ; $i<count($shitangArr) ; $i++){
                $shitangstring .= $i.". ".$shitangArr[$i]['name']."\n".$shitangArr[$i]['telephone']."\n";
                $arr[$i]=$shitangArr[$i]['id'];    //存储档口编号
        }

        $shitangstring .= "\n回复对应编号查看菜单\n回复【exit】退出操作";

        S($weChat->getRevFrom().'_do','caidan','120');   //菜单操作缓存
        S($weChat->getRevFrom().'_date', json_encode($arr),'120');   //编号数据缓存
        $weChat->text($shitangstring)->reply();
    }

    /*
     *处理菜单查询
     */
    public function dealCaidan($weChat,$num){
        
        $arr = S($weChat->getRevFrom().'_date');   //编号数据缓存   这一步一般情况下必须紧跟上一步，不然没有数据，
        $arr = json_decode($arr);
        $id = $arr[$num];   //获取编号对应的数据库中编号
        if($id != ""){
            $Caidan = M('Caidan');
            $where['id']=$id;
            $caidanArr = $Caidan->where($where)->select();
            
            $this->showCaidan($weChat, $caidanArr);
        }else{
            $weChat->text("编号错误，重新输入\n\n或输入【exit】退出操作。")->reply();
        }
    }

    /*
     * 处理手机客户端菜单查询请求
     */
    public function appCaidan(){
        $idShitang= I('id','');
        $Caidan = M('Caidan');
        $where['id']=$idShitang;
        $caidanArr = $Caidan->where($where)->select();
        /* $arr = array(); */
        /* for($i=0; $i<count($caidanArr); $i++){ */
        /*     $arr += array($caidanArr[$i]['name']=>$caidanArr[$i]['price']); */
        /* } */
        $backArr = array("data"=>$caidanArr);
        echo json_encode($backArr, JSON_UNESCAPED_UNICODE);
    }

    /*
     * 处理手机客户端食堂档口查询
     */
    public function appShitang(){
        $Shitang = M('Shitang');
        $shitangArr = $Shitang->select();

        $erArr = array();  //二食堂档口
        $sanArr = array();  //三食堂档口
        for($i=0; $i<count($shitangArr); $i++){
            if($shitangArr[$i]['location'] == "二食堂"){
                $yy11[] = $shitangArr[$i];
            }
        }
        for($i=0; $i<count($shitangArr); $i++){
            if($shitangArr[$i]['location'] == "三食堂"){
                $yy22[] = $shitangArr[$i];
            }
        }
        $yy1 = array('data' => $yy11);
        $yy2 = array('data' => $yy22);
        $backArr = array("yy"=>array($yy1,$yy2));
        echo json_encode($backArr, JSON_UNESCAPED_UNICODE);
    }

    /*
     *发送档口菜单信息格式化
     */
    public function showCaidan($weChat, $caidanArr){
        $caidanstring = "菜单：";
        $arr = array();
        for($i=0 ; $i<count($caidanArr) ; $i++){
            $caidanstring .= "\n".$caidanArr[$i]['name']." ￥".$caidanArr[$i]['price'];
        }

        S($weChat->getRevFrom().'_do',null);   //删除操作缓存
        $weChat->text($caidanstring)->reply();
    }


    /*
     *小助手微信墙
     *因为文件丢失原因，目前没有该功能
     */
    public function loveWall($weChat)
    {
        $wall = array(
            "0"=>array(
                'Title' => '小助手微信墙',
                'Description'=>'表白，吐槽，心愿~',
                'PicUrl'=> C('PUBLIC_LINE').'Image/wall.jpg',
                'Url'=> 'http://csxywxq.sinaapp.com/w/'
            ),
         );
        $weChat->news($wall)->reply();
        exit;
    }

    /*
     *天气预报处理
     */
    public function dealWeather($weChat){
        $weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
        echo "星期".$weekarray[date("w")];
        $res = $this->getWeather();
       // echo $res;
        $weaArr = json_decode($res, true);
          
       // var_dump ($weaArr['HeWeather data service 3.0'][0]['daily_forecast'][0]);
         
       // $todayWea = $weaArr['retData']['today']['type'];   //今日天气
          $todayWea =$weaArr['HeWeather data service 3.0'][0]['daily_forecast'][0]['cond']['txt_d'];
         //     echo $todayWea;
        if($todayWea){   //如果数据存在或者获取正确返回天气

           
            $weather = array();
            $top = array(
                'Title' => '大连天气预报',
            );
            $weather[] = $top;   //添加头

            //$todayArr = $weaArr['retData']['today'];  //今天天气所有信息
              $todayArr = $weaArr['HeWeather data service 3.0'][0]['daily_forecast'][0];
            if(strpos($todayWea, '转') !== false){ //如果有转则根据查询时间显示图片
                $weaDay = $this->changeWeather(explode("转", $todayWea)['txt_d']);    //分割提取白天的天气并转为拼音
                $weaNight = $this->changeWeather(explode("转", $todayWea)['txt_n']);   //晚上
            }else{
                $weaDay = $weaNight = $this->changeWeather($todayWea);    //天气并转为拼音
            }
            $now = date('H', time());
            
            if($now > 17 || $now < 6){   //晚上就发送晚上的图片
                $picurl = C('PUBLIC_LINE').'Image/weather/night/'.$weaNight.'.png';
            }else{
                $picurl = C('PUBLIC_LINE').'Image/weather/day/'.$weaDay.'.png';
            }
            $today = array(
                //天气字符串连接
                //'Title'=>substr($todayArr['date'], 5).' '.$todayArr['week']."\n".$todayArr['type'].' '.$todayArr['fengxiang'].$todayArr['fengli'].' '.$todayArr['lowtemp'].'~'.$todayArr['hightemp'],
                'Title'=>substr($todayArr['date'], 5)." 星期".''.$weekarray[date("w")]."\n".$todayArr['cond']['txt_d'].' '.$todayArr['tmp']['min'].'~'.$todayArr['tmp']['max']."℃".' '.$todayArr['wind']['dir'].$todayArr['wind']['sc'],
                'PicUrl'=>$picurl,  
            );
            $weather[] = $today;    //添加今日的天气

            //$forecastWea = $weaArr['retData']['forecast'];
            $forecastWea = $weaArr['HeWeather data service 3.0'][0]['daily_forecast'];
            /* for($i=0 ; $i<count($forecastwea) ; $i++){ */    //默认四天
            $d = date("w");
            
            for($i=1 ; $i<3 ; $i++){   
                 //$d = date("w");
                 $d++;
                //后面天气直接转拼音，图片带有“转”的天气
                $picurl = C('PUBLIC_LINE').'Image/weather/day/'.$this->changeWeather($forecastWea[$i]['cond']['txt_d']).'.png';
                $forecast = array(
                    //'Title'=>substr($forecastWea[$i]['date'], 5).' '.$forecastWea[$i]['week']."\n".$forecastWea[$i]['type'].' '.$forecastWea[$i]['fengxiang'].$forecastWea[$i]['fengli'].' '.$forecastWea[$i]['lowtemp'].'~'.$forecastWea[$i]['hightemp'],
                    
                    'Title'=>substr($forecastWea[$i]['date'], 5)." 星期".''.$weekarray[$d == 7 ? 0 : ($d == 8 ? 1 : $d )]."\n".$forecastWea[$i]['cond']['txt_d'].' '.$forecastWea[$i]['tmp']['min'].'~'.$forecastWea[$i]['tmp']['max']."℃".' '.$forecastWea[$i]['wind']['dir'].$forecastWea[$i]['wind']['sc'],
                
                    'PicUrl'=>$picurl,  
                );
                $weather[] = $forecast;    //添加今日的天气
            }

            $weChat->news($weather)->reply();
        }else{
            $weChat->text("天气服务暂停使用，谢谢支持。\n回复【帮助】获取更多帮助")->reply();
        }
    }

    /*
     *获取天气接口
     */
    public function getWeather(){
        $ch = curl_init();
       // $url = 'http://apis.baidu.com/apistore/weatherservice/recentweathers?cityname=大连&cityid=101070201';
          $url = 'http://apis.baidu.com/heweather/pro/weather?city=dalian';
         // $url = 'http://apis.baidu.com/heweather/pro/attractions?cityid=CN10101010018A';
        // $url = 'https://free-api.heweather.com/x3/weather?cityid=101070201';
         $header = array(
            'apikey:'.C('BAIDUAPI_KEY'),
	   //  'apikey:7eccb198bf75c8e9ecf3ca29cc84cffd',
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);
       
        return $res;

    }

    /*
     *根据中文字天气转拼音
     */
    public function changeWeather($zhongwen){
        switch ( $zhongwen ) {
            case '暴雪':
                return 'baoxue';
                break;
            case '暴雨':
                return 'baoyu';
                break;
            case '暴雨转大暴雨':
                return 'baoyuzhuandabaoyu';
                break;
            case '大暴雨':
                return 'dabaoyu';
                break;
            case '大暴雨转特大暴雨':
                return 'dabaoyuzhuantedabaoyu';
                break;
            case '大雪':
                return 'daxue';
                break;
            case '大雪转暴雪':
                return 'daxuezhuanbaoxue';
                break;
            case '大雨':
                return 'dayu';
                break;
            case '大雨转暴雨':
                return 'dayuzhuanbaoyu';
                break;
            case '冻雨':
                return 'dongyu';
                break;
            case '多云':
                return 'duoyun';
                break;
            case '浮尘':
                return 'fuchen';
                break;
            case '雷阵雨':
                return 'leizhenyu';
                break;
            case '雷阵雨伴有冰雹':
                return 'leizhenyubanyoubingbao';
                break;
            case '霾':
                return 'mai';
                break;
            case '强沙尘暴':
                return 'qiangshachenbao';
                break;
            case '晴':
                return 'qing';
                break;
            case '沙尘暴':
                return 'shachenbao';
                break;
            case '特大暴雨':
                return 'tedabaoyu';
                break;
            case '雾':
                return 'wu';
                break;
            case '小雪':
                return 'xiaoxue';
                break;
            case '小雪转中雪':
                return 'xiaoxuezhuanzhongxue';
                break;
            case '小雨':
                return 'xiaoyu';
                break;
            case '小雨转中雨':
                return 'xiaoyuzhuanzhongyu';
                break;
            case '扬沙':
                return 'yangsha';
                break;
            case '阴':
                return 'yin';
                break;
            case '雨夹雪':
                return 'yujiaxue';
                break;
            case '阵雪':
                return 'zhenxue';
                break;
            case '阵雨':
                return 'zhenyu';
                break;
            case '中雪':
                return 'zhongxue';
                break;
            case '中雪转大雪':
                return 'zhongxuezhuandaxue';
                break;
            case '中雨':
                return 'zhongyu';
                break;
            case '中雨转大雨':
                return 'zhongyuzhuandayu';
                break;
        }
    }

    /*
     *处理四六级查询接口
     */
    public function dealCet($weChat){
        $auth = replaceStr(authcode($weChat->getRevFrom(),'ENCODE', "", 1800));    //链接有效期默认30分钟
        $cet = array(
            "0"=>array(
                'Title'=>'查询四六级成绩',
                'PicUrl'=> C('PUBLIC_LINE').'Image/cet1.png',
                'Url'=> $_SERVER['HTTP_HOST'].U("Campus/queryCetView?auth=$auth")
            ),
            "1"=>array(
                'Title'=>'准考证号怕忘了？点我',
                'Url'=> $_SERVER['HTTP_HOST'].U("Campus/saveCetView?auth=$auth")
            ),
         );
        $weChat->news($cet)->reply();
    }

    /*
     *保存四级页面
     */
    public function saveCetView(){
        $authGet = I('auth','');  
        $auth = replaceStr($authGet, false);  //将替换的字符换回来
        $openidVal = authcode($auth,'DECODE');   //只有带openidVal请求才是有效的，并且openidVal是有时效的加密
        if($openidVal){
            $this->assign('openid', $openidVal);     //已经保存过的准考证号
            $this->assign('auth',$authGet);   //用于跳转到查询页面链接使用
            $this->assign('zkzh',$this->getAllZkzh($openidVal));     //已经保存过的准考证号
            $this->display();
        }else{
            $this->assign('error','链接超时失效，请重新获取。');
            $this->display('Login:linkError');
        } 
    }

    /*
     *保存四级考号
     *注意：保存考号，不根据学号，所以一个微信号可以保存多个考号，根据openid查
     */
    public function saveCet(){
        $name = I('name',''); 
        $zkzh = I('zkzh','');
        $openid = I('openid','');
        if(!$this->isZkzh($name, $zkzh)){
            echo '201';    
        }else if($this->hasSave($name, $zkzh, $openid)){    //同样的信息已经保存，
            echo '300';
        }else{
            $cet = array(
                "name" => $name,
                "zkzh" => $zkzh,
                "openid" => $openid,
            );
            $Savecet = M('Savecet');
            $result = $Savecet->data($cet)->add();
            if(!$result){
                echo '500';   //保存出错
            }else{
                echo '200';   //保存成功
            }
        }
    }

    /*
     *获取保存的所有准考证号
     */
    public function getAllZkzh($openid){
        $Savecet = M('Savecet');
        $where['openid'] = $openid;
        $zkzhAll = $Savecet->where($where)->select();
        return $zkzhAll;
    }

    /*
     *验证准考证号是否正确
     *姓名全中文，准考证号15位数字
     */
    public function isZkzh($name, $zkzh){
        if(!eregi("[^\x80-\xff]","$name")){  //全是中文
            return preg_match("/^[0-9]{15}$/",$zkzh) ? true : false;
        }else{
            return false;
        }

    }

    /*
     *查询是否已经保存
     */
    public function hasSave($name, $zkzh, $openid){
        $Savecet = M('Savecet');
        $where['name'] = $name;
        $where['zkzh'] = $zkzh; 
        $where['openid'] = $openid;
        $cet = $Savecet->where($where)->find();
        if($cet){
            return true;
        }else{
            return false;
        }
    }

    /*
     *查询四级页面
     */
    public function queryCetView(){
        $authGet = I('get.auth','');  
        $auth = replaceStr($authGet, false);  //将替换的字符换回来
        $openidVal = authcode($auth,'DECODE');   //只有带openidVal请求才是有效的，并且openidVal是有时效的加密
        if($openidVal){
            $this->assign('auth',$authGet);
            $this->assign('zkzh',$this->getAllZkzh($openidVal));     //已经保存过的准考证号
            $this->display();
        }else{
            $this->assign('error','链接超时失效，请重新获取。');
            $this->display('Login:linkError');
        } 
    }

    /*
     *查询四级处理
     */
    public function queryCet(){
        $name = I('name',''); 
        $zkzh = I('zkzh','');
        $score = $this->getCet($name, $zkzh);   //先从数据库查
        if($score){
            $arr = json_decode($score, true);
            echo '200,'.$arr['result']['name'].','.$arr['result']['school'].','.$arr['result']['type'].','.$arr['result']['num'].','.$arr['result']['time'].','.$arr['score']['totleScore'].','.$arr['score']['tlScore'].','.$arr['score']['ydScore'].','.$arr['score']['xzpyScore'].',';
        }else{
            $student = array(     
                'name'=>$name,
                'zkzh'=>$zkzh,
            );      
            /* $resultJson = http_post(C('QUERYCET_LINK'),$student); */
            $resultJson = $this->httpGetCet($name, $zkzh);
            $arr = json_decode($resultJson, true);
            if($arr['status'] == 201){
                echo '201,';
            }else if($arr['status'] == 200){
                $this->setCet($name, $zkzh, json_encode($arr, JSON_UNESCAPED_UNICODE));
                echo '200,'.$arr['result']['name'].','.$arr['result']['school'].','.$arr['result']['type'].','.$arr['result']['num'].','.$arr['result']['time'].','.$arr['score']['totleScore'].','.$arr['score']['tlScore'].','.$arr['score']['ydScore'].','.$arr['score']['xzpyScore'].',';
            }else{
                echo '501,';
            }
        }
    }

    /*
     *客户端查询四六级成绩
     */
    public function appQueryCet(){
        header("content-Type: text/html; charset=utf-8");
        $name = I('post.name',''); 
        $zkzh = I('post.zkzh','');
        $score = $this->getCet($name, $zkzh);   //先从数据库查
        if($score){
            echo $score;
        }else{
            $resultJson = $this->httpGetCet($name, $zkzh);
            //就算是客户端查询，如果是成功查询，也要将数据保存到数据库
            $arr = json_decode($resultJson, true);
            if($arr['status'] == 200){
                $this->setCet($name, $zkzh, json_encode($arr, JSON_UNESCAPED_UNICODE));
            }
            echo $resultJson;
        }
    }

    /*
     *从数据库拿成绩
     */
    public function getCet($name, $zkzh){
        $Querycet = M('Querycet');
        $where['name'] = $name;
        $where['zkzh'] = $zkzh;
        $score = $Querycet->where($where)->getField('score');
        if($score){
            return $score;
        }else{
            return false;
        }

    }

    /*
     *数据库保存四六级成绩
     */
    public function setCet($name, $zkzh, $score){
        $Querycet = M('Querycet');
        $data['name'] = $name;
        $data['zkzh'] = $zkzh;
        $data['score'] = $score;
        $Querycet->add($data);
    }


    /*
     *四六级爬虫接口
     */
    public function httpGetCet($name, $zkzh){
        header("content-Type: text/html; charset=utf-8");

        $url="http://www.chsi.com.cn/cet/query?zkzh=$zkzh&xm=$name";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_REFERER,'http://www.chsi.com.cn');
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $allHtml = curl_exec($ch);
        curl_close($ch);
        /* echo $allHtml; */
        $contents = preg_replace("/([\r\n|\n|\t| ]+)/",'',$allHtml);  //为更好地避开换行符和空格等不定因素的阻碍，有必要先清除采集到的源码中的换行符、空格符和制表符
        $preg = '/<th>姓名.*table/U';
        if(preg_match($preg, $contents, $out)){    //如果存在匹配，证明查询成功，并且将table内容存入$out中
            $preg = '/<td.*>(.*)<\/td>/U';
            preg_match_all($preg, $out[0], $out1);   //$out1保存每项值,惟独成绩一项需要特殊处理
            $name = $out1[1][0];
            $school = $out1[1][1];
            $type = $out1[1][2];
            $num = $out1[1][3];
            $time = $out1[1][4];

            $preg = '/：<\/span>(.*)</U';
            preg_match_all($preg, $out1[0][5], $out2);   //从$out[0][5]获得个部分成绩，存入$out[2]中
            $tlScore = $out2[1][0];
            $ydScore = $out2[1][1];
            $xzpyScore = $out2[1][2];
            if($name!=NULL&&$school!=NULL&&$type!=NULL&&$num!=NULL&&$time!=NULL&&$tlScore!=NULL&&$ydScore!=NULL&&$xzpyScore!=NULL){    //如果走到这一步，还有空值，说明是正则匹配有所改动
                $totleScore = (String)($tlScore + $ydScore + $xzpyScore);
                $score = array("totleScore"=>$totleScore,"tlScore"=>$tlScore,"ydScore"=>$ydScore,"xzpyScore"=>$xzpyScore);
                $result = array("name"=>$name,"school"=>$school,"type"=>$type,"num"=>$num,"time"=>$time);
                $back = array("status"=>200,"result"=>$result,"score"=>$score);
                $backJson = json_encode($back, JSON_UNESCAPED_UNICODE);
                /* echo $backJson; */
                return $backJson;
            }else{
                $back = array("status"=>501,"result"=>"api error");
                $backJson = json_encode($back, JSON_UNESCAPED_UNICODE);
                /* echo $backJson; */
                return $backJson;
            }
        }else if(preg_match_all('/[请输入15位的准考证号|姓名输入有误|无法找到对应的分数，请确认你输入的准考证号及姓名无误]/',$contents)){
            $back = array("status"=>201,"result"=>"name or zkzh error");    //姓名或准考证号有问题
            $backJson = json_encode($back, JSON_UNESCAPED_UNICODE);
            /* echo $backJson; */
            return $backJson;
        }else{
            $back = array("status"=>501,"result"=>"api error");   //接口出问题
            $backJson = json_encode($back, JSON_UNESCAPED_UNICODE);
            /* echo $backJson; */
            return $backJson;
        }

    }
   

}
