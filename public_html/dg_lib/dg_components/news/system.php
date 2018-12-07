<?php

/**
 * @author mrhard
 * @copyright 2010
 */
defined("_DG_") or die ("ERR");
define(_DG_NEWS_BASEURL_,'/dg_lib/dg_components/news');
$GLOBALS['dg_news']['datetimeformat'][0] = array('01.01.2000','d.m.Y');
$GLOBALS['dg_news']['datetimeformat'][1] = array('01-01-2000','d-m-Y');
$GLOBALS['dg_news']['datetimeformat'][2] = array('2000-01-01','Y-m-d');
$GLOBALS['dg_news']['datetimeformat'][3] = array('2000/01/01','Y/m/d');
$GLOBALS['dg_news']['datetimeformat'][4] = array('01 января 2000г.',false);


$GLOBALS['dg_news']['datetimeformat'][5] = array('01.01.2000 12:00','d.m.Y H:i');
$GLOBALS['dg_news']['datetimeformat'][6] = array('01-01-2000 12:00','d-m-Y H:i');
$GLOBALS['dg_news']['datetimeformat'][7] = array('2000-01-01 12:00','Y-m-d H:i');
$GLOBALS['dg_news']['datetimeformat'][8] = array('2000/01/01 12:00','Y/m/d H:i');
$GLOBALS['dg_news']['datetimeformat'][9] = array('01 января 2000г. (12:00)',false);


    class dg_news{
            
            private $_app;
            private $_Q;
            public $_page_id = 0;
            public $_format_date = 0;
            public $_tpl = 'default';
            public $_show_anons = true;
            public $_show_anons_on_one = true;
            public $_strurl = true;
            public $_maxobjectonpage = 10;
            public $_showonlylist = false;
            public $_show_mainimg = true;
            public $_show_mainimg_on_one = true;
            public $_main_img_w = 100;
            public $_main_img_h = 'auto';
            public $_main_img_bgcolor = '#FFFFFF';
        
            public $_css_id_key = 'dg_news';
            public $_pager_cont = 'page';
            public $_pager_total = 4;
            public $_show_pager = true;
            
            public $_use_seo = true;
            
            public $_show_select_year = true;
            
            public $_date_alias_m = array(
            
                                        '01'=>'января',
                                        '02'=>'февраля',
                                        '03'=>'марта',
                                        '04'=>'апреля',
                                        '05'=>'мая',
                                        '06'=>'июня',
                                        '07'=>'июля',
                                        '08'=>'августа',
                                        '09'=>'сентября',
                                        '10'=>'октября',
                                        '11'=>'ноября',
                                        '12'=>'декабря'
            
            );
            public $_date_alias_y = 'г.';
            
               function __construct($app){
                
                    if (is_object($app)){
                        
                        $this->_app = $app;
                        $this->_Q = $app->_Q;
                        
                        		 
                    }else die('Error Component dg_news APP not found');
                
                
               }
              
              public function select_year($all='Все'){
                        $content='';
                        $where = "WHERE `show`=1";
                        if (is_numeric($this->_page_id)) $where.=" AND `page_id`=".$this->_page_id;
                        
                        $QW = $this->_Q->QW("SELECT `date`,`show`,`page_id` FROM `<||>dg_news` ".$where. " ORDER BY `date` DESC");
                            	if (count($QW)>0){
                            	                                        
                            	                                        
                            		foreach($QW as $i=>$row){
                            			if ($row[0]!=''){
                            			               		                               	   
                            			         $datetime_ex = explode(' ',$row['date']);

                                                 $date_ex = explode('-',trim($datetime_ex[0]));
                                                 $time_ex = explode(':',trim($datetime_ex[1])); 
                                                 		 
                                                 $DATE[$date_ex[0]]++;                                                 
                            			}
                            		}
                            	                                       
                            	} 
                                
                                
                                
                        if (is_array($DATE)){
                        $content = '<nav class="dg_news_select_news"><ul>';
                        		  $sel = '';
                                if ($_GET['L0']=='' || !is_numeric($_GET['L0'])) $sel = ' class="act"';   
                        $content.='<li'.$sel.'><a href="'. $this->_app->_PAGE->url($this->_page_id) .'">'. $all .'</a></li>';
                           foreach($DATE as $year=>$total){
                                $sel = '';
                                if ($year==$_GET['L0']) $sel = ' class="act"';
                           	    $content.='<li'.$sel.'><a href="'. $this->_app->_PAGE->url($this->_page_id) .$year.'/">'. $year .'</a></li>';
                           } 
                        
                        $content.='</ul></nav>';
                        }
                        return $content;
              }
              
              private function row($row){
                
                
                                        $row['page_url']  = $this->_app->_PAGE->url($row['page_id']);
                    			        $datetime_ex = explode(' ',$row['date']);
                                        $date_ex = explode('-',trim($datetime_ex[0]));
                                        $time_ex = explode(':',trim($datetime_ex[1]));                                 	   
                    			        
                                        $row['_date_array']['date'] = $date_ex;
                                        $row['_date_array']['time'] = $time_ex;
                                        $row['object_url'] = ($this->_strurl)?$row['page_url'].$date_ex[0].'/'.$date_ex[1].'/'.$date_ex[2].'/'.$row['url'].'/':$row['page_url'].$date_ex[0].'/'.$date_ex[1].'/'.$date_ex[2].'/'.$row['id'].'.html';   
                                        $row['_date'] = $row['date'];
                                        $row['_timestamp'] = strtotime($row['date']);
                                        if ($GLOBALS['dg_news']['datetimeformat'][$this->_format_date][1]!==false) $row['date'] = date($GLOBALS['dg_news']['datetimeformat'][$this->_format_date][1],strtotime($row['date'])); else {
                                            
                                            $date_al = $date_ex[2].' '.$this->_date_alias_m[$date_ex[1]].' '. $date_ex[0].$this->_date_alias_y;
                                            if ( $this->_format_date==9 ) $date_al.=' ('. $time_ex[0] .':'. $time_ex[1] .')';
                                            $row['date'] = $date_al;
                                            
                                        }
                                        if ($this->_show_mainimg && file_exists(_DR_.$row['img'])){
                                            $img_info='';
                                            $pvimg = '';
                                            if ( dg_file::type($row['img'])=='jpg' || dg_file::type($row['img'])=='jpeg' || dg_file::type($row['img'])=='png' || dg_file::type($row['gif']) ){
                                                
                                                $img_info_original = getimagesize(_DR_.$row['img']);
                                                $pvimg = img(array('src'=>$row['img'],'w'=>$this->_main_img_w,'h'=>$this->_main_img_h,'bg'=>$this->_main_img_bgcolor));
                                                $http = ($_SERVER["HTTPS"]=='on')?'https':'http';
                                                $img_info_pv = getimagesize($http.'://'.$_SERVER['HTTP_HOST'].$pvimg);
                                            
                                                $row['image'] = array(
                                                                'original'=>$row['img'],
                                                                'dir'=>_DR_.$row['img'],
                                                                'src'=>$pvimg,
                                                                'type'=>dg_file::type($row['img']),
                                                                'img_info_pv'=>$img_info_pv,
                                                                'img_info_original'=>$img_info_original,
                                                                'download_link'=>'/download_file'.$row['img'],
                                                                'html'=>'<img src="'. $pvimg .'" '. $img_info_pv[3] .' alt="'. htmlspecialchars($row['title']) .'" class="dg_news_img_pv" />'
                                                );
                                                
                                                
                                            }
                                        }
                
                
                return $row;
              } 
               
              private function get_list(){
                
                     $where = "WHERE `show`=1";
                     if (is_numeric($this->_page_id)) $where.=" AND `page_id`=".$this->_page_id;
                     		    $limit = limit_parse($this->_maxobjectonpage,$this->_pager_cont);
                                if (!$this->_showonlylist){
                                    $where_date = '';
                                    if (is_numeric($_GET['L0'])) $where_date[] = $_GET['L0'];
                                    if (is_numeric($_GET['L1'])) $where_date[] = $_GET['L1'];
                                    if (is_numeric($_GET['L2'])) $where_date[] = $_GET['L2'];
                                    if (is_array($where_date)) $where.=" AND `date` LIKE '". implode('-',$where_date) ."%'";
                                    $limit = 'LIMIT 0,'.$this->_maxobjectonpage;
                                }
                    $QW = $this->_Q->QW("SELECT * FROM `<||>dg_news` ".$where." ORDER BY `date` DESC ".$limit);
                     
                    $total_result = $this->_Q->QN(str_replace('LIMIT','#LIMIT', $this->_Q->_sql ));
                    require _DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/list.prefix.sys.php';
                    	if (count($QW)>0){
                    	                                        
                    	                                        
                    		foreach($QW as $i=>$row){
                    			if ($row[0]!=''){
                    			 
                                        $row = $this->row($row);
                    			           
                                        		require _DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/list.content.sys.php';                       
                    			}
                    		}
                    	                                       
                    	} 
                        require _DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/list.sufix.sys.php';
                    
              } 
              
             
              
              private function get_one(){
                
                    $http = ($_SERVER["HTTPS"]=='on')?'https':'http';
                    if ($_GET['L3']!='' && is_numeric($_GET['L0']) && is_numeric($_GET['L1']) && is_numeric($_GET['L2'])){
                        
                        $where_s = 'URL';
                        $where = 'WHERE `show`>0';
                        if (is_numeric($this->_page_id)) $where.=" AND `page_id`=".$this->_page_id;
                        $where_c = " AND `url` LIKE '". $this->_Q->e( $_GET['L3'] )."'";
                        if ( substr_count($_GET['L3'],'.html')==1){
                            
                            $ex_g = explode('.html',$_GET['L3']);
                            if (is_numeric($ex_g[0]) && $ex_g[0]!='') {
                                $where_c = " AND `id` = ".$ex_g[0];
                                $where_s = 'ID';
                                }
                        }
                        
                        $where.=$where_c." AND `date` LIKE '". $_GET['L0'] ."-". $_GET['L1'] ."-". $_GET['L2'] ."%'";
                        
                        $row = $this->row($this->_Q->QA("SELECT * FROM `<||>dg_news` ".$where." LIMIT 1"));
                        if ($row['id']==''){
                            $this->_app->_e404 = true;
                        }else{
                        		if (($this->_strurl && $where_s=='ID') || (!$this->_strurl && $where_s=='URL')){
                        		  
                                  header("Location:".$row['object_url'],TRUE,303);
                                  
                        		}
                                
                         if ($this->_use_seo){
                            
                            if (trim($row['seo_kw'])!='') $this->_app->_seo_kw = $row['seo_kw']; else{
                                
                                $title_ex = explode(' ',$row['title']);
                                $this->_app->_seo_kw = implode(', ',$title_ex);
                            }
                            $this->_app->_seo_des = $row['seo_des'];
                            $description = strip_tags($row['anons']);
                            if (!$this->_show_anons) $description = strip_tags($row['text']);
                            
                            $description_ex = explode(' ', str_replace("  "," ",str_replace("\n"," ",$description)) );
                            for ($i=0; $i<=200; $i++) $description_arr[] = $description_ex[$i];
                            $this->_app->_og['description'] = implode(" ",$description_arr);
                            if (trim($this->_app->_seo_des)=='') $this->_app->_seo_des = implode(" ",$description_arr);
                            if ( $this->_show_mainimg && $row['image']['src']!='') $this->_app->_og['image'] = $http.'://'.$_SERVER['HTTP_HOST'].$row['image']['src'];
                            $this->_app->_og['url'] =  $http.'://'.$_SERVER['HTTP_HOST'].$row['object_url'];
                            $this->_app->_og['type'] = 'article';
                            $this->_app->_title = $row['title'];
                         }
                                
                         require _DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/one.prefix.sys.php';
                         require _DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/one.content.sys.php';
                         require _DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/one.sufix.sys.php';       
                                
                        }
                    } 
                
                
              }
              
              public function content(){
                
                
                        if ( 
                        file_exists(_DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/list.content.sys.php') 
                        &&
                        file_exists(_DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/list.sufix.sys.php') 
                        &&
                        file_exists(_DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/list.prefix.sys.php')
                        &&
                        file_exists(_DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/one.content.sys.php')
                        &&
                        file_exists(_DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/one.sufix.sys.php')
                        &&
                        file_exists(_DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/one.prefix.sys.php')
                         ){
                            
                            
                            if (!$GLOBALS['dg_news_tpl_css_js'][$this->_page_id]){
                                $GLOBALS['dg_news_tpl_css_js'][$this->_page_id] = true;
                                
                                 if ( file_exists(_DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/news.css')  ){
                                    $s = _DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/news.css';
                                    
                                    
                                         
                                            $t  = filemtime (_DR_.$s);
                                            $s = $s.'?c='.$t;
                                        
                                     
                                    
                                    $this->_app->_headlink[] = "\n".'           <link  rel="stylesheet" media="all" href="'.$s.'" />'."\n";
                                    
                                 }
                                 
                                 if ( file_exists(_DR_._DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/news.js')  ){
                                    $s = _DG_NEWS_BASEURL_.'/_tpl/items/'.$this->_tpl.'/news.js';
                                    
                                    
                                         
                                            $t  = filemtime (_DR_.$s);
                                            $s = $s.'?c='.$t;
                                        
                                     
                                    
                                    $this->_app->_headlink_fin[] = "\n".'           <script type="text/javascript" src="'. $s .'"></script>'."\n";
                                    
                                 }
                                
                            }
                
                		  if ($_GET['L3']!='' && !$this->_showonlylist)$this->get_one(); else $this->get_list();
                        
                        }else echo 'Component tpl file error!<br/>'._DR_._DG_NEWS_BASEURL_.'/tpl/items/'.$this->_tpl.'/list.content.sys.php';    
              }
        
        
    }

?>