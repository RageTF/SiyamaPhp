<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
define(_URL_,'/dg_admin/?comp=source&use=pages&func='); 
if ($this->access('pages','index')){
    $m=0;
    $QW = $this->_Q->QW("SELECT * FROM `<||>pages` ORDER BY `order`");
    foreach ($QW as $i=>$row){
        
        $p = $row['parent'];
        $pages[$p][$m] = $row;
        $m++;
        
    }
    
            function cuttreepage($not,$pages,$parent=0,$gl=1){
            
            
                $y=0;
                if (is_array($pages[$parent])){
        
                    foreach($pages[$parent] as $i=>$row){
                     $row['menu'] = ($row['menu'] != "") ? $row['menu'] : $row['name'];
                      if ($row['id']!=$not){  
                        echo '<option value="'.$row['id'].'">'.str_repeat('&nbsp;&nbsp;&nbsp;',$gl).$row['menu'].'</option>'."\n";
                        if (array_key_exists($row['id'],$pages)){
                            cuttreepage($not,$pages,$row['id'],($gl+1));
                        }
                      }   
                    }
                 }   
            
        }
        
            function arrsubpage($pages,$parent=0,$gl=1){
            
            
                $y=0;
                if (is_array($pages[$parent])){
        
                    foreach($pages[$parent] as $i=>$row){
                     
                     $GLOBALS['arrpage'][]=$row['id'];
                        if (array_key_exists($row['id'],$pages)){
                            arrsubpage($pages,$row['id'],($gl+1));
                        }  
                    }
                 }   
            
        }

    function adminpagetree($l,$Q,$pages,$parent=0,$gl=0,$url='/',$showorder=true){
        $y=0;

        if (is_array($pages[$parent])){
            ?>
            <ul class="p">
            <?
            foreach($pages[$parent] as $i=>$row){
              $row['menu'] = ($row['menu'] != "") ? $row['menu'] : $row['name'];


                $y++;
                
                $img = '/dg_system/dg_img/icons/page.png';
                $ourl = $url;
                $url.=$row['ind'].'/';
                
                $ex = explode(':',$row['comp']);
                if ($ex[0]=='conf'){
                    

                        $ico = $Q->QA("SELECT * FROM <||>dgcomponent__regedit WHERE `ind`='".$Q->e($ex[1])."'");
                        if (trim($ico['ico'])==''){
                            if ($ico['id']=='') $img='/dg_system/dg_img/icons/color_swatch_2-none.png'; else $img='/dg_system/dg_img/icons/color_swatch_2.png';
                        }else{
                            $img=$ico['ico'];
                        }

                }
                
                if ($ex[0]=='system'){
                    if (file_exists(_DR_.'/dg_lib/dg_components/'.$ex[1].'/ico.png')) $img = '/dg_lib/dg_components/'.$ex[1].'/ico.png';
                    if (!is_dir(_DR_.'/dg_lib/dg_components/'.$ex[1]))  $img = '/dg_system/dg_img/icons/page-none.png';
                }
                
                
                if ($row['link']!=''){ $img = '/dg_system/dg_img/icons/link.png'; }
                
                
                
                $cl='online';
                if ($y==count($pages[$row['parent']])){$cl='finline';}
                $view = '';
                if ($row['view']==0){ $view=' notview'; }
                
                ?>                <li class="<?=$cl?>" id="<?=$row['id']?>"> <span>
                    <img src="<?=$img?>" /><?
                    if ($row['main']==1){ echo '<img src="/dg_system/dg_img/icons/flag_blue.png" title="'.$l['compsource']['title_pages_update_mainpage'].'" />'; }
                    ?>
                    <a href="<?=_URL_?>editpage&act=index&id=<?=$row['id']?>" class="<?=$view?>"><?=$row['menu']?></a>
                    <div class="b">
                        <a href="<?=_URL_?>update&parent=<?=$row['id']?>" title="<?=$l['compsource']['title_pages_update_create_sub']?>" ><img src="/dg_system/dg_img/icons/add.png" title="<?=$l['compsource']['title_pages_update_create_sub']?>" /></a>
                        <a href="<?=$url?>" target="_blank" title="<?=$l['compsource']['title_pages_go']?>" ><img src="/dg_system/dg_img/icons/application_go.png" title="<?=$l['compsource']['title_pages_go']?>" /></a>
                        <a href="<?=_URL_?>update&id=<?=$row['id']?>" title="<?=$l['compsource']['title_pages_setting_page']?>"  ><img src="/dg_system/dg_img/icons/hammer.png" title="<?=$l['compsource']['title_pages_setting_page']?>"  /></a>
                        <a href="<?=_URL_?>cut&id=<?=$row['id']?>" title="<?=$l['compsource']['title_pages_cut']?>"  ><img src="/dg_system/dg_img/icons/cut.png" title="<?=$l['compsource']['title_pages_cut']?>"  /></a>
                        <a href="<?=_URL_?>access&id=<?=$row['id']?>" title="<?=$l['compsource']['title_pages_access']?>"  ><img src="/dg_system/dg_img/icons/group_key.png" title="<?=$l['compsource']['title_pages_access']?>"  /></a>
                        <a href="<?=_URL_?>remove&id=<?=$row['id']?>" title="<?=$l['compsource']['title_pages_remove']?>"  ><img src="/dg_system/dg_img/icons/cross.png" title="<?=$l['compsource']['title_pages_remove']?>"  /></a>
                    </div>
                    </span>
                    
                    <?
                    if ($showorder){
                    if ( $y!=1 ){?><img src="/dg_system/dg_img/icons/up.gif" class="order" title="up" /><?}?>
                    
                    <?if ( $y!=count($pages[$row['parent']]) ){?><img src="/dg_system/dg_img/icons/down.gif"  class="order"  title="down"   /><?}
                    }
                    ?>

                
<?
                
                if (array_key_exists($row['id'],$pages)){
                    adminpagetree($l,$Q,$pages,$row['id'],($gl+1),$url,$showorder);
                }
                $url=$ourl;
                
                echo '</li>';
            }
            ?>
            </ul>
            <?
        }
    }

$this->_right='
    <h2>'.$this->LANG['compsource']['pagesname'].'</h2>
    <li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"  title="ctrl + alt + n"><a href="'._URL_.'update">'.$this->LANG['compsource']['title_pages_update_create'].'</a></li>
    <li style="background:url(/dg_system/dg_img/icons/chart_organisation.png) no-repeat left center;"><a href="'._URL_.'index">'.$this->LANG['compsource']['pagesname'].'</a></li>
    <div class="r"></div>
';


if ($this->_func=='index'){//TODO:index
/**
*выгружаем список разделов
*/
    
    
    
    
    

    
   
?>
	<h2><?=$this->LANG['compsource']['pagesname']?></h2>
    <div class="help"><?=$help['index']?></div><p>&nbsp;</p>
    <div class="adminpagetree dg_form">
    <strong id="parent0"><?=$_SERVER[HTTP_HOST]?></strong>
<?
    adminpagetree($this->LANG,$this->_Q,$pages);
?></div><?
}

if ($this->_func=='update'){//TODO:update
    if ($this->access('pages','update')){
    $p=false;
    if (array_key_exists('parent',$_GET)){
        $inf = $this->_Q->QA("SELECT * FROM <||>pages WHERE `id`='".$this->_Q->e($_GET['parent'])."'");
        if ($inf['id']!=''){
            $parentname = $inf['menu'];
            $inf['id']='';
            $inf['name']='';
            $inf['menu']='';
            $inf['ind']='';
            $inf['link']='';
        $p=true;
        }
    }
    
    if (array_key_exists('id',$_GET)){
        $inf = $this->_Q->QA("SELECT * FROM <||>pages WHERE `id`='".$this->_Q->e($_GET['id'])."'");
    }
    
    if ($inf['id']!=''){
        $pc = new dg_page($this->_Q);
        $pc->_id=$inf['id'];
        $pc->info();        
                 $this->_right.='    <li style="background:url(/dg_system/dg_img/icons/application_go.png) no-repeat left center;"><a href="'. $pc->_pages[$inf['id']]['url'] .'" target="_blank">'.$this->LANG['compsource']['title_pages_go'].'</a></li>
    
                    <li style="background:url(/dg_system/dg_img/icons/group_key.png) no-repeat left center;"><a href="'._URL_.'access&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_access'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/cross.png) no-repeat left center;"><a href="'._URL_.'remove&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_remove'].'</a></li>
                    <div class="r"></div>';    
        
    }
    
    if (array_key_exists('go',$_POST)){
        
             foreach ($_POST as $i=>$v){
                $_POST[$i] = htmlspecialchars_decode($v);
            } 
        
        if (array_key_exists('save',$_POST)){
 
        
        
        
        
        $error='';
        
        $parent = 0;
        if ($_POST['parent']!='' && is_numeric($_POST['parent'])){ $parent = $_POST['parent']; }
        
        if (trim($_POST['name'])==''){ $error.='<li>'.$this->LANG['compsource']['title_pages_update_name_error'].'</li>'; }
        if (trim($_POST['ind'])==''){ $error.='<li>'.$this->LANG['compsource']['title_pages_update_ind_error'].'</li>'; }else{
            
          if ($inf['ind']!=$_POST['ind']){  
            $n = $this->_Q->QN("SELECT `ind`,`parent` FROM `<||>pages` WHERE `ind` = '".$this->_Q->e($_POST['ind'])."' AND `parent`='".$this->_Q->e($parent)."' ");
            
            if ($n>0){
                $error.='<li>'.$this->LANG['compsource']['title_pages_update_ind_error2'].'</li>';
            }
          }  
            
        }
        
        if (trim($_POST['tpl'])==''){ $error.='<li>'.$this->LANG['compsource']['title_pages_update_tpl_error'].'</li>'; }
        if (trim($_POST['comp'])==''){ $error.='<li>'.$this->LANG['compsource']['title_pages_update_comp_error'].'</li>'; }
        
        if ($error==''){
            
                    if ($inf['id']==''){
                        $d = " DESC";
                        if ($_POST['addto']==1){ $d=''; }
                        $il = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `parent`='".$this->_Q->e($parent)."' ORDER BY `order` ".$d." LIMIT 1");           
                        if ($_POST['addto']==1){ $arr['order']=$il['order']-1;}else{$arr['order']=$il['order']+1;}
                    }
                    
                    
                    if ($_POST['main']==1){
                        $arr['main']=1;
                        $mainarr['main']=0;
                        $this->_Q->_arr = $mainarr;
                        $this->_Q->_where = " WHERE `main`=1 ";
                        $this->_Q->_table = "pages";
                        $this->_Q->QU();
                    }
                    
                    $arr['name'] = $_POST['name'];
                    $arr['menu'] = $_POST['menu'];
                    $arr['ind'] = $_POST['ind'];
                    $arr['link'] = $_POST['link'];
                    $arr['tpl'] = $_POST['tpl'];
                    $arr['view'] = $_POST['view'];
                    $arr['comp'] = $_POST['comp'];
                    $arr['kw'] = $_POST['kw'];
                    $arr['des'] = $_POST['des'];
                    $arr['css'] = $_POST['css'];
                    $arr['cache'] = $_POST['cache'];
                    $arr['search'] = $_POST['search'];
                    $arr['max'] = $_POST['max'];
                    $arr['lastmod'] = time();
                    if ($inf['id']==''){$arr['parent'] = $parent;}
                    
                        $this->_Q->_arr = $arr;
                        $this->_Q->_table='pages';
                        
                        $page = new dg_page($this->_Q);
                        
                        
                       if ($inf['id']==''){ 
                        $page->_id = $this->_Q->QI();
                        }else{
                        $this->_Q->_where=" WHERE `id`='".$inf['id']."'";
                        $this->_Q->QU();
                        $page->_id = $inf['id'];
                       }
                       
                       $page->info();
                       $page->installcomp();
                       
                        
                        
                        if ($this->_Q->_error!=''){ $error=$this->_Q->_error; }else{
                            $o=0;
                            $arr='';
                            $QW = $this->_Q->QW("SELECT * FROM `<||>pages` WHERE `parent`='".$this->_Q->e($parent)."' ORDER BY `order`");
                            foreach ($QW as $i=>$row){
                                $o++;
                                $arr['order']=$o;
                                $this->_Q->_arr = $arr;
                                $this->_Q->_table='pages';
                                $this->_Q->_where=" WHERE `id`='".$row['id']."'";
                                $this->_Q->QU();
                                
                            }
                            
                        }
                    
                    
        }
        
        
        
        
     }   
        
        if ($error==''){header("Location:"._URL_.'index');}else{
            
            foreach ($_POST as $i=>$v){
                $inf[$i]=$v;
            }
            
        }
           if (is_array($inf)){ 
            foreach ($inf as $i=>$v){
                $inf[$i]= htmlspecialchars($v) ;
            }       
           }
    }
    
    
    
    ?>

	<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();		
        $("#tabs").click(function(){
            if ($("#tabs #menu").val()==''){
                $("#tabs #menu").val($("#tabs #name").val());
            }
        });
        $("#transind").click(function(){
            gt('#menu','#ind');
            return false;
        });
        $(".comp").click(function(){
            var i = '#box_'+$(this).attr('id');
           
                $(".boxcomp").css('display','none');
                $(i).css('display','block');
                $(i+' input[type="radio"]:first').click();

        });
	});
	</script>

	
    <? if (!$p && $inf['id']==''){ ?><h2><?=$this->LANG['compsource']['title_pages_new_page']?></h2><?}?>	
    <? if ($p){ ?><h2><?=$parentname?> : <?=$this->LANG['compsource']['title_pages_update_create_sub']?></h2><?}?>	
    <? if ($inf['id']!=''){ ?><h2><?=$this->LANG['compsource']['title_pages_setting_page']?> : <?=$inf['menu']?></h2><?}?>	
		<div class="help"><?=$help['update']?></div><p>&nbsp;</p>
    <?if ($error!=''){echo '<div class="dg_error">'.$error.'</div><p>&nbsp;</p>';}?>
	<div class="dg_form">	
		<form method="post">
         <?=$this->_security->creat_key()?>
             <div id="tabs">
            					<ul>
            						<li><a href="#tabs-1" class="ct"><?=$this->LANG['compsource']['title_pages_update_def']?></a></li>
            						<li><a href="#tabs-2" class="ct"><?=$this->LANG['compsource']['title_pages_update_seo']?></a></li>
            						<li><a href="#tabs-3" class="ct"><?=$this->LANG['compsource']['title_pages_update_other']?></a></li>           
            					</ul>
                                
                                <div id="tabs-1">
                                
                                    <div class="dg_table">
                                        <div class="dg_tr">
                                        
                                            <div class="dg_td w40">                                   
                                                    <p><?=$this->LANG['compsource']['title_pages_update_name']?><br /> <input type="text" name="name" id="name" class="w90" value="<?=$inf[name]?>" /> </p>
                                                    <p><?=$this->LANG['compsource']['title_pages_update_menu']?><br /> <input type="text" name="menu" id="menu" class="w90" value="<?=$inf[menu]?>" /> </p>                                                    
                                                    <p><?=$this->LANG['compsource']['title_pages_update_ind']?><br /> <input type="text" name="ind" id="ind" class="w80"  value="<?=$inf[ind]?>" /> <button id="transind">&larr;</button></p>
                                                    <p><?=$this->LANG['compsource']['title_pages_update_link']?><br /> <input type="text" name="link" class="w90" value="<?=$inf[link]?>"  /> </p>
                                                    <p><?=$this->LANG['compsource']['title_pages_update_tpl']?><br /> <select name="tpl"  class="w90" >
                                                    <?
                                                    
                                                    
                                                     
                                         				$dir = opendir (_DR_.'/_tpl/'.$this->inf['info']['dir']);
                                          						while ( $file = readdir ($dir))
                                          						{
                                            						if (( $file != ".") && ($file != "..") && ( is_dir(_DR_.'/_tpl/'.$this->inf['info']['dir'].'/'.$file)) && (file_exists(_DR_.'/_tpl/'.$this->inf['info']['dir'].'/'.$file.'/index.dg.php')) && $file!='.svn' )
                                            							{
                                            							 $sel='';
                                                                         if ($file==$inf['tpl']){$sel=' selected ';}
                                            							 echo '<option'.$sel.'>'.$file.'</option>';
                                            							}
                                                                }
                                                        closedir ($dir);     
                                                        
                                                       
                                                    
                                                    ?>
                                                    
                                                    </select> </p>
                                                    <p> <label> <input type="checkbox" name="view" value="1" <? if ($inf['view']==1 OR $inf['view']==''){ echo ' checked '; } ?> /> <?=$this->LANG['compsource']['title_pages_update_view']?></label> </p>
                                           <? if ($inf['id']==''){ ?> <p> 
                                                <?=$this->LANG['compsource']['title_pages_update_addto']?><br />
                                                <label> <input type="radio" name="addto" value="0"  <? if ($inf['addto']==0 OR $inf['addto']==''){ echo ' checked '; } ?> /> <?=$this->LANG['compsource']['title_pages_update_addtofin']?></label>
                                                <label> <input type="radio" name="addto" value="1" <? if ($inf['addto']==1){ echo ' checked '; } ?> /> <?=$this->LANG['compsource']['title_pages_update_addtostart']?></label>
                                            </p>
                                           <?}?> 
                                           <p> <label> <input type="checkbox" name="main" value="1" <? if (($inf['main']==1 && $inf['id']!='') || $this->_Q->QN("SELECT `main` FROM <||>pages WHERE `main`=1")==0){ echo ' checked '; } ?> /> <?=$this->LANG['compsource']['title_pages_update_mainpage']?></label> </p>
                                            </div>
                                            <div class="dg_td w60"> <p><strong><?=$this->LANG['compsource']['title_pages_update_comp']?></strong></p> 
                                                <div class="selectcomp">
                                                
                                                <?
                                                
		$total='';
        $f = new dg_file;
       
            $ex = explode(':',$inf['comp']);
            
        $dir = opendir ( _DR_.'/dg_lib/dg_components/');
          while ( $file = readdir ($dir))
          {
            if (( $file != ".") && ($file != "..") && (substr_count($file,'sample.')==0))
            {
                $ico = '/dg_system/dg_img/icons/page.png';
                $infoxml = _DR_.'/dg_lib/dg_components/'.$file.'/info.xml';
                if (file_exists($infoxml)){
                    if (file_exists(_DR_.'/dg_lib/dg_components/'.$file.'/ico.png')){
                        $ico ='/dg_lib/dg_components/'.$file.'/ico.png';                        
                        $c = simplexml_load_file($infoxml);
                        
                               foreach($c as $e=>$p){ $param[$e]=$p;}
                               $compinfo = $param['original'];
                               if ( array_key_exists($this->LANGLOAD->_def,$param) ){ $compinfo = $param[$this->LANGLOAD->_def]; }
                        
                        
                        $sel='';
                        
                        if ($ex[0]=='system' && $ex[1]==$file){ $sel='checked '; } //echo $ex[0].'-'.$ex[1].'-'.$file;

                           $total.=' <li style="background:url('.$ico.') no-repeat left top;">';  
                           $total.=' <label> <input type="radio" name="comp"  class="comp" value="system:'.$file.'" '.$sel.' /> '.$compinfo.' </label> ';    
                           $total.='</li>';                   

                        
                    }
                }

            }
          }
          closedir ($dir);
        
		
		
		$QW = $this->_Q->QW("SELECT * FROM <||>dgcomponent__regedit");
		
		foreach ($QW as $i=>$row){
			
			
			$ico = '/dg_system/dg_img/icons/color_swatch_2.png';
			if ($row['ico']!=''){
				
				$ico=$row['ico'];
			}
            
            
            $total.='       <li style="background:url('.$ico.') no-repeat left top;">';
            $total.='<label> <input type="radio" name="comp" class="comp" id="comp_'.$row['id'].'" value="conf:'.$row['ind'].'" /> '.$row['name'].'</label>';
                $display='none';
                if ($ex[1]==$row['ind']){$display='block';}
                $total.='       <ul id="box_comp_'.$row['id'].'" class="boxcomp" style="display:'.$display.'">';
                
                
                
                $d =  _DR_.'/_comp/'.$this->inf['info']['dir'].'/'.$row['ind'].'/_tpl/';
             		if (file_exists($d)){	 
                          $opendir = opendir ($d);
            		      while ( $file = readdir ($opendir))
            		      {
            		        if (( $file != ".") && ($file != "..") && (is_dir($d.$file)) && $file!='.svn')
            		        {
            		          $total.="\n".'<li style="background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;">';
            		          $sel='';
                              
                              if ($ex[2]==$file && $ex[1]==$row['ind']){ $sel=' checked '; } 
                              $total.='<label> <input type="radio" name="comp" value="conf:'.$row['ind'].':'.$file.'" '.$sel.' />'.$file.'</label>';
            		            
            		          $total.='</li>'."\n";
            		        }
            		      }
            		      closedir ($opendir);
                       }
                
                $total.="\n".'       </ul>';
            $total.='</li>';
        }     
        
        echo $total;
                                                
                                                ?>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                                   
                                </div>
                                <div id="tabs-2">
                                    <p><?=$this->LANG['compsource']['title_pages_update_kw']?><br /> <input type="text" name="kw" class="w90" value="<?=$inf['kw']?>" /> </p>
                                    <p><?=$this->LANG['compsource']['title_pages_update_des']?><br /> <input type="text" name="des" class="w90" value="<?=$inf['des']?>" /> </p>
                                </div>
                                <div id="tabs-3">
                                    <p><?=$this->LANG['compsource']['title_pages_update_css']?><br /> <input type="text" name="css" class="w50" value="<?=$inf['css']?>" /> </p>
                                    <p> <label> <input type="checkbox" name="cache" value="1" <? if ($inf['cache']==1 OR $inf['cache']==''){ echo ' checked '; } ?> /> <?=$this->LANG['compsource']['title_pages_update_cache']?></label> </p>
                                    <p> <label> <input type="checkbox" name="search" value="1" <? if ($inf['search']==1 OR $inf['search']==''){ echo ' checked '; } ?> /> <?=$this->LANG['compsource']['title_pages_update_search']?></label> </p>
                                    <p><?=$this->LANG['compsource']['title_pages_update_max']?><br /> <input type="text" name="max" class="w10"  value="<? if ($inf['max']==''){ echo '20'; }else{ echo $inf['max']; } ?>" /> </p>                                
                                </div>                            
             </div>
			<p>&nbsp;</p>	<input type="hidden" name="go" value="1" /> 
            <input type="hidden" name="parent" value="<? $pa=0; if ($p && is_numeric($_GET['parent'])){ echo $_GET['parent']; $pa++; } if ($inf['id']!=''){ echo $inf['parent'];  $pa++; } if ($pa==0){ echo 0; } ?>" />
			<p><input type="submit" name="save" value="<?=$this->LANG['main']['save']?>" /> 
        	<input type="reset" name="reset" value="<?=$this->LANG['main']['cancel']?>" /></p>
        </form>
    </div>        
    
    
    <?
    }    
}


if ($this->_func=='reorder'){ //TODO:reorder
if ($this->access('pages','update')){
/**
*меняем порядок
*/
        $i = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `id`='".$this->_Q->e($_POST['ids'])."' LIMIT 1");
        if ($i['id']!=''){
           
            
            $z='`order`>'.$i['order']; $desc="";
            if ($_POST['w']=='up'){$z='`order`<'.$i['order']; $desc="DESC";}
            
            $w = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `parent`='".$i['parent']."' AND ".$z." ORDER BY `order` ".$desc."  LIMIT 1");
            if ($w['id']!=''){
                    $this->_Q->_table='pages';
                    $this->_Q->_where = " WHERE `id`='".$i['id']."' ";
                    $arr['order'] = $w['order']; 
                    $arr['lastmod']=time();
                    $this->_Q->_arr = $arr;
                    $this->_Q->QU(); 
                    
                    $this->_Q->_table='pages';
                    $this->_Q->_where = " WHERE `id`='".$w['id']."' ";
                    $arr['order'] = $i['order']; 
                    $arr['lastmod']=time();
                    $this->_Q->_arr = $arr;
                    $this->_Q->QU(); 
            }
        }
        
        if ($this->_Q->_error!=''){echo $this->_Q->_error;}else{
            
                            $o=0;
                            $arr='';
                            $QW = $this->_Q->QW("SELECT * FROM `<||>pages` WHERE `parent`='".$i['parent']."' ORDER BY `order`");
                            foreach ($QW as $i=>$row){
                                $o++;
                                $arr['order']=$o;
                                $this->_Q->_arr = $arr;
                                $this->_Q->_table='pages';
                                $this->_Q->_where=" WHERE `id`='".$row['id']."'";
                                $this->_Q->QU();
                                
                            }
            
            echo 'ok';}
            }            
}
 
 if ($this->_func=='reloadtree'){//TODO:reloadtree
 /**
 *перезагружаем дерево???
 */
    ?>
        <strong id="parent0"><?=$_SERVER[HTTP_HOST]?></strong>
<?
    adminpagetree($this->LANG,$this->_Q,$pages);

 }
 
 
 if ($this->_func=='index' || $this->_func=='reloadtree'){
    ?>    <script> 
    $(document).ready(function()	{
    
    $('.order').css('opacity',0.3).hover(function(){$(this).css('opacity',1);},function(){$(this).css('opacity',0.3);}).click(function(){
        var m = $(this).attr('title');
        var id = $(this).parent('li').attr('id');
        
        $.post('<?=_URL_?>reorder',{ids:id,w:m},function(data){
            if (data=='ok'){
                $('.adminpagetree').load('<?=_URL_?>reloadtree');
            }else{alert (data);}
        });
        
        
        return false;
    });
    
    var to=0;
    var moov = false;
            
         	$(".adminpagetree li span").hover(function(){
         	 if (!moov){ $(this).children("div.b").css('display','block').css('margin-left','5px'); $('.order').css('display','none'); }
         	},function(){
         	  $(this).children("div.b").css('display','none');  $('.order').css('display','inline');
         	});

            
         				}) 
                         </script><?
 }
 
 if ($this->_func=='cut'){//TODO:cut
 /**
 *переносим раздел
 */
  if ($this->access('pages','update')){  
    $inf = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `id`='".$this->_Q->e($_GET['id'])."'");
    $inf['menu'] = ($inf['menu'] != "") ? $inf['menu'] : $inf['name'];
    if ($inf['id']==''){
        
        echo $this->LANG['compsource']['title_pages_not_found'];
        
    }else{
        $pc = new dg_page($this->_Q);
        $pc->_id=$inf['id'];
        $pc->info();        
                 $this->_right.='    <li style="background:url(/dg_system/dg_img/icons/application_go.png) no-repeat left center;"><a href="'. $pc->_pages[$inf['id']]['url'] .'" target="_blank">'.$this->LANG['compsource']['title_pages_go'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/hammer.png) no-repeat left center;"><a href="'._URL_.'update&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_setting_page'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/group_key.png) no-repeat left center;"><a href="'._URL_.'access&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_access'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/cross.png) no-repeat left center;"><a href="'._URL_.'remove&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_remove'].'</a></li>
                    <div class="r"></div>';    
        
        if (array_key_exists('go',$_POST)){
            if (array_key_exists('save',$_POST)){
                
                $to = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `id`='".$this->_Q->e($_POST['to'])."'");
                if ($to['id']!='' || $_POST['to']==0){
                    if ($_POST['to']==0){ $to['id']=0; }
                    
                    $order = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `parent`='".$to['id']."' ORDER BY `order` DESC LIMIT 1");;
                    
                    $arr['parent'] = $to['id'];
                    $arr['order'] = $order['order']+1;
                    $arr['lastmod']=time();
                    $this->_Q->_table='pages';
                    $this->_Q->_where = " WHERE `id`='".$inf['id']."' ";
                    $this->_Q->_arr = $arr;
                    $this->_Q->QU(); 
                    
                }
                
            }
            header("Location:"._URL_.'index');
        }
        
        
        ?>
        <h2><?=$inf['menu']?> : <?=$this->LANG['compsource']['title_pages_cut']?></h2>
        
        <form method="post">
         <?=$this->_security->creat_key()?>
            <div class="dg_form">
                <p><?=$this->LANG['compsource']['title_pages_cut_text']?><br /><select name="to">
                <option value="0"><?=$this->LANG['compsource']['title_pages_cut_root']?></option>
                <?=cuttreepage($inf['id'],$pages)?>
                </select></p>            			 
             <p><input type="hidden" name="go" value="1" /><input type="submit" name="save" value="<?=$this->LANG['main']['save']?>" /> 
        	<input type="reset" name="reset" value="<?=$this->LANG['main']['cancel']?>" /></p>
            </div>


        </form>
        
        <?
    }
   }     
 }
 
 if ($this->_func=='remove'){//TODO:remove
 /**
 *удаляем раздел
 */
 
 if ($this->access('pages','update') && $this->access('pages','remove')){
     $inf = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `id`='".$this->_Q->e($_GET['id'])."'");
     $inf['menu'] = ($inf['menu'] != "") ? $inf['menu'] : $inf['name'];
    if ($inf['id']==''){
        
        echo $this->LANG['compsource']['title_pages_not_found'];
        
    }else{
        $pc = new dg_page($this->_Q);
        $pc->_id=$inf['id'];
        $pc->info();        
                 $this->_right.='    <li style="background:url(/dg_system/dg_img/icons/application_go.png) no-repeat left center;"><a href="'. $pc->_pages[$inf['id']]['url'] .'" target="_blank">'.$this->LANG['compsource']['title_pages_go'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/hammer.png) no-repeat left center;"><a href="'._URL_.'update&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_setting_page'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/group_key.png) no-repeat left center;"><a href="'._URL_.'access&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_access'].'</a></li>
                    <div class="r"></div>';    
        
        $n = $this->_Q->QN("SELECT `parent` FROM <||>pages WHERE `parent`='".$inf['id']."'");
        
        
        if (array_key_exists('go',$_POST)){
            
            if ($n>0 && array_key_exists('cutandremove',$_POST) && is_numeric($_POST['to']) && ($this->_Q->QN("SELECT `id` FROM <||>pages WHERE `id`='".$this->_Q->e($_POST['to'])."'")==1  || $_POST['to']==0) ){
                
                $last = $this->_Q->QA("SELECT * FROM <||>pages WHERE `parent`='".$this->_Q->e($_POST['to'])."' ORDER BY `order` DESC LIMIT 1");
                $QW = $this->_Q->QW("SELECT * FROM <||>pages WHERE `parent`='".$inf['id']."'");
                $order = $last['order']; 
                foreach ($QW as $i=>$row){
                    if ($row[0]!=''){
                        $order++;
                        $arr='';
                        $arr['parent'] = $_POST['to'];
                        $arr['order'] = $order;
                        $this->_Q->_arr=$arr;
                        $this->_Q->_table = 'pages';
                        $this->_Q->_where = "WHERE `id`='".$row['id']."'";
                        $this->_Q->QU();
                        
                    }
                }
                
            }
            if ( array_key_exists('removeall',$_POST) || array_key_exists('cutandremove',$_POST) ){
                
                $pages='';
                $m=0;
                $QW = $this->_Q->QW("SELECT * FROM `<||>pages` ORDER BY `order`");
                foreach ($QW as $i=>$row){
                    
                    $p = $row['parent'];
                    $pages[$p][$m] = $row;
                    $m++;
                    
                }
                
                
                arrsubpage($pages,$inf['id']);
                
                $GLOBALS['arrpage'][]=$inf['id'];
                
                foreach ($GLOBALS['arrpage'] as $i=>$id){
                    if ($id!=''){
                        $del = $this->_Q->QA("SELECT * FROM <||>pages WHERE `id`='".$id."'");
                        if ($del['id']!=''){
                            
                                    $p = new dg_page($this->_Q);
                                    $p->_id = $del['id'];
                                    $p->info();
                            
                            $this->_Q->_table = 'pages';
                            $this->_Q->_where = "WHERE `id`='".$del['id']."'";
                            $this->_Q->QD(); 
                            
                                    $p->removepage();  
                            

                            
                        }                     
                        
                    }
                }
            }
            
            header("Location:"._URL_.'index');
            
        }
        
        
     ?>
      
      <h2><?=$inf['menu']?> : <?=$this->LANG['compsource']['title_pages_remove']?></h2>
      <p><?=$this->LANG['compsource']['title_pages_remove_note']?></p>
      <form method="post">
       <?=$this->_security->creat_key()?>
      <input type="hidden" name="go" value="1" />
          <div class="dg_form">
          <? if ($n>0){ ?>
           <p><?=$this->LANG['compsource']['title_pages_remove_note2']?> <br /><select name="to">
                    <option value="0"><?=$this->LANG['compsource']['title_pages_cut_root']?></option>
                    <?=cuttreepage($inf['id'],$pages)?>
                    </select> <input  type="submit" name="cutandremove" value="<?=$this->LANG['compsource']['title_pages_remove_note2_1']?>" /></p>
                    <?}?>
                    <p><input  type="submit" name="removeall" value="<?=$this->LANG['compsource']['title_pages_remove_note3']?>" onclick="return confirm('<?=$this->LANG['compsource']['title_pages_remove_note4']?>');" /> <input  type="submit" name="cancel" value="<?=$this->LANG['main']['cancel']?>" /></p>
          </div>
      </form>
     
  
     <?
    } 
    }
 }
 
 
 if ($this->_func=="access"){//TODO:access
 
 if ($this->access('pages','access')){
      $inf = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `id`='".$this->_Q->e($_GET['id'])."'");
     $inf['menu'] = ($inf['menu'] != "") ? $inf['menu'] : $inf['name'];
    if ($inf['id']==''){
        
        echo $this->LANG['compsource']['title_pages_not_found'];
        
    }else{ 
        $pc = new dg_page($this->_Q);
        $pc->_id=$inf['id'];
        $pc->info();
                $this->_right.='    <li style="background:url(/dg_system/dg_img/icons/application_go.png) no-repeat left center;"><a href="'. $pc->_pages[$inf['id']]['url'] .'" target="_blank">'.$this->LANG['compsource']['title_pages_go'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/hammer.png) no-repeat left center;"><a href="'._URL_.'update&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_setting_page'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/cross.png) no-repeat left center;"><a href="'._URL_.'remove&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_remove'].'</a></li>
                    <div class="r"></div>';    
                            
        if ( array_key_exists('useraccess',$_POST) ){
          $access='';
          $QW = $this->_Q->QW("SELECT * FROM <||>user__groups");
            foreach($QW as $i=>$row){
                
                if ($row[0]!=''){
                    if ($_POST['g_'.$row['id']]==1){
                        $access.=$row['id'].';';
                        
                    }
                }
            }
            
            if ($access!='') $access=';'.$access;
           
     
            $this->_Q->_arr=array('access'=>$access);
            $this->_Q->_table='pages';
            $this->_Q->_where=" WHERE `id`=".$inf[id];
            $this->_Q->QU();
            
            header("Location:"._URL_.'access&id='.$inf[id]);
            
        }
        
    ?><h2><?=$inf['menu']?> : <?=$this->LANG['compsource']['title_pages_access']?></h2>
    
    <script type="text/javascript">
    
    $(document).ready(function()	{
    	$('#all').click(function(){
    	   if (!this.checked){
    	       $('.gaccess').removeAttr("disabled").attr('checked','checked');
    	   }else{
    	       $('.gaccess').removeAttr('checked').attr('disabled','disabled');
    	   }
    	});
    	$('#mall').click(function(){
    	   if (!this.checked){
    	       $('.mgaccess').removeAttr("disabled").attr('checked','checked');
    	   }else{
    	       $('.mgaccess').removeAttr('checked').attr('disabled','disabled');
    	   }
    	});
    				})
    
    </script>
    
    <form method="post" autocomplete="off">
     <?=$this->_security->creat_key()?>
        <div class="dg_form">
        
        <p> <label> <input type="checkbox" name="all" id="all" value="1" <? if(trim($inf['access'])==''){?> checked<?}  ?> /> <?=$this->LANG['compsource']['title_pages_access_all']?></label> </p>
        <?
        
         $QW = $this->_Q->QW("SELECT * FROM <||>user__groups");
            foreach($QW as $i=>$row){
                
                if ($row[0]!=''){
                    ?>
         <p> <label> <input type="checkbox" id="g_<?=$row['id']?>" name="g_<?=$row['id']?>" value="1" class="gaccess" <? if ( substr_count($inf['access'],';'.$row['id'].';')===1 ){ echo ' checked '; } if(trim($inf['access'])==''){?> disabled<?} ?> /> <?=$row['name']?></label> </p>           
                    <?
                }
            }    
        
        ?>
        <p><input type="submit" name="useraccess" value="<?=$this->LANG['main']['save']?>" /></p>
        </div>
    </form>
    <?
    
    if ($this->_user->_userinfo['admin']==2){
        
        if ( array_key_exists('moderaccess',$_POST) ){
            
              $access='';
              $QW = $this->_Q->QW("SELECT * FROM <||>user WHERE `admin`=1");
                foreach($QW as $i=>$row){
                    
                    if ($row[0]!=''){
                        if ($_POST['g_'.$row['id']]==1){
                            $access.=$row['id'].';';
                            
                        }
                    }
                }
                
                if ($access!='') $access=';'.$access;
               
         
                $this->_Q->_arr=array('moders'=>$access);
                $this->_Q->_table='pages';
                $this->_Q->_where=" WHERE `id`=".$inf[id];
                $this->_Q->QU();
                
                header("Location:"._URL_.'access&id='.$inf[id]);            
            
            
        }
    
        ?>
        <p>&nbsp;</p>
        <h2><?=$inf['menu']?> : <?=$this->LANG['compsource']['title_pages_access_moder'] ?></h2>
         <form method="post" autocomplete="off">
          <?=$this->_security->creat_key()?>
            <div class="dg_form">
            
            <p> <label> <input type="checkbox" name="mall" id="mall" value="1" <? if(trim($inf['moders'])==''){?> checked<?}  ?> /> <?=$this->LANG['compsource']['title_pages_access_moder_all']?></label> </p>
            <?
            
             $QW = $this->_Q->QW("SELECT * FROM <||>user WHERE `admin`=1");
                foreach($QW as $i=>$row){
                    
                    if ($row[0]!=''){
                        ?>
             <p> <label> <input type="checkbox" id="g_<?=$row['id']?>" name="g_<?=$row['id']?>" value="1" class="mgaccess" <? if ( substr_count($inf['moders'],';'.$row['id'].';')===1 ){ echo ' checked '; } if(trim($inf['moders'])==''){?> disabled<?} ?> /> <?=$row['name']?></label> </p>           
                        <?
                    }
                }    
            
            ?>
            <p><input type="submit" name="moderaccess" value="<?=$this->LANG['main']['save']?>" /></p>
            </div>
    </form>       
        <?
    }
    }
    }
 }


 if ($this->_func == 'editpage'){//TODO:editpage
 /**
 *редактируем, создаем раздел
 */
    

    if (array_key_exists('act',$_GET)){
        $this->_act = $_GET['act'];
    }
    
    $inf = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `id`='".$this->_Q->e($_GET['id'])."'");
    $inf['menu'] = ($inf['menu'] != "") ? $inf['menu'] : $inf['name'];
    if ($inf['id']==''){
    echo $this->LANG['compsource']['title_pages_not_found'];
        
    }else{
        
        $GLOBALS['admpageid']=$inf['id'];
        $GLOBALS['admpageq']=$this->_Q;


                function lastmod(){
                    if (is_object($GLOBALS['admpageq']) && is_numeric($GLOBALS['admpageid'])){
                        $GLOBALS['admpageq']->_table='pages';
                        $GLOBALS['admpageq']->_where='WHERE `id`='.$GLOBALS['admpageid'];
                        $GLOBALS['admpageq']->_arr = array('lastmod'=>time());
                        $GLOBALS['admpageq']->QU();
                    }
                }
                
                    
                
                if ((trim($inf['moders'])=='') || (trim($inf['moders'])!='' &&  substr_count($inf['moders'],$this->_user->_userinfo[id])===1) || ($this->_user->_userinfo['admin']==2)){
        
        
        
                        $p = new dg_page($this->_Q);
                        $p->_id=$inf['id'];
                        $p->info();
                        
                        define('CONTENT',true);
                
                        if (!$this->_ajax){
                        ?>

                        <h2><?=$inf['menu']?> </h2>
                        
                        <?
                        }
                        
                        
                        $comp = explode(':',$inf['comp']);
                
                        if ( file_exists(_DR_.'/dg_admin/_components/source/pages/'.$comp[0].'.php') ){
                   
                            include_once _DR_.'/dg_admin/_components/source/pages/'.$comp[0].'.php';
                        }else{
                            echo $this->LANG['main']['system_error'];
                        }
        

                    
            }else{
         ?>
        <div class="dg_no_access"><?=$this->LANG['main']['no_access']?></div>
        <?               
            }             
        
        
    }    
    
 }
 $fc = new dg_file;
 $fc->clearcache();
 }
?>