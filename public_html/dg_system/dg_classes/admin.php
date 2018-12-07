<?

/**
 * @author Maltsev Vladimir
 * @copyright 2010
 * 
 */

class dg_admin{
	
	public $ver='0.6.1';
	public $subver='beta';
    
	public $_right; 
	
	private $_Q;
    private $_regedit;
	private $_auth=true;
	private $_tpl='matte';
	
	public $_comp='source';
	public $_use='pages';
	public $_func='index';
    public $_act='index';
	
	public $_ajax=false;
  	public $inf;
    
    private $_user;
    public $LANGLOAD;
	private $security;
	
    public	function load(){

		
		$this->_Q = new dg_bd;
		$this->_Q->connect();
		$this->inf = dg_source();
		
        $this->_regedit = new dg_regedit($this->_Q);
        
        	$this->LANGLOAD = new dg_lang;
			$this->LANGLOAD->load();
			$this->LANG = $this->LANGLOAD->LANG;
            
            if ( array_key_exists('setupcpmponent',$_GET) || $this->_Q->dg_table_exists('dg_user') ) $this->setupcomp(); 
            
            $this->_user = new dg_user($this->_Q);
            $this->_security = new security($this->_user->_ses,$this->_Q);
            
    
            

        if (  $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' || array_key_exists('gotoframe',$_POST) || array_key_exists('ajax',$_GET) ) $this->_ajax=true; 
        
        
		if ($this->_user->_userinfo['admin']>0){
			
    			define("ADMIN",true);
    			
            if (array_key_exists('logout',$_GET)){ 
                setcookie(_COOPX_.'user','',0,'/',$this->_user->coohost());
                header("Location:/index.php");
            }
    			
    			
    			if ( array_key_exists('comp',$_GET)  ) $this->_comp = $_GET['comp']; 
    			if ( array_key_exists('use',$_GET) ) $this->_use = $_GET['use']; 
    			if ( array_key_exists('func',$_GET) ) $this->_func=$_GET['func']; 
    			
    			if (  $this->_ajax ){
    			    if (array_key_exists('print',$_GET)) $this->head(true); else $this->head(); 
    				$this->content();
                    if (array_key_exists('print',$_GET)) echo '<script>window.print();</script>';
    				exit();
    				
    			}else{
    			    
    				include_once _DR_.'/dg_admin/_templates/'.$this->_tpl.'/index.php';
    			
    			}
			
		}else{
		 
			$this->authform();
			
		}
		
	}
	
    public function head($andajax=false){
        if (!$this->_ajax || $andajax){
      
        ?>
            <link charset="utf-8" rel="stylesheet" href="_templates/<?=$this->_tpl?>/ui/jquery-ui-1.8.6.custom.css" />
            <link charset="utf-8" rel="stylesheet" href="/dg_system/dg_css/dg.css" />
            <link charset="utf-8" rel="stylesheet" href="_templates/<?=$this->_tpl?>/css/main.css" />
            <link charset="utf-8" rel="stylesheet" media="all" href="/dg_system/dg_func/lb/css/jquery.lightbox-0.5.css" /> 
            <script type="text/javascript" src="<?=_JQ_LINK_?>"></script>
            <script src="<?=_JQUI_LINK_?>" type="text/javascript"></script> 
            <script>
                var lang_textareakey = '<?=$this->LANG['main']['textareaout']?>'; 
                var DGLANG = '<?=$this->LANGLOAD->_def?>';
                var accesspassword = '<?=$this->LANG['main']['accesspassword']?>'
            </script>
            <script type="text/javascript" src="/dg_system/dg_js/datetime.js"></script>
            <script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/trunk/ui/i18n/jquery.ui.datepicker-<?=$this->LANGLOAD->_def?>.js"></script>
            <script type="text/javascript" src="/dg_system/dg_js/jquery.form.js"></script>
            <script type="text/javascript" src="/dg_system/dg_js/jquery.keyboard.js"></script>
            <script type="text/javascript" src="/dg_system/dg_js/admin.js"></script>
            <script type="text/javascript" src="_templates/<?=$this->_tpl?>/js/main.js"></script>  
            <script type="text/javascript" src="/dg_system/dg_func/lb/js/jquery.lightbox-0.5.min.js"></script>    
            <script> $(document).ready(function()	{
                     	$("a[href$=jpg],a[href$=png],a[href$=gif]").lightBox({fixedNavigation:false});
                     				}) </script>   
        <?
       } 
    }
	
	public	function content(){
		

		
		
		if ( file_exists(_DR_.'/dg_admin/_components/'.$this->_comp.'/'.$this->_use.'.sys.php') ){
			
			
			if ( file_exists(_DR_.'/dg_admin/_components/'.$this->_comp.'/_helps/'.$this->LANGLOAD->_def.'.'.$this->_use.'.php') ){
				
				include_once (_DR_.'/dg_admin/_components/'.$this->_comp.'/_helps/'.$this->LANGLOAD->_def.'.'.$this->_use.'.php');
			
			}	
			
			include_once _DR_.'/dg_admin/_components/'.$this->_comp.'/'.$this->_use.'.sys.php';
			
			
			
		}else{
			
			echo '<h3>'.$this->LANG->LANG['admin']['component_not_found'].'</h3>';
			echo '<p class="comment">/dg_admin/_components/'.$this->_comp.'/'.$this->_use.'.sys.php</p>';
		}
		
		
	}
	
	

	
	public	function setupcomp(){
		
            $this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>moders
            (id int(11) NOT NULL auto_increment,
            `comp` varchar(100),
            `func` varchar(300),
            `moders` text,
            PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
            $this->_Q->Q();		
			
			
 				$dir = opendir (_DR_.'/dg_admin/_components/');
  						while ( $file = readdir ($dir))
  						{
    						if (( $file != ".") && ($file != "..") && ( is_dir(_DR_.'/dg_admin/_components/'.$file)) && (file_exists(_DR_.'/dg_admin/_components/'.$file.'/_setups')) && $file!='.svn' )
    							{
					 				$indir = opendir (_DR_.'/dg_admin/_components/'.$file.'/_setups');
					  						while ( $infile = readdir ($indir))
					  						{
					    						if (( $infile != ".") && ($infile != "..") && (is_file(_DR_.'/dg_admin/_components/'.$file.'/_setups/'.$infile)) )
					    							{
													 include_once _DR_.'/dg_admin/_components/'.$file.'/_setups/'.$infile;
					    							}
					  						}
					  				closedir ($indir);
    							}
  						}
  				closedir ($dir);						
		
		echo $this->_Q->_error;
		
	}
	
	
	public function authform(){
		
		if (!$this->_ajax){
		  
          if (array_key_exists('auth',$_POST)){
           $login = $this->_user->login($_POST['login'],$_POST['pass'],true);
           if ($login){  
            if (trim($_POST['req'])!=''){ header("Location:".$_POST['req']); }
           }
          }
          
		  include_once _DR_.'/dg_admin/_templates/'.$this->_tpl.'/auth.tpl.php';
          
          
		}
		
		
	}
    
    public function plugin($name){
        
        if ( file_exists( _DR_.'/dg_lib/dg_plugins/'.$name) ){
            
            
            if ( $this->_regedit->read('dg_plugin_'.$name)=='' ){
                      $randplug = '';  
                      $dir = opendir (_DR_.'/dg_lib/dg_plugins/'.$name);
                      while ( $file = readdir ($dir))
                      {
                        if (( $file != ".") && ($file != "..") && (is_dir(_DR_.'/dg_lib/dg_plugins/'.$name.'/'.$file)) && $file!='.svn')
                        {
                           $randplug = $file;
                        }
                      }
                      closedir ($dir);
                      if ($randplug!=''){
                        $this->_regedit->edit('dg_plugin_'.$name,$randplug); 
                      }  
                
            }
            
            $pldir = _DR_.'/dg_lib/dg_plugins/'.$name .'/'. $this->_regedit->read('dg_plugin_'.$name).'/index.php';
            
            if (file_exists($pldir)) include $pldir;
         
            
        }
        
    }
    
    function access($comp,$func,$showmess=true){

        if ($this->_user->_userinfo['admin']>1) return true; 
        
        if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$this->_Q->e($comp)."' AND `func`='".$this->_Q->e($func)."' AND `moders` LIKE '%{".$this->_user->_userinfo['id']."}%'")>0){ return true; }
        if ($showmess){
        if(!$this->_ajax){?><div class="dg_no_access"><?=$this->LANG['main']['no_access']?></div><?}else{ echo $this->LANG['main']['no_access']; }
        }
        return false;
    }
    
    function accesspassword(){
        
        if ( array_key_exists('cancel',$_POST) ){
            if ($_POST['re']=='') $_POST['re']='/'; 
            header("Location:".urldecode($_POST['re']));
        }
         
        if ( array_key_exists('accesspassword',$_POST) && trim($_POST['accesspassword'])!='' && array_key_exists('goaccess',$_POST) ){
            
            if ( md5(trim($_POST['accesspassword']))==$this->_user->_userinfo['pass'] ){
                return true;
            }else{
                ?>
                <div class="dg_error"><?=$this->LANG['main']['noaccesspassword']?></div>
                <p>&nbsp;</p>
                <?

            }
            
        }
        
        ?>
        <div class="accesspassword">
            <form method="post" class="dg_form" autocomplete="off">
                <p><?=$this->LANG['main']['accesspassword']?><br /><input type="password" name="accesspassword" id="accesspassword" /><input type="submit" name="goaccess" value="<?=$this->LANG['main']['next']?>" /> <input type="submit" name="cancel" value="<?=$this->LANG['main']['cancel']?>" /> <input type="hidden" name="re" value="<?=$_GET['re']?>" /></p>
            </form>
        </div>
        <script>
        $(document).ready(function()	{
        	$("#accesspassword").focus();
        				})</script>
        <?
        
    }
	
    
    function __destruct(){
        

        
    }
	
	
}


?>