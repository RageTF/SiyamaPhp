<?php

/**
 * @author mrhard
 * @copyright 2010
 */

 class dg_page{
    
    
    private $_Q;
    private $inf;
    public $_info;
    public $_comp;
    public $_id;
    public $_pagestree;
    public $_pages;
    public $_mainpage;
    public $_urltree;
    public $_url;
    public $_pageid;
    public $_pageurltree='';
    
    function __construct($Q=''){
        if (!is_object($Q)){ 
            $this->_Q = new dg_bd;
            $this->_Q->connect();
        }else{
            $this->_Q=$Q;
        }
		$this->inf = dg_source();
        
            $m=0;
            $QW = $this->_Q->QW("SELECT * FROM `<||>pages` ORDER BY `order`");
            foreach ($QW as $i=>$row){
                
                $p = $row['parent'];
                $this->_pagestree[$p][$row[id]] = $row;
                $this->_pages[$row[id]]=$row;
                $m++;
                if ($row['main']==1) $this->_mainpage=$row['id'];
            }
            
            $this->loadpages();
        
    }
    
    private	function loadpages($parent=0,$gl=0,$url='/'){
         $y=0;

        if (is_array($this->_pagestree[$parent])){
            
            foreach($this->_pagestree[$parent] as $i=>$row){
              $row['menu'] = ($row['menu'] != "") ? $row['menu'] : $row['name'];
                $y++;
                $ourl = $url;
                $url.=$row['ind'].'/';   
    
                
                $this->_pages[$row['id']]['url'] = $url;
                $this->_pages[$row['id']]['gl'] = $gl;
                if ($row['link']!='') $this->_pages[$row['id']]['url'] = $row['link']; 
                $this->_url[$row['id']] = $this->_pages[$row['id']]['url']; 
                
                  
                
                if (array_key_exists($row['id'],$this->_pagestree)){
                    $this->loadpages($row['id'],($gl+1),$url);
                }
                $url=$ourl;               
                
            }                
            
        }       
 
        
    }    
    
    public	function info(){
        
        $this->_info = $this->_Q->QA("SELECT * FROM <||>pages WHERE `id`='".$this->_Q->e($this->_id)."'");
        if ($this->_info['id']!=''){
            $this->_comp = explode(':',$this->_info['comp']);
        }
    }
    
    
    static function SetLastTime(){
        
        
        file_put_contents(_DR_.'/lastmod2.json',json_encode(array('time'=>time())));
        
        
    }
    
     public	function spotpage($s=0,$p=0){
            $ex = explode('/',$_GET['getinfo']);    
            if (array_key_exists($s,$ex) && trim($ex[$s])!=''){
                $lid=-1;
                if(is_array($this->_pagestree[$p])){
                    foreach($this->_pagestree[$p] as $i=>$v){
                    	if ($this->_pages[$i]['ind']==$ex[$s]){
                           $lid = $i;
                           $this->_pageurltree.=$lid.',';
                    	}
                    }
                }
                    if ($lid<0){
                        $_GET['L'.$GLOBALS['getindex']] = $ex[$s];
                        $GLOBALS['getindex']++;
                    } 
                    if ($lid>0)$this->_pageid = $lid;
                    if (array_key_exists(($s+1),$ex)) return $this->spotpage($s+1,$lid);
                         
            }    
     }

    public function url($id=''){
        if ($id==''){ $a = $this->spotpage(); $id=$a['id']; }
        return $this->_url[$id];
    }
 
    
    public	function installcomp(){
        if (!is_array($this->_info)) $this->info(); 
        if (!is_array($this->_info)) return false; 

            if ($this->_comp[0]=='system'){
                $d = _DR_.'/dg_lib/dg_components/'.$this->_comp[1].'/setup.php';
                if (file_exists($d))include_once $d;  
            }
        
        
        return true;
    }
    
    public	function removepage(){
        if (!is_array($this->_info)) $this->info(); 
        if (!is_array($this->_info)) return false; 
        
        
          $dir = opendir ( _DR_.'/dg_lib/dg_components/');
          while ( $file = readdir ($dir))
          {
            if (( $file != ".") && ($file != ".."))
            {
                $d = _DR_.'/dg_lib/dg_components/'.$file.'/remove.php';
                if (file_exists($d)){
                    include_once $d;
                }
            }
          }
          closedir ($dir);

          $QW = $this->_Q->QW("SELECT * FROM <||>dgcomponent__regedit");  
          
          foreach ($QW as $i=>$comp){
                if ($comp['id']!=''){  
                    if ( $this->_Q->dg_table_exists("mycomp__".$comp['ind']) ){
                        $this->_Q->_table = "mycomp__".$comp['ind'];
                        $this->_Q->_where = " WHERE `sys_page`=". $this->_info['id'] ." ";
                        $this->_Q->QD();
                    }
                }            
          }

        echo $this->_Q->_error;
        
        return true;
    }
    
    public $navigationtext;
    
    public function navigation($parent=0,$max=0,$tp=0,$gl=1){
          
           if (is_array($this->_pagestree[$parent])){
            foreach($this->_pagestree[$parent] as $i=>$row){
              $row['menu'] = ($row['menu'] != "") ? $row['menu'] : $row['name'];
                $sel=''; 
                $cl='';
                if ($tp==$row['id']) {
                    $cl.= ' act ';
                    
                    }else{

                            if ( substr_count($this->_pageurltree,$row['id'].',')==1 ) $cl.=' childact ';
                        
                    }
                    if ($row['css']!='') $cl.= ' '.$row['css'].' '; 
                if ($row['view']==1){
                    if ($cl!='') $sel=' class="'.trim(str_replace('  ',' ',$cl)).'"';
                    $this->navigationtext.="\n".str_repeat("    ",$gl+1).'<li id="page_'.$row['id'].'"'.$sel.'><a href="'.$this->_pages[$row['id']]['url'].'">'.$row['menu'].'</a>';
                       
                    if (array_key_exists($row['id'],$this->_pagestree) && ($max==0 || $gl<$max)){
                        $this->navigationtext.="\n".str_repeat("    ",($gl+1)).'<ul id="parent_'.$row['id'].'">';
                        $this->navigation($row['id'],$max,$tp,($gl+1));
                        $this->navigationtext.="\n".str_repeat("    ",($gl+1)).'</ul>'."\n".str_repeat("    ",$gl+1);
                    }
                    
                    $this->navigationtext.='</li>';
                }
            }

        }
        
    }
    
 }

?>