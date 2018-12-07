<?php

/**
 * @author mrhard
 * @copyright 2010
 */
defined("_DG_") or die ("ERR");	
class application{
        
        public $inf;
        public $_Q;
        public $_USER;
        public $_PAGE;
        
        public $_sefaccess=0;
        public $_sefaccess_p=true;
        
        public $_infoPAGE;
        public $_infoUSER;
        public $_infoSource;
        
        public $_admin=false;
        
        public $_regedit;
                
        public $_title;
        public $_seo_kw;
        public $_seo_des;
        
        public $_insearch = true;
        public $_search_rating = 0;
        public $_search_kw;
        
        
        public $tpldir;
        public $_notpl=false;
        public $_headlink;
        public $_comp_css_link;
        public $_comp_js_link;
        
        public $_e404=false;
        
        public $_component;
        
        public $_func='index';
        public $_use='index';
        public $_action='index';
        public $_act='index';
        
        public $LANGLOAD;
        public $LANG;
        
        public $_modlist;
        public $_complist;
        
        public $_ajax=false;
        public $_mobile=false;
        public $_mobile_user_agent_list = 'android,windows ce,palmos,symbian,nokia,opera mobi,j2me,midp,opera mini,iphone';
        
        public $_og;
        
        function __construct(){
                tl('application:construct');
                
                $mob_ex = explode(',',$this->_mobile_user_agent_list);
                foreach($mob_ex as $i=>$v){
                	if ( substr_count( strtolower($_SERVER["HTTP_USER_AGENT"]),trim($v) ) ) $this->_mobile=true;
                }
                
                if (  $_SERVER[HTTP_X_REQUESTED_WITH] == 'XMLHttpRequest' || array_key_exists('gotoframe',$_POST) || array_key_exists('ajax',$_GET) ) $this->_ajax=true; 
                $this->inf = dg_source();            
                
                if ( array_key_exists('func',$_GET) ) $this->_func = $_GET['func'];                
                if ( array_key_exists('use',$_GET) ) $this->_use = $_GET['use'];                
                if ( array_key_exists('action',$_GET) ) $this->_action = $_GET['action'];                
                if ( array_key_exists('act',$_GET) ) $this->_act = $_GET['act'];
                
            
                $this->_Q = new dg_bd;
                $this->_Q->connect();
                          
                $this->_infoSource = dg_source();    
                
                $this->_USER =       new dg_user($this->_Q);
                $this->_PAGE =       new dg_page($this->_Q);
                $this->_regedit =    new dg_regedit($this->_Q);
            	$this->LANGLOAD =    new dg_lang;
    			
                tl('application:include classes');
                
                $this->LANGLOAD->load('app');
     
    			$this->LANG = $this->LANGLOAD->LANG;                
                
                $this->_PAGE->spotpage(); 
                if ($this->_PAGE->_pageid==0 || $this->_PAGE->_pageid<0 || $this->_PAGE->_pageid=='') $this->_PAGE->_pageid = $this->_PAGE->_mainpage;       
                $this->_infoUSER = $this->_USER->_userinfo;
                $this->_infoPAGE = $this->_PAGE->_pages[$this->_PAGE->_pageid];
                
                
                
                if (array_key_exists('unload2AD',$_GET)){
        
                    $AD = new AD($this->_Q);
                    exit;
                    
                }
                
                
                if ($this->_infoUSER['admin']) $this->_admin=true;
                //if ($this->_infoUSER['admin']>1) $this->_mobile = true;
                
                //загружаем надстройки класса
                tl('application:start load presetting class');
                $addonsdir = _DR_.'/dg_system/dg_addons/application/';
                if (is_dir($addonsdir)){
                $dir = opendir ($addonsdir);
                  while ( $file = readdir ($dir))
                  {
                    if (( $file != ".") && ($file != "..") && (substr_count($file,'__construct')==1) && (is_file($addonsdir.$file)) && $file!='.svn')
                    {
                      include_once $addonsdir.$file;
                    }
                  }
                  closedir ($dir);
                }
                tl('application:stop load presetting class');
                 /* предопределяем вызов спец.файлов */
                if (!is_array($this->_infoPAGE) || $_GET['L0']=='404.html' || $_GET['L0']=='404.htm'){
                    $this->e404();
                    exit;
                }
               
                if ($_GET['L0']=='403.html' || $_GET['L0']=='403.htm'){
                    $this->e403();
                    exit;
                }
                
                if ($_GET['L0']=='sitemap.xml'){
                    $totalsm.='<?xml version="1.0" encoding="UTF-8"?>'."\n";
                    $totalsm.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

                    
                        $QW = $this->_Q->QW("SELECT * FROM <||>pages WHERE `search`=1");
                        foreach($QW as $i=>$row){
                        	if ($row[0]!=''){
 
                               $totalsm.='   <url>'."\n";
                               $totalsm.='      <loc>'.urldecode('http://'.$_SERVER['HTTP_HOST'].$this->_PAGE->_pages[$row['id']]['url']).'</loc>'."\n";
                               $totalsm.='      <lastmod>'.date("Y-m-d",$this->_PAGE->_pages[$row['id']]['lastmod']).'</lastmod>'."\n";
                               $totalsm.='   </url>'."\n";
                               
                        	}
                        }
                        echo $totalsm.'</urlset>';
                    exit;
                }
                
                if ($_GET['L0']=='robots.txt'){
                    echo "User-agent: * \n";
                    echo "Disallow: \n";
                    echo "Sitemap: http://".$_SERVER['HTTP_HOST']."/sitemap.xml\n";
                    exit;
                }
                   
                     
                     
 
                
                
                

                tl('application:start include setting of system comp');
                  
                      /*загружаем надстройки компонентов*/
                      $QW = $this->_Q->QW("SELECT * FROM <||>pages WHERE `comp` LIKE 'system:%'");
                      $COMP = array(''=>'');/* пригодится */
                      foreach($QW as $i=>$row){
                      	if ($row[0]!='' && !array_key_exists($row['comp'],$COMP)){
                      	    $COMP[$row['comp']]=true;
                           $ex = explode(':',$row['comp']);
                           if (is_dir(_DR_."/dg_lib/dg_components/".$ex[1])){
                            if (file_exists(_DR_."/dg_lib/dg_components/".$ex[1].'/system.php') )  include_once _DR_."/dg_lib/dg_components/".$ex[1].'/system.php';
                            $this->_complist[$ex[1]] = true;
                           }  
                      	}
                      }
                 tl('application:stop include setting of system comp');     

               
                                                               
                                  function buff($b){
                                        //Контент передаем глобальной переменной
                                        $GLOBALS['pagecontent'] = $b;
                                   }  
               
                $this->_title = $this->_infoPAGE['name'];
                $this->_component = explode(':',$this->_infoPAGE['comp']);               
                
                $accss=false;
                if($this->_USER->_userauth){
                    $accesses=explode(';',$this->_infoUSER['groups']);
                    foreach($accesses as $i=>$v){
                    	if ( substr_count($this->_infoPAGE['access'],';'.$v.';')===1 ) $accss=true;	
                    }
                }
                
                
                
                $this->tpldir = '/_tpl/'.$this->_infoSource['info']['dir'].'/'.$this->_infoPAGE['tpl'];    
                if ($this->_e404 && file_exists(_DR_.'/_tpl/'.$this->_infoSource['info']['dir'].'/404/index.dg.php')){
                    $this->tpldir='/_tpl/'.$this->_infoSource['info']['dir'].'/404';
                }
                define("_TPL_",$this->tpldir);
                
                tl('application: use content');
                if ((trim($this->_infoPAGE['access'])=='') || (trim($this->_infoPAGE['access'])!='' && $this->_USER->_userauth && $accss) || ($this->_infoUSER['admin']==2)){

            
                    ob_start('buff');
                    //Загоняем контент в буфер
                        if (file_exists(_DR_.'/dg_system/dg_incl_component/'.$this->_component[0].'.php')){
                            define("CONTENT",true);    
                            include_once _DR_.'/dg_system/dg_incl_component/'.$this->_component[0].'.php';                        
                        }else{
                            echo 'connected component is not possible';                
                        }
                    ob_end_flush();
                    
                }else{
                    $GLOBALS['pagecontent']='<div class="dg_no_access">'.$this->LANG['main']['no_access'].'</div>';

                }          
                  
                tl('application: stop use content');    
                
                if ( $this->_sefaccess>=$GLOBALS['getindex'] AND $this->_sefaccess_p){
                 
                    /**
                     * Если Уровень ЧПУ совпадает с допустимым значением,
                     * то выгружаем страницу,
                     * если нет, то вызываем 404 ошибку
                     */
                  
                    if ($this->_infoPAGE['tpl']!='' && file_exists(_DR_.$this->tpldir.'/index.dg.php')){
                        
                        
                        /**
                        * для удобства в шаблонах
                        */
                        if (!array_key_exists('notpl',$_GET) && !$this->_ajax && !$this->_notpl && $_GET['getprint']!='print'){
                            tl('application: start use tpl');
                            include_once _DR_.$this->tpldir.'/index.dg.php';
                            tl('application: stop use tpl');
                        }else{
                            echo $this->content();
                            if ($_GET['getprint']=='print') echo '<script>window.print();</script>';
                        }
                    }else{
                        addlog('tpl "'.$this->_infoPAGE['tpl'].'" is not found','cms');
                    }     
           }else{
            $this->_e404 = true;
            $this->e404();
           }
        }
        
        
        
        public function head(){
            
            
            if (is_array($this->_og)){
                echo "\n";
                if ($this->_og['type']!='') echo '          <meta property="og:type" content="'.htmlspecialchars($this->_og['type']).'" />'."\n";
                if ($this->_og['description']!='') echo '           <meta property="og:description" content="'.htmlspecialchars($this->_og['description']).'" />'."\n";
                if ($this->_og['url']!='') echo '           <meta property="og:url" content="'.$this->_og['url'].'" />'."\n";
                if ($this->_og['image']!='') echo '         <meta property="og:image" content="'.$this->_og['image'].'" />'."\n";
            }
            tl('application: start head');
                if ($this->_regedit->read('use.jquery','yes')=='yes'){
                    $this->_headlink[]='          <script type="text/javascript" src="'.$this->_regedit->read("jQuery.link",_JQ_LINK_).'"></script>';
                }                
                if ($this->_regedit->read('use.dgcss','yes')=='yes'){
                    $this->_headlink[]='          <link charset="utf-8" rel="stylesheet" href="/dg_system/dg_css/dg.css" />';
                }  
            
            $cachedirhead = _DR_.'/cache/tpl.'.$this->_infoSource['info']['prefix'].'.head.'.$this->_infoPAGE['tpl'].'.'.$this->_infoPAGE['id'].'.ch';
            
            if (!file_exists($cachedirhead) || (filemtime($cachedirhead)+$this->_regedit->read('TPLcachehead',3600))<time()){
                
            if ($this->_regedit->read('seo.title','')!='')    $this->_headlink[] = '        <meta name="title" content="'.$this->_regedit->read('seo.title','').'" /> ';
            if ($this->_regedit->read('seo.kw','')!='' || $this->_infoPAGE['kw']!='' || $this->_seo_kw!=''){
                $exkw = explode(',',$this->_infoPAGE['kw'].','.$this->_seo_kw.','.$this->_regedit->read('seo.kw',''));
                
                foreach($exkw as $i=>$v){
                	if (trim($v)!='') $kw[$v]=true;
                }
                $kwstr='';
                if (is_array($kw)){
                    foreach($kw as $i=>$v){
                    	$kwstr.=','.$i;
                    }
                }
                
                if ($kwstr!='') {
                    $this->_headlink[] = '        <meta name="keywords" content="'.trim($kwstr,',').'" /> ';
                    $this->_search_kw = $kwstr;
                    }
            }  
            if ($this->_regedit->read('seo.des','')!='' || $this->_infoPAGE['des']!='' || $this->_seo_des!='') $this->_headlink[] = '        <meta name="description" content="'.trim($this->_regedit->read('seo.des','').' '.$this->_infoPAGE['des'].' '.$this->_seo_des).'" /> ';
            if ($this->_regedit->read('seo.shortcut_icon','')!='' && substr_count($this->_regedit->read('seo.shortcut_icon',''),'.ico')==1) $this->_headlink[] = '        <link rel="shortcut icon" href="'.$this->_regedit->read('seo.shortcut_icon','').'" type="image/x-icon" />  ';
            if ($this->_regedit->read('seo.a','')!='') $this->_headlink[] = '        <meta name="author" content="'.$this->_regedit->read('seo.a','').'" /> ';
            
            $this->_headlink[] = '        <meta name="generator" content="demiurgo.cms" /> ';

                if ($this->_component[0]=='conf') $this->_headlink[]='          <link charset="utf-8" rel="stylesheet" media="all" href="/_comp/'.$this->_infoSource['info']['dir'].'/'.$this->_component[1].'/_tpl/'.$this->_component[2].'/main.css" />';
                
                if (is_array($this->_comp_css_link)) $this->_headlink[] = implode("\n",$this->_comp_css_link);
                
                $QW = $this->_Q->QW("SELECT * FROM `<||>templates__css` WHERE `tpl`='".$this->_Q->e($this->_infoPAGE['tpl'])."' AND `show`=0 ORDER BY `order`");
                foreach($QW as $i=>$row){
                	
                    $s = $this->tpldir.'/css/'.$row['dir'];
                     if (substr_count($row['dir'],'/')!=0){ $s = $row['dir']; }
                         else {
                        if (is_file(_DR_.$s)){
                            $t  = filemtime (_DR_.$s);
                            $s = $s.'?c='.$t;
                        }
                    }
                    if (substr_count($row['dir'],'/')!=0) $s = $row['dir'];                     
                    
                    if ($row['ie']!=''){
                        $v=$row['ie'];
                        if ($row['ie']==1) $v=''; 
                        $this->_headlink[]='    <!--[if IE'.$v.']>';
                    }
                    $this->_headlink[]='          <link charset="utf-8" rel="stylesheet" media="'.$row['media'].'" href="'.$s.'" />';    
                    if ($row['ie']!=''){
                        $this->_headlink[]='    <![endif]-->';
                    }                
                
                }
                if (is_array($this->_comp_js_link)){ $this->_headlink[] = implode("\n",$this->_comp_js_link);}
                if ($this->_component[0]=='conf') $this->_headlink[]='          <script type="text/javascript" src="/_comp/'.$this->_infoSource['info']['dir'].'/'.$this->_component[1].'/_tpl/'.$this->_component[2].'/main.js"></script>';
                $QW = $this->_Q->QW("SELECT * FROM `<||>templates__js` WHERE `tpl`='".$this->_Q->e($this->_infoPAGE['tpl'])."' AND `show`=0 ORDER BY `order`");
                foreach($QW as $i=>$row){
                	
                    $s = $this->tpldir.'/js/'.$row['dir'];
                     if (substr_count($row['dir'],'/')!=0){ $s = $row['dir']; }
                         else {
                        if (is_file(_DR_.$s)){
                            $t  = filemtime (_DR_.$s);
                            $s = $s.'?c='.$t;
                        }
                    }
                    if (substr_count($row['dir'],'/')!=0){ $s = $row['dir']; }
                    if ($row['ie']!=''){
                        $v=$row['ie'];
                        if ($row['ie']==1){ $v=''; }
                        $this->_headlink[]='    <!--[if IE'.$v.']>';
                    }
                    $this->_headlink[]='          <script type="text/javascript" src="'.$s.'"></script>'; 
                    if ($row['ie']!=''){
                        $this->_headlink[]='    <![endif]-->';
                    }                 
                }

                $file = new dg_file;
                $file->create($cachedirhead,implode("\n",$this->_headlink)."\n");
            }
            
            include_once $cachedirhead;
            if (is_array($this->_headlink_fin)) echo implode("\n",$this->_headlink_fin);
            tl('application: stop tpl');
        }  
        
              
        public function content(){
            tl('application: use presetting content');
                //Вызываем ф-ии обработки контента из компонентов
               foreach($this->_complist as $i=>$v){
               	    if (file_exists(_DR_."/dg_lib/dg_components/".$ex[1].'/plugin.buffcontent.php') ) include_once _DR_."/dg_lib/dg_components/".$ex[1].'/plugin.buffcontent.php';
               }
            tl('application: stop presetting content');  
               if ($this->_insearch && $this->_infoPAGE['search']==1 && trim(strip_tags($GLOBALS['pagecontent']))!='' && !$this->_e404 && !$this->_ajax){

                     tl('application: search in buff');
                    /* загружаем контент в поисковую таблицу */
                    
                    function s_c($text){
                        $text = str_replace("\r","\n",$text);
                        $text = str_replace('<br/>',"<br/> \n",$text);
                        $text = str_replace('<br />',"<br /> \n",$text);
                        $text = str_replace('</p>',"</p> \n",$text);
                        $text = str_replace('<p>',"<p> \n",$text);
                        $text = str_replace("\r","\n",$text);
                        $text = str_replace("\n\n","\n",$text);
                        $text = str_replace("\n\n","\n",$text);
                        return trim(strip_tags($text));
                    }
                    if ($this->_title=='') $this->_title = $this->_infoPAGE['name'];
                    
                        $search_info = $this->_Q->QA("SELECT * FROM <||>search WHERE `url`='".$this->_Q->e($_SERVER["REQUEST_URI"])."'");
                        if ($search_info['id']=='' || ( s_c($GLOBALS['pagecontent'])!=$search_info['text'] )){
                            
                            $this->_Q->_table = 'search';
                            $this->_Q->_arr = array(
                                'host'=>$_SERVER["HTTP_HOST"],
                                'url'=>$_SERVER["REQUEST_URI"],
                                't'=>time(),
                                'kw'=>$this->_search_kw,
                                'r'=>$this->_search_rating,
                                'title'=>$this->_title,
                                'text'=>s_c($GLOBALS['pagecontent'])
                                );
                            if ($search_info['id']==''){
                                $this->_Q->QI();
                            }else{
                                $this->_Q->_where = " WHERE `id`=".$search_info['id'];
                                $this->_Q->QU();
                            }
                            
                        }
                   tl('application: stop search in buff'); 
                
               }
               
                //Выгружаем контент
               return $GLOBALS['pagecontent'];
              		
        }
        
        public function mod($index=''){
            tl('application: start use mod '.$index);
            $modcontent='';
            if ( $index=='' ){ return; }
            if (!is_array($this->_modlist)){
                
                    $QW = $this->_Q->QW("SELECT * FROM <||>mods");
                    foreach($QW as $i=>$row){
                    	if ($row[0]!='') $this->_modlist[$row['name']] = $row;
                    }
                
            }
        
            
           if (is_array($this->_modlist)){ 
            if(array_key_exists($index,$this->_modlist)){
                
                $inf = $this->_modlist[$index];
                $param = explode(';',$inf['param']);
                
                if (file_exists(_DR_.'/dg_lib/dg_modules/'.$inf['mod'].'/index.php')){
                    $this->LANGLOAD->load('mod',$inf['mod']);
                    $this->LANG = $this->LANGLOAD->LANG;
                    include _DR_.'/dg_lib/dg_modules/'.$inf['mod'].'/index.php';
                    return $modcontent;
                }
                
            }
           } 
            tl('application: stop use mod '.$index);
        }
        
        public function block($index=''){
            //Синоним mod
                return $this->mod($index);
            }
        
        public function e404($text=''){
                header("HTTP/1.1 404 Not Found",true);
                if (file_exists(_DR_.'/_tpl/'.$this->_infoSource['info']['dir'].'/404/index.dg.php')){
                        include_once _DR_.'/_tpl/'.$this->_infoSource['info']['dir'].'/404/index.dg.php';
                    }else{
                        if ($text=='') $text='<h1>Error 404</h1> <p>'.$this->LANG['main'][404].'</p>';
                        echo '<div class="mess e404">'.$text.'</div>';
                }
        }

        public function e403($text=''){
                header("HTTP/1.1 403 Forbidden",true);
                if (file_exists(_DR_.'/_tpl/'.$this->_infoSource['info']['dir'].'/403/index.dg.php')){
                        include_once _DR_.'/_tpl/'.$this->_infoSource['info']['dir'].'/403/index.dg.php';
                    }else{
                        if ($text=='') $text='<h1>Error 403</h1> <p>'.$this->LANG['main'][403].'</p>';
                        echo '<div class="mess e403">'.$text.'</div>';
                }
        }
        
        public function h($url){
            header("Location:".$url);
            ?>
            <div class="dg_headerloaction"><?=str_replace('%url%',$url,$this->LANG['main']['headerlocation'])?></div>
            <script type="text/javascript">window.location.href ='<?=$url?>';</script>
            <meta http-equiv="Refresh" content="5; url=<?=$url?>" /> 
            <?
        }
       public function __destruct(){
        tl('application: destruct ');
             //загружаем постнастройки класса
                $addonsdir = _DR_.'/dg_system/dg_addons/application/';
                if (is_dir($addonsdir)){
                $dir = opendir ($addonsdir);
                  while ( $file = readdir ($dir))
                  {
                    if (( $file != ".") && ($file != "..") && (substr_count($file,'__destruct')==1) && (is_file($addonsdir.$file)) && $file!='.svn')
                    {
                      include_once $addonsdir.$file;
                    }
                  }
                  closedir ($dir);
                }
            //Вызываем ф-ии постобработки контента из компонентов
               if (is_array($this->_complist)){
                   foreach($this->_complist as $i=>$v){
                   	    if (file_exists(_DR_."/dg_lib/dg_components/".$ex[1].'/plugin.destructcontent.php') ) include_once _DR_."/dg_lib/dg_components/".$ex[1].'/plugin.destructcontent.php';
                   }
               }
               tl('application: destruct fin');
               
               if (array_key_exists('timeline',$_GET) && $this->_infoUSER['admin']==2 && is_array($GLOBALS['tlt'])){
                    		foreach($GLOBALS['tlt'] as $i=>$v){
                      	         echo $GLOBALS['tln'][$i].' -> (<strong>'.($v-$GLOBALS['tlt'][($i-1)]).'</strong>)'.$v."<br />";
                            }
                            echo '<strong>'.($GLOBALS['tlt'][$i]-$GLOBALS['tlt'][0]).'</strong>';
               }
       }
}

?>