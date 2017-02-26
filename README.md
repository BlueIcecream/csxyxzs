##城院小助手3.0项目说明
>基于Thinkphp 3.2.3框架开发

###预设常量维护

微信公众号的AppID和AppSecret在获取access_token时必须设置，例如设置按钮，获取IP等  
考完试就修改开学日期常量  
元旦前修改放假新一年放假安排  
空教室查询每次课表一公布就执行SettingController->setCourse。具体注意看函数说明  
自定义按钮操作执行SettingController->setCustomize。具体设置在函数内预设  
对于四六级维护：  
一、发放准考证前将数据库用户保存的准考证号清空，发放准靠证时提示大家保存准考证号到数据库。  
二、四六级成绩出来之前将数据库中的四六级成绩清空，四六级成绩出来以后提醒大家查询四六级成绩。  
添加crontab定时任务,每天24点执行  
`0 0 * * * curl http://yourserver/csxyxzs-master/index.php/Home/Students/delEmpty`  将空教室信息从缓存清空

###客户端接口使用说明

#####图书馆查询

`$ curl http://yourserver/index.php/Home/Campus/appLibrary/title/*****`  

######响应

`{"book":[{"id":"序号","no":"","title":"书名","auther":"作者","press":"出版社","time":"出版时间","search":"藏书编号","place":"藏书位置","state":"图书状态"}]}`  查询成功

#####食堂档口查询

`$ curl http://yourserver/index.php/Home/Campus/appShitang`

######响应

`{"yy":[{"data":[{"id":"1","location":"二食堂","floor":"楼上","name":"开心小厨","telephone":"13614095859"},{"id":"编号","location":"几食堂","floor":"楼上下","name":"名字","telephone":"电话"}]}]}`  查询成功

#####档口菜单查询

`$ curl http://yourserver/index.php/Home/Campus/appCaidan/id/**`

######响应

`{"data":[{"id":"1","name":"小炒肥肠","price":"15元"},{"id":"档口编号","name":"菜名","price":"价格"}]}`  查询成功

#####四六级成绩查询

`$ curl -d 'name=姓名&zkzh=准考证号' http://yourserver/index.php/Home/Campus/appQueryCet`

######响应

`{"status":200,"result":{"name":"姓名","school":"学校","type":"等级","num":"准考证号","time":"时间年月"},"score":{"totleScore":"总分","tlScore":"听力","ydScore":"阅读","xzpyScore":"写作与翻译"}}`  查询成功  
`{"status":201,"result":"name or zkzh error"}`  姓名或准考证号出错（或为空）  
`{"status":501,"result":"api error"}`  接口问题
