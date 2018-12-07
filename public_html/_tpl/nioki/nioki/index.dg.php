<?



$GLOBALS['oauthkey'] = $this->_regedit->read('oauthkey',md5(rand()));

 if ( substr_count(strtoupper($_SERVER["HTTP_USER_AGENT"]),'MSIE 7.')>0 || substr_count(strtoupper($_SERVER["HTTP_USER_AGENT"]),'MSIE 6.')>0 ){
    include_once (_DR_.'/dg_system/ieblock/ie.php');
 }else{
    if ($_POST['token']!=''){
    $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
    $user = json_decode($s, true);
            if ($user['network']!='' AND $user['identity']!='' AND $user['first_name']!=''){
                
                $info_user_network = $this->_Q->QA("SELECT * FROM <||>user WHERE `login`='".$user['network'].":".$user['identity']."' AND `pass`='".md5($user['network'].$user['identity'].$GLOBALS['oauthkey'])."' LIMIT 1");
                if ($info_user_network['id']==''){
                    
                    
                    $arr='';
                    $arr['name'] = $user['first_name'].' '.$user['last_name'];
                    $arr['login'] = $user['network'].":".$user['identity'];
                    $arr['social'] = $user['network'];
                    $arr['datereg'] = time();
                    $arr['act']=1;
                    $arr['pass']=md5($user['network'].$user['identity'].$GLOBALS['oauthkey']);
                    $this->_Q->_table = 'user';
                    $this->_Q->_arr = $arr;
                    $this->_Q->QI();
                    $NEWUSER = true; 
                    
                }
                
                if ($this->_USER->login($user['network'].":".$user['identity'],$user['network'].$user['identity'].$GLOBALS['oauthkey'])){
                    
                    	 
                    
                    header("Location:".$_SERVER["REQUEST_URI"]);
                }else{
                    echo 'erorr';
                }
            }
            
    } 
    
    $nomobile = false;
//if ($this->_mobile || array_key_exists('mobile',$_GET)){
    if ($nomobile){
    if (!$this->_ajax){
    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
	<meta charset="utf-8" />
    <meta name="yandex-verification" content="40d62da8cbefe674" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
    <link charset="utf-8" rel="stylesheet" media="all" href="/_tpl/nioki/nioki/ui/ui/jquery-ui-1.8.23.custom.css" />
    <link charset="utf-8" rel="stylesheet" href="/dg_system/dg_css/dg.css" />
    <link rel="stylesheet" href="<?=_TPL_?>/css/mobile.css" type="text/css" media="screen, projection" />
    
    <script type="text/javascript" src="<?=_TPL_?>/js/mobile.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
    
</head>
<body>
<header>
<div class="dg_table w100">
	<div class="dg_tr">
		<div class="dg_td w20"><a href="/"><img src="<?=_TPL_?>/img/logo.png" width="150" /></a></div>
        <div class="dg_td w65"><div id="title">Сияма — доставка суши в Атырау</div><div>Прием заказов — +7(701)025-5-025</div></div>
		<div class="dg_td w15"><a href="#" id="login"><? if ($this->_infoUSER['id']=='') echo 'вход'; else echo 'Я'; ?></a></div>
	</div>
</div>
</header>
<div id="main">
    <?if ($this->_infoPAGE['main']==1){
        
        
        if ($GLOBALS['dgshop']->price_sale(100)>0){
                         
                        //if ($GLOBALS['dgshop']->_sale_type==2){
                            ?>
                                <div id="sale" class="box">
                                    <div class="head">Ваша скидка!</div>
                                    <p>Скидка на все продукты составляет <?=$GLOBALS['dgshop']->_sale_info?>%</p>
                                </div>
                            <?
                        //}
                        if ($GLOBALS['dgshop']->_sale_type==1){/*
                            $d = '';
                            $sale=0;
                            $h = date("G");
                            if ($h>=1 AND $h<5 AND $sale==0){ $sale='05';  }
                            if ($h>=8 AND $h<10 AND $sale==0){ $sale=10; }
                            if ($h>=13 AND $h<17 AND $sale==0){ $sale=17;  }
                            if ($sale>0){
                            ?>
                                <div id="sale" class="box">
                                    <div class="head">Текущая скидка <?=$GLOBALS['dgshop']->_sale_info?>%</div>
                                    <div style="text-align: center; font-size: 120%;">Акция завершится через:</div>
                                    <div id="timer"></div>
                                    <script>
                                    
                                    var stop = <?=strtotime(date("Y-m-d")." ".$sale.":00:00")?>;
                                    var now = <?=time()?>;	
                                    var left = 0;
                                    var timer = '';
                                    function t(){
                                        now = now+1
                                        sec = stop-now;
                                        //var t = Math.floor(sec / 3600) + " : " + (Math.floor(sec / 60) - (Math.floor(sec / 3600) * 60)) + " : " + sec % 60
                                        h = Math.floor(sec / 3600); if (h<10) h = '0'+h;
                                        m = (Math.floor(sec / 60) - (Math.floor(sec / 3600) * 60)); if (m<10) m = '0'+m;
                                        s = sec % 60; if (s<10) s = '0'+s;
                                        $("#timer").text(h+':'+m+':'+s)
                                        if (sec<=0) {
                                            clearInterval(timer);
                                            //alert("Акция закончилась");
                                            $("#sale").remove();
                                            }
                                    }
                                    $(document).ready(function()	{
                                    	
                                         t();
                                         timer = setInterval('t()',1000);
                                         
                                    				});
                                    </script>
                                </div>
                            <?
                            
                            }*/
                        }
                        
                    }
        
        
        
        ?>
    
    <div id="cat">
    
    <?=$this->mod("r")?>
    <div class="clear"></div>
    <h1>ингредиенты</h1>
    <ul id="r">
                <li<? if ($_GET['w']=='l') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=l">Лосось</a></strong><a href="/cat/all/?w=l"><img src="/i_image/9c94902656a3be5.jpg" alt="Лосось" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='t') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=t">Тунец</a></strong><a href="/cat/all/?w=t"><img src="/i_image/c3e3fda70d0b1d0.jpg" alt="Тунец" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='kl') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=kl">Копченый лосось</a></strong><a href="/cat/all/?w=kl"><img src="/i_image/79dd50e8fe6c7cd.jpg" alt="Копченый лосось" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='ku') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=ku">Копченый угорь</a></strong><a href="/cat/all/?w=ku"><img src="/i_image/6800495125c8ef9.jpg" alt="Копченый угорь" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='o') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=o">Осьминог</a></strong><a href="/cat/all/?w=o"><img src="/i_image/859c21a455e9b3d.jpg" alt="Осьминог" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='k') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=k">Краб</a></strong><a href="/cat/all/?w=k"><img src="/i_image/356668b8594a949.jpg" alt="Краб" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='g') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=g">Гребешок</a></strong><a href="/cat/all/?w=g"><img src="/i_image/4964d687f5693bd.jpg" alt="Гребешок" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='ka') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=ka">Кальмар</a></strong><a href="/cat/all/?w=ka"><img src="/i_image/7d63a43b71dbdee.jpg" alt="Кальмар" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='kr') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=kr">Креветка</a></strong><a href="/cat/all/?w=kr"><img src="/i_image/5cc5017a30df49b.jpg" alt="Креветка" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='kur') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=kur">Курица</a></strong><a href="/cat/all/?w=kur"><img src="/i_image/d9ce62a8e476d26.jpg" alt="Курица" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='ug') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=ug">Утиная грудка</a></strong><a href="/cat/all/?w=ug"><img src="/i_image/5b7c497104e0ca8.jpg" alt="Утиная грудка" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='go') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=go">Говядина</a></strong><a href="/cat/all/?w=go"><img src="/i_image/dab3c8848e6f6a5.jpg" alt="Говядина" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='s') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=s">Свинина</a></strong><a href="/cat/all/?w=s"><img src="/i_image/2d44ace98ff3a20.jpg" alt="Свинина" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='gy') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=gy">Говяжий язык</a></strong><a href="/cat/all/?w=gy"><img src="/i_image/c0c77ee36a0db71.jpg" alt="Говяжий язык" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='hot') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=hot">Острые</a></strong><a href="/cat/all/?w=hot"><img src="/files/nioki/img/hot.jpg" alt="Острые" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='veg') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=veg">Вегетарианские</a></strong><a href="/cat/all/?w=veg"><img src="/files/nioki/img/veg.jpg" alt="Вегетарианские" width="100" height="100" /></a></li>
            </ul>
    </div>
    
    <?}else{
        echo $this->content();
    }?>
    
    
    
    
    <div class="clear"></div>
</div>
<footer><span id="basket_info"><?=$GLOBALS['dgshop']->basket_info()?></span></footer>
<div id="content"><div id="c"><?
if ($this->_infoPAGE['main']!=1) echo $this->content();
?></div></div>
<div id="auth_box"   title="Регистрация / Вход">   <?
                        if ($this->_infoUSER['id']==''){
                            
                            ?>
                            
                                
                                
                                <form method="post" id="auth_box_form" action="<?=$GLOBALS['dgshop']->_page_url?>?func=auth&re=<?=urlencode($_SERVER["REQUEST_URI"])?>">
                                                    <p id="auth_box_form_fio" style="display: none;">Ф.И.О<br /><input type="text" name="name" /></p>
                                                    <p>e-mail<br /><input type="email" name="mail" id="mail" /></p>
                                                    <p>Пароль<br /><input type="password" name="pass"  id="pass"  /></p>
                                                    <p><input type="submit" name="go" id="auth_box_form_go" value="Вход" /> <a href="<?=$GLOBALS['dgshop']->_page_url?>?func=reg&re=<?=urlencode($_SERVER["REQUEST_URI"])?>" id="regauthb">регистрация</a></p>
                                            </form>
                                    <p>&nbsp;</p>
                                    
                                     
                                                <script src="http://ulogin.ru/js/ulogin.js"></script>
                                                <div id="uLogin" x-ulogin-params="display=panel;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"])?>"></div>
                                                
                                    <p align="center"><a href="#" id="closelogin">закрыть</a></p>
                                    
                                 
                            <?
                            
                        }else{
                            ?>
                            <a href="<?=$GLOBALS['dgshop']->_page_url?>?func=profile" class="a_button"><?=$this->_infoUSER['name']?></a> <a href="<?=$GLOBALS['dgshop']->_page_url?>?func=logout" class="logout">выход</a>
                            <p align="center"><a href="#" id="closelogin">закрыть</a></p>
                            <?}?>
                         </div>
                         <!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter27991116 = new Ya.Metrika({id:27991116,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/27991116" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>    
    
    <?}else{?>

    <?
        echo $this->content();
    }
    
}   else {        
    
 
    
    
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="apple-itunes-app" content="app-id=1214593007" />
	<meta charset="utf-8" />
    <meta name="yandex-verification" content="40d62da8cbefe674" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title>Сияма — доставка суши в Атырау / <?=$this->_title?></title>
     <?
    
        if (is_array($GLOBALS['_OG'])){
            
            
            ?>
            
                <meta property="og:title" content="<?=htmlspecialchars($GLOBALS['_OG']['title'])?> / Сияма — доставка суши в Астрахани"/>
                <meta property="og:description" content="<?=htmlspecialchars($GLOBALS['_OG']['des'])?>"/>
                <meta property="og:url" content="<?=$GLOBALS['_OG']['url']?>" />
                <?
                    if ($GLOBALS['_OG']['image']!=''){
                        ?>
                        <meta property="og:image" content="<?=$GLOBALS['_OG']['image']?>" />
                        <?
                        
                    }
                ?>
            <?
            
        }
    
    ?>
	<?=$this->head()?>
    <!--[if lte IE 6]><link rel="stylesheet" href="<?=_TPL_?>/css/style_ie.css" type="text/css" media="screen, projection" /><![endif]-->
     <script type="text/javascript" src="/dg_system/dg_func/lb/js/jquery.lightbox-0.5.min.js"></script> 
     <link charset="utf-8" rel="stylesheet" media="all" href="/dg_system/dg_func/lb/css/jquery.lightbox-0.5.css" /> 
         <script>
         $(document).ready(function()	{
         	$("a[href$=jpg],[href$=jpeg],a[href$=png],a[href$=gif],a[href$=JPG],[href$=JPEG],a[href$=PNG],a[href$=GIF]").lightBox({fixedNavigation:false});
         				})
         </script>  
      <link charset="utf-8" rel="stylesheet" media="all" href="/_tpl/nioki/nioki/css/v2.css" />
</head>

<body>

<div id="wrapper">

	<header id="header">
	   <div class="dg_table w100">
    	<div class="dg_tr">
    		<div class="dg_td w40 l">
                <div class="h">
                    <a href="/cat/">On-line заказ</a>  <a href="/call-back/" class="callback">Мы вам перезвоним</a>
                    
                    <nav id="SelectCity">
                        <h2>Атырау</h2>
                        <ul id="SelectCityU">
                            <nav>
                                <h4>Россия</h4>
                                <li><a href="http://astrakhan.siyama.ru" style="color: #ff0000;">Астрахань</a></li>
                                <li><a href="http://voronezh.siyama.ru">Воронеж</a></li>
                            </nav>
                            <nav>
                                <h4>Казахстан</h4>
                                <li><a href="http://kz.siyama.ru">Атырау</a></li>
                            </nav>
                        </ul>
                    </nav>
                    
                    <div>Прием заказов<br /><address>+7(701)025-5-025</address><br /><span class="min">Минимальная сумма заказа 2000т.</span></div>
                </div>
            </div>
            <div class="dg_td w20"><a href="/"><img src="<?=_TPL_?>/img/logo.png" /></a></div>
    		<div class="dg_td w40 r">
            <div class="h">
                    <?
                        if ($this->_infoUSER['id']==''){
                            
                            ?> <a href="#" class="a_button" id="openauth">Регистрация / Вход</a>
                           
                                <div id="auth_box" style="display: none;"  title="Регистрация / Вход">
                                    
                                    <table width="100%" cellpadding="5" cellspacing="5">
                                        <tr>
                                            <td width="80%"  valign="top">
                                            <form method="post" id="auth_box_form" action="<?=$GLOBALS['dgshop']->_page_url?>?func=auth&re=<?=urlencode($_SERVER["REQUEST_URI"])?>">
                                                    <p id="auth_box_form_fio" style="display: none;">Ф.И.О<input type="text" name="name" /></p>
                                                    <p>e-mail<br /><input type="email" name="mail" id="mail" /></p>
                                                    <p>Пароль<br /><input type="password" name="pass"  id="pass"  /></p>
                                                    <p><input type="submit" name="go" id="auth_box_form_go" value="Вход" /> <a href="<?=$GLOBALS['dgshop']->_page_url?>?func=reg&re=<?=urlencode($_SERVER["REQUEST_URI"])?>" id="regauthb">регистрация</a></p>
                                                    <p><a href="/cat/order/?func=repass">забыли пароль?</a></p>
                                            </form>
                                            </td>
                                            <td  valign="top">
                                                
                                                <script src="http://ulogin.ru/js/ulogin.js"></script>
                                                <div id="uLogin" x-ulogin-params="display=panel;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"])?>"></div>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </div>
                            <?
                            
                        }else{
                            ?>
                            <a href="<?=$GLOBALS['dgshop']->_page_url?>?func=profile" class="a_button">Я</a> <a href="<?=$GLOBALS['dgshop']->_page_url?>?func=logout" class="logout">выход</a>
                            <?
                            //$totalclearorder = $this->_Q->QN("SELECT * FROM <||>dg_shop__orders_group WHERE `user_id`=".$this->_infoUSER['id']." AND (`fio`='' OR `address_street`='' OR `address_street` is NULL  OR `address_home`='' OR `address_home` is NULL OR `tel`='' OR `fio` is NULL OR `tel` is NULL)");
                            
                            if ($totalclearorder>0) echo '<br /><span class="warning"><strong>Внимание!</strong> У вас есть <a href="'.$GLOBALS['dgshop']->_page_url.'">заявки без заполненных данных</a>!</span>';
                        }
                    ?>
                    
                    
                    <div class="bas">
                        <span id="openminibs"></span>
                        <p><strong>Корзина</strong></p>
                        <span id="basket_info"><?=$GLOBALS['dgshop']->basket_info()?></span>
                    </div>
                    <div id="minibas">
                        <?=$GLOBALS['dgshop']->minibasket()?>
                    </div>
            </div>
            </div>
    	</div>
    </div>
    </header><!-- #header-->
    <div id="siua_v"></div>
    <?=$this->mod("navig")?>
	<div id="content">
		<div class="content">
          <? if ($this->_infoPAGE['id']!=6){ ?>
            <div id="cat_b">
            <a href="#r_cat" <? if ($_GET['w']=='') echo 'class="act"'; ?>>категории</a>
            <a href="#r_i" <? if ($_GET['w']!='') echo 'class="act"'; ?>>ингредиенты</a>
           </div>
           <div id="menubox"> 
            <div id="menu">
                <div id="larr"></div>
                <div id="rarr"></div>
                <div id="m"></div>
            </div>
           </div>
          
           <div id="r_cat" style="display: none;" tabindex="<? if ($_GET['w']=='') echo '0'; else echo '1'; ?>"><?=$this->mod("r")?></div>
           <div id="r_i" style="display: none;" tabindex="<? if ($_GET['w']!='') echo '0'; else echo '1'; ?>">
            <ul id="r">
                <li<? if ($_GET['w']=='l') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=l">Лосось</a></strong><a href="/cat/all/?w=l"><img src="/i_image/9c94902656a3be5.jpg" alt="Лосось" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='t') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=t">Тунец</a></strong><a href="/cat/all/?w=t"><img src="/i_image/c3e3fda70d0b1d0.jpg" alt="Тунец" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='kl') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=kl">Копченый лосось</a></strong><a href="/cat/all/?w=kl"><img src="/i_image/79dd50e8fe6c7cd.jpg" alt="Копченый лосось" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='ku') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=ku">Копченый угорь</a></strong><a href="/cat/all/?w=ku"><img src="/i_image/6800495125c8ef9.jpg" alt="Копченый угорь" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='o') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=o">Осьминог</a></strong><a href="/cat/all/?w=o"><img src="/i_image/859c21a455e9b3d.jpg" alt="Осьминог" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='k') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=k">Краб</a></strong><a href="/cat/all/?w=k"><img src="/i_image/356668b8594a949.jpg" alt="Краб" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='g') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=g">Гребешок</a></strong><a href="/cat/all/?w=g"><img src="/i_image/4964d687f5693bd.jpg" alt="Гребешок" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='ka') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=ka">Кальмар</a></strong><a href="/cat/all/?w=ka"><img src="/i_image/7d63a43b71dbdee.jpg" alt="Кальмар" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='kr') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=kr">Креветка</a></strong><a href="/cat/all/?w=kr"><img src="/i_image/5cc5017a30df49b.jpg" alt="Креветка" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='kur') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=kur">Курица</a></strong><a href="/cat/all/?w=kur"><img src="/i_image/d9ce62a8e476d26.jpg" alt="Курица" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='ug') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=ug">Утиная грудка</a></strong><a href="/cat/all/?w=ug"><img src="/i_image/5b7c497104e0ca8.jpg" alt="Утиная грудка" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='go') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=go">Говядина</a></strong><a href="/cat/all/?w=go"><img src="/i_image/dab3c8848e6f6a5.jpg" alt="Говядина" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='s') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=s">Свинина</a></strong><a href="/cat/all/?w=s"><img src="/i_image/2d44ace98ff3a20.jpg" alt="Свинина" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='gy') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=gy">Говяжий язык</a></strong><a href="/cat/all/?w=gy"><img src="/i_image/c0c77ee36a0db71.jpg" alt="Говяжий язык" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='hot') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=hot">Острые</a></strong><a href="/cat/all/?w=hot"><img src="/files/nioki/img/hot.jpg" alt="Острые" width="100" height="100" /></a></li>
                <li<? if ($_GET['w']=='veg') echo ' class="act"'; ?>><strong><a href="/cat/all/?w=veg">Вегетарианские</a></strong><a href="/cat/all/?w=veg"><img src="/files/nioki/img/veg.jpg" alt="Вегетарианские" width="100" height="100" /></a></li>
            </ul>
           </div>
           <?}?>
           
           <? if ($this->_infoPAGE['main']==1){ ?>
           <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td width="520" valign="top">
                    
                    <?=$this->mod('banner')?>
                    
                     
                    <p><?=$this->mod('new')?></p>
                
                </td>
                <td valign="top"><div class="box">
                        <div class="head">Уважаемые клиенты!</div>
                        <?=$this->content()?>
                        
                        <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>

<!-- VK Widget -->
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 0, width: "auto", height: "200", color1: '101921', color2: 'FFFFFF', color3: 'F00202'}, 75621522);
</script>
                        
                    </div>  
                    
                    </td>
            </tr>
           </table><?}else{
            ?>
            
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td valign="top" class="cnt"><?=$this->content()?>
<?
if ($this->_infoPAGE['id']==28){?>

  <div id="disqus_thread" class="w70"></div>
           
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'siyama'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
    
        
        
        
        

<?}
?>
                    <p>&nbsp;</p>
                     
                    <div class="clear"></div>
                    </td>
                    <td valign="top" width="260">
                    <? 
                    
                    if ($GLOBALS['dgshop']->price_sale(100)>0){
                         
                        //if ($GLOBALS['dgshop']->_sale_type==2){
                            ?>
                                <div id="sale" class="box">
                                    <div class="head">Ваша скидка!</div>
                                    <p>Скидка на все продукты составляет <?=$GLOBALS['dgshop']->_sale_info?>%</p>
                                </div>
                            <?
                        //}
                        if ($GLOBALS['dgshop']->_sale_type==1){/*
                            $d = '';
                            $sale=0;
                            $h = date("G");
                            if ($h>=1 AND $h<5 AND $sale==0){ $sale='05'; $saletext = 'До конца «Ночной скидки» осталось:'; }
                            if ($h>=8 AND $h<10 AND $sale==0){ $sale=10; $saletext = 'До конца «Счастливых часов» осталось:';}
                            if ($h>=13 AND $h<17 AND $sale==0){ $sale=17;  $saletext = 'До конца «Счастливых часов» осталось:';}
                            if ($sale>0){
                            ?>
                                <div id="sale" class="box">
                                    <div class="head">Текущая скидка <?=$GLOBALS['dgshop']->_sale_info?>%</div>
                                    <div style="text-align: center; font-size: 120%;"><?=$saletext?></div>
                                    <div id="timer"></div>
                                    <script>
                                    
                                    var stop = <?=strtotime(date("Y-m-d")." ".$sale.":00:00")?>;
                                    var now = <?=time()?>;	
                                    var left = 0;
                                    var timer = '';
                                    function t(){
                                        now = now+1
                                        sec = stop-now;
                                        //var t = Math.floor(sec / 3600) + " : " + (Math.floor(sec / 60) - (Math.floor(sec / 3600) * 60)) + " : " + sec % 60
                                        h = Math.floor(sec / 3600); if (h<10) h = '0'+h;
                                        m = (Math.floor(sec / 60) - (Math.floor(sec / 3600) * 60)); if (m<10) m = '0'+m;
                                        s = sec % 60; if (s<10) s = '0'+s;
                                        $("#timer").text(h+':'+m+':'+s)
                                        if (sec<=0) {
                                            clearInterval(timer);
                                            //alert("Акция закончилась");
                                            $("#sale").remove();
                                            }
                                    }
                                    $(document).ready(function()	{
                                    	
                                         t();
                                         timer = setInterval('t()',1000);
                                         
                                    				});
                                    </script>
                                </div>
                            <?
                            
                            }*/
                        }
                        
                    } ?>
                    <p><?=$this->mod('new')?></p>
                    
                     
                    <p style="text-align: center;"><a href="/d/so/"><img src="<?=_TPL_?>/img/card.png" /></a></p>
                    </td>
                </tr>
            </table>
            
            <?
           }?>
           
           
           
           
            
        </div>
	</div><!-- #content-->

</div><!-- #wrapper -->

<footer id="footer">
	<div class="dg_table w100">
 	<div class="dg_tr">
 		<div class="dg_td w20"></div>
        <div class="dg_td w40">
        
            <div class="soc">
               
                <a href="https://itunes.apple.com/ru/app/id1214593007" style="vertical-align: middle;"><img src="//siyama.ru/appst.png" /></a>
                <a href="https://play.google.com/store/apps/details?id=com.siyama" style="vertical-align: middle;"><img src="//siyama.ru/gp.png" /></a>
                <a href="http://vk.com/siyamaru_30" target="_blank" style="vertical-align: middle;"><img src="//siyama.ru/vk.png" /></a>
                 
            
            </div>
        
        </div>
 		<div class="dg_td w40">
<p id="matte"><em><a class="matte">разработка сайта</a> - студия <a class="matte">Matte</a></em></p>
</div>
 	</div>
 </div>
</footer><!-- #footer -->
<?
    if (array_key_exists('closemodalapp',$_GET)){
        
        setcookie('nomodalapp','Y',time()+(3600*24*7),'/','.siyama.ru');
        header("Location:/");
        
    }
    if ($this->_mobile && $_COOKIE['nomodalapp']!='Y'){
        
        ?>
            <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,.8); z-index: 10000;">
            
               <div style="width: 50%; margin: 0 auto; padding: 20px; background: #000; margin-top: 20%;">
                 <h2>Приложение Сияма доступно в</h2>
                <p><a href="https://itunes.apple.com/ru/app/id1214593007" style="vertical-align: middle;"><img src="//siyama.ru/appst.png" /></a> 
                <a href="https://play.google.com/store/apps/details?id=com.siyama" style="vertical-align: middle;"><img src="//siyama.ru/gp.png" /></a></p>
                <p><a href="/?closemodalapp=Y" style="display: inline-block; padding: 10px; text-decoration: none;background: #ff0000;">Закрыть</a></p>
               </div>
            </div>
        <?
        
    }

?> 

<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('4665-326-10-4893');/*]]>*/</script><noscript><a href="https://www.olark.com/site/4665-326-10-4893/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->


<script type="text/javascript">
var _urq = _urq || [];
_urq.push(['initSite', 'a90b7150-99f3-4bfb-a0f6-ffcf4e92a4f2']);
(function() {
var ur = document.createElement('script'); ur.type = 'text/javascript'; ur.async = true;
ur.src = 'http://sdscdn.userreport.com/userreport.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ur, s);
})();
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter27991116 = new Ya.Metrika({id:27991116,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/27991116" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html><?}}?>