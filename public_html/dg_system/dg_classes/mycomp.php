<?php

/**
 * @author mrhard
 * @copyright 2010
 */
defined("_DG_") or die ("ERR");

class mycomp{
    
    public $_Q;
    public $_comp;
    public $_page;
    public $_tpl;
    public $_inblock=false;
    public $_object;
    public $_objecttype=',html,htm,php,asp';
    public $_objecttypedef='html';
    public $_app;
    public $_show='list';
    public $tpldir;
    public $inf;
    public $_totalobject=0;
    public $s_p_s;
 
    function __construct($Q,$app){
        if (!is_object($Q)){ 
            $this->_Q = new dg_bd;
            $this->_Q->connect();
        }else{
            $this->_Q=$Q; 
        }
    $this->_app = $app;
    $this->inf = dg_source();
    }
    
    public function connect(){
        
        
        
        $this->_tpldir = _DR_.'/_comp/'.$this->inf['info']['dir'].'/'.$this->_comp.'/_tpl/'.$this->_tpl;
        
        if ($this->_comp!='' && $this->_tpl!='' && $this->_page!=''){
          if (file_exists($this->_tpldir)){
            
            $this->s_p_s = $this->_Q->QA("SELECT * FROM <||>dgcomponent__texts WHERE `page_id`=".$this->_page);
            
            
            if ($_GET['L0']!='' && substr_count($_GET['L0'],'.')==1 && !$this->_inblock){
                
                $ex = explode('.',$_GET['L0']);
                if ( substr_count($this->_objecttype,','.$ex[1])>0 && is_numeric($ex[0])){
                 
                    $this->_show='one'; 
                    $object=$ex[0];
   
                }
                
            }
            
            if (file_exists($this->_tpldir.'/'.$this->_show.'.sql.sys.php')){
                
                
                $f='/files/'.$this->_app->inf['info']['dir'].'/_comp/'.$this->_comp.'/_tpl/'.$this->_tpl.'/main.css'; if (file_exists(_DR_.$f) && filesize(_DR_.$f)>0) $this->_app->_headlink[]='          <link charset="utf-8" rel="stylesheet" href="'.$f.'" />';
                $f='/files/'.$this->_app->inf['info']['dir'].'/_comp/'.$this->_comp.'/_tpl/'.$this->_tpl.'/main.js';  if (file_exists(_DR_.$f) && filesize(_DR_.$f)>0) $this->_app->_headlink[]='          <script type="text/javascript" src="'.$f.'"></script>';
                
                
                $table='<||>mycomp__'.$this->_comp;
                $page=$this->_page;
                $p = $this->_app->_PAGE->_pages;
                if ($this->_totalobject>0 && is_numeric($this->_totalobject)) $p[$page]["max"] = $this->_totalobject;
                $limit = limit_parse($p[$page]["max"]);
                
                include_once $this->_tpldir.'/'.$this->_show.'.sql.sys.php';
                
                
                $total = $this->_Q->QN(str_replace('LIMIT','#LIMIT',$sql));
                 
                
                if ($this->_show=='one'){
                    $row = $this->_Q->QA($sql);
                }else{
                    $QW = $this->_Q->QW($sql);
                }
               
                if ($this->_Q->_error==''){ 
                    
                  if ($this->_show!='one') echo '<div class="mycomp_prefix">'. $this->s_p_s['prefix'] .'</div>'."\n\n";
                    
                        if (file_exists($this->_tpldir.'/'.$this->_show.'.prefix.sys.php')){ include_once $this->_tpldir.'/'.$this->_show.'.prefix.sys.php'; }    
                            
            
            
                if ($this->_show=='one'){
                  if ($row[0]!=''){ 
                    //$url = $p[$page]['url'].$row['id'].'.'.$this->_objecttypedef;
                    $url = $this->_app->_PAGE->url($row['sys_page']).$row['id'].'.'.$this->_objecttypedef;
                    
                   if (file_exists($this->_tpldir.'/'.$this->_show.'.content.sys.php')){ include_once $this->_tpldir.'/'.$this->_show.'.content.sys.php'; }      
                  }else{
                    $this->_app->_e404=true;
                  }
                }else{
                    foreach ($QW as $obj_i=>$row){
                        if($row[0]!=''){
                              //$url = $p[$page]['url'].$row['id'].'.'.$this->_objecttypedef;
                              
                              $url = $this->_app->_PAGE->url($row['sys_page']).$row['id'].'.'.$this->_objecttypedef;
                              if (file_exists($this->_tpldir.'/'.$this->_show.'.content.sys.php')){ include $this->_tpldir.'/'.$this->_show.'.content.sys.php'; }      
                        }
                    }
                }      
                            
                        if (file_exists($this->_tpldir.'/'.$this->_show.'.sufix.sys.php')){ include_once $this->_tpldir.'/'.$this->_show.'.sufix.sys.php'; } 
                        
                        if ($this->_show!='one') echo "\n\n".'<div class="mycomp_sufix">'. $this->s_p_s['sufix'] .'</div>';
                        
                        
                            
                }else{
                    echo '<p>Component SQL error!</p>';
                    if ($this->_app->_infoUSER['admin']>0){
                        echo '<div class="dg_sql_error">'.$this->_Q->_error.'</div>';
                    } 
                }   
                
            }else{
                echo 'Component SQL file is not found!'; 
            }
        
        }else{
        echo 'Component tpl is not found!<br/>'.$this->_tpldir;    
      }
      }
    }


    
}

?>