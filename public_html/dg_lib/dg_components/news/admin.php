<?php

/**
 * @author mrhard
 * @copyright 2010
 */

defined("ADMIN") or die ("ERR");
defined("CONTENT") or die ("ERR");
require_once _COMP_DIR_.'system.php';
 
if (is_numeric($_GET['news_id'])) $NEWS = $this->_Q->QA("SELECT * FROM <||>dg_news WHERE `id`=". $_GET['news_id'] ." LIMIT 1");

$this->_right.='<li style="background:url('. _DG_NEWS_BASEURL_ .'/ico.png) no-repeat left center;"><a href="'. _COMP_URL_ .'index">Список</a></li>';
$this->_right.='<li style="background:url('. _DG_NEWS_BASEURL_ .'/img/newspaper_add.png) no-repeat left center;"><a href="'. _COMP_URL_ .'update">Добавить материал</a></li>';
$this->_right.='<li style="background:url(/dg_system/dg_img/icons/hammer.png) no-repeat left center;"><a href="'. _COMP_URL_ .'setting">Настройки компонента</a></li>';

$this->_right.='<div class="r"></div>';

$this->_right.='<li style="background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="'. _COMP_URL_ .'tpls">Список шаблонов</a></li>';
$this->_right.='<div class="r"></div>';

if ($this->_act=="index"){//TODO: 	ACT index

    ?>
    
    <p><img src="<?=_DG_NEWS_BASEURL_?>/img/newspaper_add.png" class="ico" /> <a href="<?=_COMP_URL_?>update">Добавить материал</a></p>
    <div class="r w90"></div>
    <form method="post" onsubmit="return confirm ('Вы уверены?')">
    <?
    
         if ( array_key_exists('remove',$_POST) && is_array($_POST['ids'])){
         		$this->_Q->_table = 'dg_news';
                $this->_Q->_arr = array('show'=>-1,'time_update'=>time(),'user_update'=>$this->_user->_userinfo['id']);
                $this->_Q->_where = "WHERE `page_id`=".$inf['id']." AND `id` IN (".implode(",",$_POST['ids']).")";
                $this->_Q->QU();
                header("Location:". $_SERVER["REQUEST_URI"]);
         }
    
    ?>
    <div class="dg_table w90 dg_list">
    	<div class="dg_tr head">
            <div class="dg_td w5"><input type="checkbox" onchange="$('.select_news').prop('checked',$(this).prop('checked'))" /></div>
    		<div class="dg_td w45">Заголовок</div>
    		<div class="dg_td w20">Дата</div>
            <div class="dg_td w5">PUSH</div>
            <div class="dg_td w5">&nbsp;</div>
            <div class="dg_td w10">&nbsp;</div>
            <div class="dg_td w10">&nbsp;</div>
    	</div>
        <?
        
        $QW = $this->_Q->QW("SELECT * FROM <||>dg_news WHERE `page_id`=".$inf['id']." AND `show`>0 ORDER BY `date` DESC ".limit_parse($inf['max']));
        $total_result = $this->_Q->QN(str_replace('LIMIT','#LIMIT', $this->_Q->_sql ));
        	if (count($QW)>0){
        	                                        
        	                                        
        		foreach($QW as $i=>$row){
        			if ($row[0]!=''){
        			     
                         ?>
                         
                            <div class="dg_tr">
                                <div class="dg_td "><input type="checkbox" name="ids[]" class="select_news" value="<?=$row['id']?>" /></div>
                        		<div class="dg_td "><?=$row['title']?></div>
                        		<div class="dg_td "><?=date('d.m.Y H:i',strtotime($row['date']))?></div>
                                <div class="dg_td "><?
                                
                                    if ($row['send_push']==1){
                                        
                                        ?><img src="/dg_system/dg_img/icons/comments.png" title="Уже отправлено" /><?
                                        
                                    }else{
                                        
                                        ?><a href="<?=_COMP_URL_?>push&news_id=<?=$row['id']?>&re=<?=urlencode($_SERVER["REQUEST_URI"])?>"><img title="Отправить на устройства" src="/dg_system/dg_img/icons/arrow_out.png" /></a><?
                                    }
                                
                                ?></div>
                                <div class="dg_td "><a href="<?=_COMP_URL_?>update&news_id=<?=$row['id']?>&re=<?=urlencode($_SERVER["REQUEST_URI"])?>"><img title="Редактировать" src="<?=_DG_NEWS_BASEURL_?>/img/newspaper_edit.png" class="ico" /></a></div>
                                <div class="dg_td "><a href="<?
                                
                                    echo $p->_pages[$inf['id']]['url'];
                                    $datetime_ex = explode(' ',$row['date']);
                                    $date_ex = explode('-',trim($datetime_ex[0]));
                                    $time_ex = explode(':',trim($datetime_ex[1]));
                                    
                                    echo $date_ex[0].'/'.$date_ex[1].'/'.$date_ex[2].'/';
                                    
                                    if ( $this->_regedit->read('dg_news_stringurl_'.$inf['id'],1)==1 ) echo $row['url'].'/'; else echo $row['id'].'.html';
                                
                                ?>" target="_blank"><img title="Перейти к материалу" src="<?=_DG_NEWS_BASEURL_?>/img/newspaper_go.png" class="ico" /></a></div>
                                <div class="dg_td w10"><a href="<?=_COMP_URL_?>remove&news_id=<?=$row['id']?>&re=<?=urlencode($_SERVER["REQUEST_URI"])?>" onclick="return confirm('Вы действительно хотите удалить материал?')"><img title="Удалить" src="<?=_DG_NEWS_BASEURL_?>/img/newspaper_delete.png" class="ico" /></a></div>
                        	</div>
                         
                         <?                                          	   
        			                                                      
        			}
        		}
        	                                       
        	}else{
        	                                        
        	}
        
        ?>
    </div>
    <?=page_parse($inf['max'],$total_result)?>
    <div class="r"></div>
    
    <p><input type="submit" name="remove" value="Удалить" /></p>
    
    </form>
    <?
	

}
if ($this->_act=="push" && is_numeric($NEWS['id'])){
    
   
   	if ($NEWS['send_push']==1){
   	    
        ?>
        <p>Отправка закончена</p>
        <?
   	}else{
    
        if ($this->_ajax){
            
            
            function SENDCM($token,$title,$id_news){
                
                
                $message_array = array(
                    'title'=>'Новость',
                    'body'=>mb_substr($title,0,255,'UTF-8'),
                    'soundname'=>'default',
                    'to'=>'news',
                    'id'=> $id_news,
                );
                
                $fields = array();
                $fields = array('registration_ids'=>array($token),'notification'=>$message_array);
                 
        
                $headers = array(
                    'Authorization: key=' . 'AAAAXjTyV3w:APA91bGgmk-HlJMNiGLHZ-nZn1MNi6GJYmrvIfra3Y05ZQi_i9Bb0xG-avKcRkP3aB5g_LhWPbX4eqViwKnqUNwqRG9KRxCuhN3RyrM1teeLRMwhXR-je-KyWq293bxK7_eqiMbLfnX6',
                    'Content-Type: application/json'
                );
                // Open connection
                $ch = curl_init();
        
                // Set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                // Disabling SSL Certificate support temporarly
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                return curl_exec($ch);
                // Execute post
                /*$result = json_decode(curl_exec($ch),true);
                if ($result === FALSE) {
                    return 'ERROR';
                }*/
                // Close connection
                curl_close($ch);
                
                
            }
            
            $RETURN = array(
            'p'=>'Y',
            't'=>$this->_Q->QN("SELECT `id` FROM `<||>dg_user_dev_keys`")
            );
            
            
            $QW = $this->_Q->QW("SELECT `id`,`key` FROM `<||>dg_user_dev_keys` WHERE `id` NOT IN (SELECT `id_token` FROM `<||>dg_news_sends` WHERE `id_news`=". $NEWS['id'] .") LIMIT 10");
            	if (count($QW)>0){
            	                                        
            	                                        
            		foreach($QW as $i=>$row){
            			             $R = json_decode(SENDCM($row['key'],$NEWS['title'],$NEWS['id']),true);
                                     $this->_Q->_table = 'dg_news_sends';
                                     $this->_Q->_arr = array('id_news'=>$NEWS['id'],'id_token'=>$row['id'],'time'=>time(),'result'=>json_encode($R));
            			             $this->_Q->QI();                                  	   
            			             $RETURN['RESULT'][] = $R;     
                                     
                                     if ($R['failure']>0){
                                        
                                        $this->_Q->_table = 'dg_user_dev_keys';
                                        $this->_Q->_where = "WHERE `id`=".$row['id']." LIMIT 1";
                                        $this->_Q->QD();
                                     }                                    
            		 
            		}
            	                                       
            	}
            
            
            $RETURN['s'] = $this->_Q->QN("SELECT `id_news` FROM `<||>dg_news_sends` WHERE `id_news`=". $NEWS['id'] ."");
            
            if ($RETURN['s']>=$RETURN['t']) {
                
                $this->_Q->_table = 'dg_news';
                $this->_Q->_arr = array('send_push'=>1);
                $this->_Q->_where = "WHERE `id`=". $NEWS['id'] ." LIMIT 1";
                $this->_Q->QU();
                
                $RETURN['s']='OK';
                
            }
            echo json_encode($RETURN);
        
        }else{
            
            ?>
            
            <p id="SendPushMess"><span id="SendPush" style="cursor: pointer; display: inline-block; background: #ff0000; color: #fff; padding: 10px;">Начать рассылку</span></p>
            <script>
                function SendPush(){
                    $("#SendPushMess").text('Отправка запроса');
                    $.post(window.location.href,{PU:true},function(data){
                        
                        jsn = JSON.parse(data);
                        console.log(jsn);
                        if (typeof(jsn.p)!='undefined'){
                            
                            $("#SendPushMess").text('Отправили сообщение '+ jsn.s +' из '+ jsn.t);
                            
                            if (jsn.s=='OK'){
                                
                                $("#SendPushMess").text('Отправка закончена');
                                
                            }else{
                                
                                setTimeout('SendPush()',1000);
                                
                            }
                            
                        }else alert('Ошибка');
                        
                       })
                    
                    
                }
                $(document).ready(function()	{
                	$("#SendPush").click(function(){
                	   
                       if (confirm('Не закрывайте окно браузера')){
                        
                        SendPush();
                        
                       }
                       
                	})
                				});
            
            </script>
            <?
            
        }
    
    }
    
}
if ($this->_act=="remove" && is_numeric($NEWS['id'])){//TODO: 	ACT remove

	$this->_Q->_table = 'dg_news';
    $this->_Q->_where = 'WHERE `id`='.$NEWS['id'];
    $this->_Q->_arr = array('show'=>-1,'time_update'=>time(),'user_update'=>$this->_user->_userinfo['id']);
    $this->_Q->QU();
    if ($_GET['re']!='') header("Location:".urldecode($_GET['re'])); header("Location:"._COMP_URL_.'index'); 
}
 
if ($this->_act=="update"){//TODO: 	ACT update

     if ( array_key_exists('go',$_POST) ){
     	
        
        $error = '';
        $arr='';
        
        $datetime_ex = explode(' ',htmlspecialchars_decode($_POST['date']));
            $date_ex = explode('-',trim($datetime_ex[0]));
            $time_ex = explode(':',trim($datetime_ex[1]));
           
            if (
            !checkdate($date_ex[1],$date_ex[2],$date_ex[0]) 
            || 
            ( 
                ( !is_numeric($time_ex[0]) || $time_ex[0]<0 || $time_ex[0]>24 )
                ||
                ( !is_numeric($time_ex[1]) || $time_ex[1]<0 || $time_ex[1]>59 )
             )
            ) $error.='<li>Вы не верно указали дату</li>'."\n";
            
            
             if ($error==''){
                
                $subInfo = $this->_Q->QA("SELECT * FROM <||>pages WHERE `parent`=". $inf['id'] ." AND `ind`=". $date_ex[0] ." LIMIT 1");
                if ( $subInfo['id']!='' ) $error.='<li>Ошибка, в подразделах текущего раздела есть раздел с Идентификатором '. $date_ex[0] .' (<a href="/dg_admin/?comp=source&use=pages&func=update&id='. $subInfo['id'] .'">'. $subInfo['name'] .'</a> ID: '.$subInfo['id'].')</li>'."\n";
                
             }
             
             if ($error==''){
                
                
                    if ( $this->_regedit->read('dg_news_stringurl_'.$inf['id'],1)==1 ){
            
                            if (trim($_POST['url'])=='') $error.='<li>Вы не заполнили «Адрес новости»</li>'."\n"; else{
                            
                            $infNews = $this->_Q->QA("SELECT * FROM <||>dg_news WHERE `show`>0 AND `date` LIKE '". trim($datetime_ex[0]) ."%' AND `url` LIKE '". $this->_Q->e( htmlspecialchars_decode($_POST['url']) ) ."' LIMIT 1");
                            if ($infNews['id']!=$NEWS['id'] && $infNews['id']!='') $error.='<li>«Адрес новости» уже занят, введите другой адрес</li>'."\n";
                            }
                    }
                
                
             }
        
        if ($error==''){
            
            
            $arr['title'] = htmlspecialchars_decode($_POST['title']);
            $arr['anons'] = htmlspecialchars_decode($_POST['anons']);
            $arr['text'] = htmlspecialchars_decode($_POST['text']);
            $arr['url'] = htmlspecialchars_decode($_POST['url']);
            $arr['img'] = htmlspecialchars_decode($_POST['img']);
            $arr['date'] = htmlspecialchars_decode($_POST['date']);
            $arr['show'] = htmlspecialchars_decode($_POST['show']);
            $arr['seo_kw'] = htmlspecialchars_decode($_POST['seo_kw']);
            $arr['seo_des'] = htmlspecialchars_decode($_POST['seo_des']);
            $arr['page_id'] = $inf['id'];
            $arr['time_update'] = time();
            $arr['user_update'] = $this->_user->_userinfo['id'];
            if ($NEWS['id']==''){
                
                $arr['time_insert'] = time();
                $arr['user_insert'] = $this->_user->_userinfo['id'];
                
            }
            
            $this->_Q->_table = 'dg_news';
            $this->_Q->_arr = $arr;
            if ($NEWS['id']=='') $this->_Q->QI(); else{
                $this->_Q->_where = 'WHERE `id`='.$NEWS['id'];
                $this->_Q->QU();
            }
            
            if ($this->_Q->_error=='') {
                 if ($_GET['re']!='') header("Location:".urldecode($_GET['re'])); header("Location:"._COMP_URL_.'index'); 
            }else 
            $error.='<li>Системная ошибка</li>'."\n";
        }
        
        if ($error!=''){
            
            foreach($_POST as $i=>$v){
            	$NEWS[$i] = htmlspecialchars_decode($v);
            }
            
        }
     }


	?>
    
    <form method="post" class="dg_form w90">
        <?
            if ($error!='') echo '<ul class="dg_error">'.$error.'</ul>';
        ?>
        <p>Заголовок<br /><input type="text" id="title" name="title" class="w90" required="required" value="<?=htmlspecialchars($NEWS['title'])?>" maxlength="255" /></p>
        
        <p>Дата публикации<br /><input type="text" class="datetime datetimenews" name="date" required="required" value="<?=htmlspecialchars($NEWS['date'])?>" /></p>
        <?
        
        if ( $this->_regedit->read('dg_news_stringurl_'.$inf['id'],1)==1 ){
            ?>
            
            <script>
            
                function translit(){
                    // Символ, на который будут заменяться все спецсимволы
                    var space = '-'; 
                    // Берем значение из нужного поля и переводим в нижний регистр
                    var text = $('#title').val().toLowerCase();
                         
                    // Массив для транслитерации
                    var transl = {<? if ( $this->_regedit->read('dg_news_stringurltranslit_'.$inf['id'],1)==1 ){ ?>
                    'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh', 
                    'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
                    'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
                    'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': space, 'ы': 'y', 'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya',<?}?>
                    ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
                    '#': space, '$': space, '%': space, '^': space, '&': space, '*': space, 
                    '(': space, ')': space,'-': space, '\=': space, '+': space, '[': space, 
                    ']': space, '\\': space, '|': space, '/': space,'.': space, ',': space,
                    '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
                    '?': space, '<': space, '>': space, '№':space
                    }
                                    
                    var result = '';
                    var curent_sim = '';
                                    
                    for(i=0; i < text.length; i++) {
                        // Если символ найден в массиве то меняем его
                        if(transl[text[i]] != undefined) {
                             if(curent_sim != transl[text[i]] || curent_sim != space){
                                 result += transl[text[i]];
                                 curent_sim = transl[text[i]];
                                                                            }                                                                            
                        }
                        // Если нет, то оставляем так как есть
                        else {
                            result += text[i];
                            curent_sim = text[i];
                        }                              
                    }          
                                    
                    result = TrimStr(result);               
                                    
                    // Выводим результат 
                    $('#url').val(result); 
                        
                    }
                    function TrimStr(s) {
                        s = s.replace(/^-/, '');
                        return s.replace(/-$/, '');
                    }
                    function datetime2url(e){
                        dates = e.split(' ');
                        dateparam = dates[0].split('-');
                        if (
                        dateparam[0]!='' &&
                        dateparam[1]!='' &&
                        dateparam[2]!='' 
                         ){
                            
                            $("#url_date").html(dateparam[0]+'/'+dateparam[1]+'/'+dateparam[2]+'/');
                            
                         }
                    }
                    $(function(){
                    datetime2url($( ".datetimenews" ).val());
                    $('#title').on('keyup keydown blur click change',function(){
                         translit();
                    });
                    $( ".datetimenews" ).datetimepicker({ dateFormat: 'yy-mm-dd',timeFormat: ' hh:ii:ss',onSelect: function(e){ 
                        datetime2url(e);
                        
                    } }).on('click keyup change',function(){ datetime2url($( ".datetimenews" ).val()); });
                });
            
            </script>
            
            <p>Адрес новости:<br /><?=$p->_pages[$inf['id']]['url']?><span id="url_date"></span><input type="text" name="url" style="width: 400px;" id="url" value="<?=htmlspecialchars($NEWS['url'])?>" />/</p>
            
            <?
        }
        
        ?>
        <?  if ( $this->_regedit->read('dg_news_showmainimg_'.$inf['id'],1)==1 ){ ?>
        <p id="p_field_img">Путь до изображения<br />
        <input type="text" name="img" id="dg_news_img" class="w50" value="<?=htmlspecialchars($NEWS['img'])?>" /> 
        <input type="button" value="Обзор" onclick="window.open('/dg_admin/?comp=source&use=filemanager&ajax&to=dg_news_img&ft=jpg,png,jpeg','fileeditornews','height=600,width=1000,left=0,top=0,scrollbars=yes');  return false;">
                            </p>
        
        <?
        }
        
            if ( $this->_regedit->read('dg_news_showanons_'.$inf['id'],1)==1 ){
                
                ?>
                
                <p>Анонс<br /><textarea name="anons"   class="<?
                
                    if ( $this->_regedit->read('dg_news_wwganons_'.$inf['id'],1)==1 ) echo 'wwg';
                
                ?>"><?=htmlspecialchars($NEWS['anons'])?></textarea></p>
                
                <?
                
            }
        
        ?>
        
        <p>Полный текст<br /><textarea name="text"   class="<?
                
                    if ( $this->_regedit->read('dg_news_wwgtext_'.$inf['id'],1)==1 ) echo 'wwg';
                
                ?>"><?=htmlspecialchars($NEWS['text'])?></textarea></p>
                
        <p> <label> <input type="checkbox" name="show" value="1" <? if ($NEWS['show']==1 || $NEWS['id']==''){ echo ' checked '; } ?> /> Публикуется в списке</label> </p>        
         <? if ( $this->_regedit->read('dg_news_seo_'.$inf['id'],1)==1 ){ ?>
        <h3>Настройки SEO</h3>       
        
        <p>Ключевые слова, через запятую<br /><input type="text"  name="seo_kw" class="w90"   value="<?=htmlspecialchars($NEWS['seo_kw'])?>" maxlength="255" /></p> 
        <p>Описание (description)<br /><input type="text"  name="seo_des" class="w90"   value="<?=htmlspecialchars($NEWS['seo_des'])?>" maxlength="255" /></p> 
        <?}?>
        <p><input type="submit" name="go" value="<? if ($NEWS['id']=='') echo 'Добавить'; else echo 'Редактировать'; ?>" /></p>
    </form><?
$this->plugin('wysiwyg',array('pageinfo'=>$inf));
 

}

if ($this->_act=="setting"){//TODO: 	ACT setting
     if ( array_key_exists('savesetting',$_POST) ){
     	
        
        $this->_regedit->edit('dg_news_datetimeformat_'.$inf['id'],$_POST['dateformat']);
        $this->_regedit->edit('dg_news_showanons_'.$inf['id'],$_POST['dg_news_showanons']);
        $this->_regedit->edit('dg_news_showanons_on_news_'.$inf['id'],$_POST['dg_news_showanons_on_news']);
        $this->_regedit->edit('dg_news_stringurl_'.$inf['id'],$_POST['dg_news_stringurl']);
        $this->_regedit->edit('dg_news_stringurltranslit_'.$inf['id'],$_POST['dg_news_stringurltranslit']);
        $this->_regedit->edit('dg_news_listtpl_'.$inf['id'],$_POST['tpl']);
        
        $this->_regedit->edit('dg_news_wwganons_'.$inf['id'],$_POST['dg_news_wwganons']);
        $this->_regedit->edit('dg_news_wwgtext_'.$inf['id'],$_POST['dg_news_wwgtext']);
        
        $this->_regedit->edit('dg_news_showmainimg_'.$inf['id'],$_POST['dg_news_showmainimg']);
        $this->_regedit->edit('dg_news_showmainimg_on_news_'.$inf['id'],$_POST['dg_news_showmainimg_on_news']);
        $this->_regedit->edit('dg_news_mainimg_w_'.$inf['id'],$_POST['dg_news_mainimg_w']);
        $this->_regedit->edit('dg_news_mainimg_h_'.$inf['id'],$_POST['dg_news_mainimg_h']);
        $this->_regedit->edit('dg_news_mainimg_bgcolor_'.$inf['id'],$_POST['dg_news_mainimg_bgcolor']);
        
        $this->_regedit->edit('dg_news_seo_'.$inf['id'],$_POST['dg_news_seo']);
        
        $this->_regedit->edit('dg_news_showyear_select_'.$inf['id'],$_POST['dg_news_showyear_select']);
        
        header("Location:"._COMP_URL_.'setting');
     }
	?>
    
        <h3>Настройки компонента</h3>
        
        <form method="post" class="dg_form w70">
            <script>
            function dg_anons(){
                
                if ($("#dg_news_showanons").prop('checked')){
                    $('.dg_news_showanons').css('display','block');
                }else{
                    $('.dg_news_showanons').css('display','none');
                }
            }
            
            function dg_mainimgs(){
                
                if ($("#dg_news_showmainimg").prop('checked')){
                    $('.dg_news_showmainimg').css('display','block');
                }else{
                    $('.dg_news_showmainimg').css('display','none');
                }
            }
            
            function stringurl(){
                
                if ($("#dg_news_stringurl").prop('checked')){
                    $('.dg_news_stringurl').css('display','block');
                }else{
                    $('.dg_news_stringurl').css('display','none');
                }
            }
            
            $(document).ready(function()	{
            $("#dg_news_showanons").on('ckick change',function(){ dg_anons(); });
            $("#dg_news_showmainimg").on('ckick change',function(){ dg_mainimgs(); });
            $("#dg_news_stringurl").on('ckick change',function(){ stringurl(); });
            	dg_anons();
                dg_mainimgs();
                stringurl();
            				})
            </script>
            <p>Формат даты<br /><select name="dateformat"><?
            
                foreach($GLOBALS['dg_news']['datetimeformat'] as $idtime=>$dateformat){
                	?>
                        <option value="<?=$idtime?>"<? if ( $this->_regedit->read('dg_news_datetimeformat_'.$inf['id'],0)==$idtime ) echo ' selected="selected" '; ?>><?=$dateformat[0]?></option>
                    <?
                }
            
            ?></select></p>
            <div class="r"></div>
            <p> <label> <input type="checkbox" name="dg_news_showanons" id="dg_news_showanons" value="1" <? if ( $this->_regedit->read('dg_news_showanons_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> Публиковать анонс</label> </p>
            <p class="dg_news_showanons"> <label> <input type="checkbox" name="dg_news_showanons_on_news"  value="1" <? if ( $this->_regedit->read('dg_news_showanons_on_news_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> Публиковать анонс при просмотре материала</label> </p>
            <p class="dg_news_showanons"> <label> <input type="checkbox" name="dg_news_wwganons"  value="1" <? if ( $this->_regedit->read('dg_news_wwganons_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> Включить wysiwyg для анонса</label> </p>
            
            
            <div class="r"></div>
            <p> <label> <input type="checkbox" name="dg_news_wwgtext" value="1" <? if ( $this->_regedit->read('dg_news_wwgtext_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> Включить wysiwyg для полного тектса</label> </p>
            <div class="r"></div>
            <p> <label> <input type="checkbox" name="dg_news_stringurl" id="dg_news_stringurl" value="1" <? if ( $this->_regedit->read('dg_news_stringurl_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> ЧПУ</label> </p>
            <p class="dg_news_stringurl"> <label> <input type="checkbox" name="dg_news_stringurltranslit"  value="1" <? if ( $this->_regedit->read('dg_news_stringurltranslit_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> Транслит ЧПУ</label> </p>
            
            <div class="r"></div>
            <p> <label> <input type="checkbox" name="dg_news_showmainimg" id="dg_news_showmainimg" value="1" <? if ( $this->_regedit->read('dg_news_showmainimg_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> Публиковать картинку анонса</label> </p>
            <p class="dg_news_showmainimg"> <label> <input type="checkbox" name="dg_news_showmainimg_on_news"  value="1" <? if ( $this->_regedit->read('dg_news_showmainimg_on_news_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> Публиковать картинку анонса при просмотре материала</label> </p>
            
            <p class="dg_news_showmainimg"> Максимальная ширина изображения: <input type="text" name="dg_news_mainimg_w" value="<?=htmlspecialchars($this->_regedit->read('dg_news_mainimg_w_'.$inf['id'],100))?>" style="width: 50px;" /> px (auto - для пропорции)</p>
            <p class="dg_news_showmainimg"> Максимальная высота изображения: <input type="text" name="dg_news_mainimg_h" value="<?=htmlspecialchars($this->_regedit->read('dg_news_mainimg_h_'.$inf['id'],'auto'))?>" style="width: 50px;" /> px (auto - для пропорции)</p>
            <p class="dg_news_showmainimg"> Цвет заливки: <input type="color" name="dg_news_mainimg_bgcolor" value="<?=htmlspecialchars($this->_regedit->read('dg_news_mainimg_bgcolor_'.$inf['id'],'#FFFFFF'))?>" style="width: 50px;" /></p>
            <div class="r"></div>
            <p> <label> <input type="checkbox" name="dg_news_seo" value="1" <? if ( $this->_regedit->read('dg_news_seo_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> Включить SEO</label> </p>
            
            <div class="r"></div>
            
            <p> <label> <input type="checkbox" name="dg_news_showyear_select"  value="1" <? if ( $this->_regedit->read('dg_news_showyear_select_'.$inf['id'],1)==1 ) echo ' checked="checked" '; ?> /> Включить выборку по году</label> </p>
            
            
            <div class="r"></div>
            <p><a href="<?=_COMP_URL_?>tpls">Шаблон</a><br /><select name="tpl"><?
            
            $dir = opendir (_COMP_DIR_."_tpl/items/");
              while ( $file = readdir ($dir))
              {
                if (( $file != ".") && ($file != "..") && is_dir(_COMP_DIR_."_tpl/items/".$file) && $file!='_default')
                {
                  ?>
                    <option value="<?=$file?>" <? if ( $this->_regedit->read('dg_news_listtpl_'.$inf['id'],'default')==$file ) echo ' selected="selected" '; ?>><?=$file?></option>
                  <?
                }
              }
              closedir ($dir);
            
            
            ?></select></p> 
            <p><input type="submit" value="Сохранить" name="savesetting" /></p>
        </form>
    
    <?

}
if ($this->_act=="tpls"){//TODO: 	ACT tpls

        
	?>
        <h3>Управление шаблонами</h3>
        <h3>Список и просмотр</h3>
        <p><a href="<?=_COMP_URL_?>itemstpl"><img src="/dg_system/dg_img/icons/palette.png" title="Создать шаблон" align="absmiddle" /> Создать шаблон</a></p>
        <div class="dg_list w80"><?
        
       
            
            $dir = opendir (_COMP_DIR_."_tpl/items/");
              while ( $file = readdir ($dir))
              {
                if (( $file != ".") && ($file != "..") && is_dir(_COMP_DIR_."_tpl/items/".$file) && $file!='_default')
                {
                  ?>
                  <li>
                    <span style="width:50%;background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="<?=_COMP_URL_?>itemstpl&tpl=<?=$file?>"><?=$file?></a></span>
                    <span style="width:50%; text-align: right;">
                    <a href="<?=_COMP_URL_?>itemstpl&сtpl=<?=$file?>"><img src="<?=_DG_NEWS_BASEURL_?>/img/page_copy.png" title="Копировать шаблон" align="absmiddle" /></a>
                    <?
                    
                        if ($file!='default' && $file!='_default'){
                            ?>
                         &nbsp;<a href="<?=_COMP_URL_?>itemsremovetpl&tpl=<?=$file?>&re=<?=urlencode($_SERVER["REQUEST_URI"])?>" class="removeaccess"><img src="/dg_system/dg_img/icons/cross.png" title="Удалить шаблон" align="absmiddle" /></a> 
                       
                            <?
                        }
                    
                    ?></span>
                  </li>
                  <?
                }
              }
              closedir ($dir);
            
            
           
        
        ?></div>
    <?

}

if ($this->_act=="itemsremovetpl" && file_exists(_COMP_DIR_."_tpl/items/".$_GET['tpl']) && lat($_GET['tpl']) && $_GET['tpl']!='default' && $_GET['tpl']!='_default'){//TODO: 	ACT itemsremovetpl

	if ($this->accesspassword()){
	   
                        $f = new dg_file;
    					$f->full_del_dir(_COMP_DIR_."_tpl/items/".$_GET['tpl']);
    				    header("Location:"._COMP_URL_.'tpls');
       
       
	}

}

if ($this->_act=="itemstpl"){//TODO: 	ACT itemstpl
 if (!$this->_ajax){
	?>
    
    <h3>Управление шаблонами</h3>
    <?
    }
        if ( $_GET['tpl']==''){
            
            ?>
                <form method="post" class="dg_form w80">
                <?
                
                     if ( array_key_exists('nametpl',$_POST) && $_POST['nametpl']!=''){
                     	$error='';
                        if (!lat($_POST['nametpl'])) $error.='<li>Название должно содержать только латинские символы и цифры</li>'."\n";
                        if (file_exists(_COMP_DIR_."_tpl/items/".$_POST['nametpl'])) $error.='<li>Шаблон с таким названием уже присутствует</li>'."\n";
                        
                        
                        if ($error==''){
                    $ctpl = new dg_file;
                    
                    $ctpl->createdir(_COMP_DIR_."_tpl/items/".$_POST['nametpl']);
                    
                    if ($_GET['сtpl']!='' && file_exists(_COMP_DIR_."_tpl/items/".$_GET['сtpl']) && file_exists(_COMP_DIR_."_tpl/items/".$_GET['сtpl'].'/list.content.sys.php')){
                        
                         
                         $dir = opendir (_COMP_DIR_."_tpl/items/".$_GET['сtpl']);
                              while ( $file = readdir ($dir))
                              {
                                if (( $file != ".") && ($file != "..") && is_file(_COMP_DIR_."_tpl/items/".$_GET['сtpl'].'/'.$file) )
                                {
                                   copy(_COMP_DIR_."_tpl/items/".$_GET['сtpl'].'/'.$file,_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/'.$file);
                                }
                              }
                         closedir ($dir);
                         
                        
                        
                    }elseif(file_exists(_COMP_DIR_."_tpl/items/_default/list.content.sys.php")){
                        
                        $dir = opendir (_COMP_DIR_."_tpl/items/_default");
                              while ( $file = readdir ($dir))
                              {
                                if (( $file != ".") && ($file != "..") && is_file(_COMP_DIR_."_tpl/items/_default".'/'.$file) )
                                {
                                   copy(_COMP_DIR_."_tpl/items/_default".'/'.$file,_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/'.$file);
                                }
                              }
                         closedir ($dir);
                        
                    }else{
                    
                    
                        $ctpl->create(_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/list.prefix.sys.php','');
                        $ctpl->create(_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/list.content.sys.php','');
                        $ctpl->create(_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/list.sufix.sys.php','');
                        $ctpl->create(_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/one.prefix.sys.php','');
                        $ctpl->create(_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/one.content.sys.php','');
                        $ctpl->create(_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/one.sufix.sys.php','');
                        $ctpl->create(_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/news.css','');
                        $ctpl->create(_COMP_DIR_."_tpl/items/".$_POST['nametpl'].'/news.js','');
                    
                    
                    }
                    
                    header("Location:"._COMP_URL_.'itemstpl&tpl='.$_POST['nametpl']);
                }else{
                    echo '<ul class="dg_error">'. $error .'</ul>';
                }
                        
                     }
                
                ?>
                    <p>Название шаблона<br /><span class="comment">Название должно содержать только латинские символы и цифры</span><br /><input required="required" type="text" name="nametpl" value="<?=$_POST['nametpl']?>" /> <input type="submit" value="Далее" /></p>
                </form>
            <?
        }elseif(file_exists(_COMP_DIR_."_tpl/items/".$_GET['tpl']) && lat($_GET['tpl'])){
            
            $dir = _COMP_DIR_."_tpl/items/".$_GET['tpl'].'/';
            $file = new dg_file;
            
            if (array_key_exists('load',$_POST)){
					
					 
					 
			 		 $file->create($dir.'list.prefix.sys.php',htmlspecialchars_decode($_POST['list_prefix']));
			 		 $file->create($dir.'list.sufix.sys.php', htmlspecialchars_decode($_POST['list_sufix']) );
			 		 $file->create($dir.'list.content.sys.php',htmlspecialchars_decode($_POST['list_content']));
					 
		
			 		 
					 $file->create($dir.'one.prefix.sys.php',htmlspecialchars_decode($_POST['one_prefix']));
			 		 $file->create($dir.'one.sufix.sys.php',htmlspecialchars_decode($_POST['one_sufix']));
			 		 $file->create($dir.'one.content.sys.php',htmlspecialchars_decode($_POST['one_content']));
			 		 
					 
					 $file->create($dir.'news.css',htmlspecialchars_decode($_POST['css']));
					 $file->create($dir.'news.js',htmlspecialchars_decode($_POST['js']));
                     
			 		
					  
					
					if ($this->_ajax){ echo 'ok'; exit; }
				}
            
            
            ?>
            
            <h3>Шаблон <strong><?=$_GET['tpl']?></strong></h3>
            
            
            <script type="text/javascript" src="/dg_system/dg_js/markitup/jquery.markitup.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/skins/simple/style.css" />		 			 
<script type="text/javascript" src="/dg_system/dg_js/markitup/sets/default/set.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/sets/default/style.css" />				 			 
		 			 
		 			 
	<script type="text/javascript">
	$(function() {
		$("#tabs textarea").markItUp(mySettings);
		$("#tabs").tabs();
		
	});
	</script>	 
	
   <form method="post" class="ajax"  autocomplete="off">	 <?=$this->_security->creat_key()?>
   <input type="hidden" name="load" value="1" />
	 <div class="dg_form">			 
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1" class="ct"><?=$this->LANG['confcomp']['master_3_file_list']?></a></li>
						<li><a href="#tabs-2" class="ct"><?=$this->LANG['confcomp']['master_3_file_one']?></a></li>
						<li><a href="#tabs-3" class="ct"><?=$this->LANG['confcomp']['master_3_file_cssjs']?></a></li>
						 
					</ul>
					<div id="tabs-1">
					
					
					<p><?= $this->LANG['confcomp']['master_3_file_prefix']?><br />
						<textarea name="list_prefix"><?=htmlspecialchars($file->read($dir.'list.prefix.sys.php'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_content']?><br />
						<textarea name="list_content"><?=htmlspecialchars($file->read($dir.'list.content.sys.php'))?></textarea>
					</p>					
					<p><?= $this->LANG['confcomp']['master_3_file_sufix']?><br />
						<textarea name="list_sufix"><?=htmlspecialchars($file->read($dir.'list.sufix.sys.php'))?></textarea>
					</p>
				 
				 					
						
					</div>
					<div id="tabs-2">
				
					<p><?= $this->LANG['confcomp']['master_3_file_prefix']?><br />
						<textarea name="one_prefix"><?=htmlspecialchars($file->read($dir.'one.prefix.sys.php'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_content']?><br />
						<textarea name="one_content"><?=htmlspecialchars($file->read($dir.'one.content.sys.php'))?></textarea>
					</p>					
					<p><?= $this->LANG['confcomp']['master_3_file_sufix']?><br />
						<textarea name="one_sufix"><?=htmlspecialchars($file->read($dir.'one.sufix.sys.php'))?></textarea>
					</p>
					 
						
					
					</div>
					<div id="tabs-3">
					<p><?= $this->LANG['confcomp']['master_3_file_css']?><br />
						<textarea name="css"><?=htmlspecialchars($file->read($dir.'news.css'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_js']?><br />
						<textarea name="js"><?=htmlspecialchars($file->read($dir.'news.js'))?></textarea>
					</p>
                  			
					</div>
					 
				</div>	
			<p>&nbsp;</p>	
			<p><input type="submit" name="save" value="<?=$this->LANG['main']['save']?>" /> 

	<input type="reset" name="reset" value="<?=$this->LANG['main']['cancel']?>" /></p>		
				
	  </div>				 			 
	</form>
            
            
            <?
        }else echo 'Ошибка';
    
    ?>
    <?

}

?>