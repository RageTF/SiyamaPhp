<?php

/**
 * @author mrhard
 * @copyright 2010
 */
if ($this->access('users','index')){
define(_URL_,'/dg_admin/?comp=source&use=users&func='); 

$ico[2]='/dg_system/dg_img/icons/user_business_boss.png';
$ico[1]='/dg_system/dg_img/icons/user_business.png';
$ico[0]='/dg_system/dg_img/icons/user.png';
$ico[-1]='/dg_system/dg_img/icons/user_thief.png';

if ($this->_func=="reorderinfo"){//TODO:reorderinfo
    /**
     * параметры сортировки
     */
     
     $des='DESC';
     $inf = $_COOKIE[_COOPX_.'admin_comp_user_orderinfo'];
     $ex = explode(':',$inf);
     if ($ex[1]=='DESC' && $ex[0]==$_GET['order']) $des='';
     if ($_GET['order']!='') setcookie(_COOPX_.'admin_comp_user_orderinfo',$_GET['order'].':'.$des,0,'/dg_admin/');
     if ($_GET['re']!='') header("Location:".urldecode($_GET['re']));
	

}

if ($this->_func=='index'){//TODO:index
    /**
    *список пользователей
    */
   $order = "`admin` DESC";
   $sortinfo = $_COOKIE[_COOPX_.'admin_comp_user_orderinfo'];
   if ($sortinfo!='') { 
    
    $exorder = explode(':',$sortinfo);
    if ($exorder[0]!=''){
        $access_f = ',admin,login,name,mail,datelst,iplast,';
        if ( substr_count($access_f,','.$exorder[0].',')>0 ){
            $desc = '';
            if ($exorder[1]=='DESC') $desc = ' DESC';
            $order = '`'.$exorder[0].'`'.$desc;
        }
    }
    
   }
    
    ?>
    <h2><?=$this->LANG['compsource']['userlistname']?></h2>
    

    
    
    <?
    $where = "WHERE `id`<>''";
    
    if ( array_key_exists('st',$_GET) AND is_numeric($_GET['st']) ){
        $where.=" AND `admin`='".$this->_Q->e($_GET['st'])."'"; 
        echo '<h3>'.$this->LANG['compsource']['userlist_st'].' '.$this->LANG['compsource']['userlist_'.$_GET['st']].'</h3>';
    }
    
    if ( array_key_exists('group',$_GET) AND is_numeric($_GET['group']) ){
        $g = $this->_Q->QA("SELECT * FROM <||>user__groups WHERE `id`='".$this->_Q->e($_GET['group'])."'");
        $where.=" AND `groups` LIKE '%;".$this->_Q->e($_GET['group']).";%'"; 
         echo '<h3>'.$this->LANG['compsource']['userlist_group_one'].' '.$g['name'].'</h3>';
    }
    
    
    if ( array_key_exists('q',$_POST) || array_key_exists('q',$_GET) ){
        if(array_key_exists('q',$_POST)) $_GET['q']=$_POST['q'];
        $_GET['q'] = htmlspecialchars_decode($_GET['q']);
        $field=' AND (';
        $QW = $this->_Q->QW("SHOW FIELDS FROM <||>user");
        foreach($QW as $i=>$row){
        	if ($row[0]!='' && $row[0]!='id' && $row[0]!='pass'){
        	   $field.="`".$row[0]."` LIKE '%".$this->_Q->e($_GET['q'])."%' OR ";
        	}
        }
        
       $field.="`id` LIKE '%".$this->_Q->e($_GET['q'])."%')";
       $where.=$field;
        
    }
    
    $limit=limit_parse(30);
    
    ?>    
    
    <form method="post"> <?=$this->_security->creat_key()?>
        <div class="dg_form w95">
            <input type="text" name="q" value="<?=htmlspecialchars($_GET['q'])?>" /><input type="submit" value="<?=$this->LANG['main']['search']?>" />
        </div>
    </form>
    <p>&nbsp;</p>
    <div class="dg_form dg_table dg_list w95">
    
           <div class="dg_tr head">
           <div class="dg_td w5"><strong><a href="<?=_URL_?>reorderinfo&order=admin&re=<?=urlencode($_SERVER["REQUEST_URI"])?>"><?=$this->LANG['compsource']['userlist_admin_sht']?></a></strong><? if ($exorder[0]=='' || $exorder[0]=='admin'){ if ($exorder[1]=='DESC' || $exorder[0]==''){ echo '&darr;'; }else{ echo '&uarr;'; } } ?></div></strong>
            <div class="dg_td w20"><strong><a href="<?=_URL_?>reorderinfo&order=name&re=<?=urlencode($_SERVER["REQUEST_URI"])?>"><?=$this->LANG['compsource']['userlist_name']?></a></strong><? if ($exorder[0]=='name'){ if ($exorder[1]=='DESC'){ echo '&darr;'; }else{ echo '&uarr;'; } } ?></div>
            <div class="dg_td w20"><strong><a href="<?=_URL_?>reorderinfo&order=login&re=<?=urlencode($_SERVER["REQUEST_URI"])?>"><?=$this->LANG['compsource']['userlist_login']?></a></strong><? if ($exorder[0]=='login'){ if ($exorder[1]=='DESC'){ echo '&darr;'; }else{ echo '&uarr;'; } } ?></div>
            <div class="dg_td w20"><strong><a href="<?=_URL_?>reorderinfo&order=mail&re=<?=urlencode($_SERVER["REQUEST_URI"])?>"><?=$this->LANG['compsource']['userlist_mail']?></a></strong><? if ($exorder[0]=='mail'){ if ($exorder[1]=='DESC'){ echo '&darr;'; }else{ echo '&uarr;'; } } ?></div>
            <div class="dg_td w20"><strong><a href="<?=_URL_?>reorderinfo&order=datelast&re=<?=urlencode($_SERVER["REQUEST_URI"])?>"><?=$this->LANG['compsource']['userlist_date']?></a></strong><? if ($exorder[0]=='datelast'){ if ($exorder[1]=='DESC'){ echo '&darr;'; }else{ echo '&uarr;'; } } ?></div>
            <div class="dg_td w15"><strong><a href="<?=_URL_?>reorderinfo&order=iplast&re=<?=urlencode($_SERVER["REQUEST_URI"])?>"><?=$this->LANG['compsource']['userlist_ip']?></a></strong><? if ($exorder[0]=='iplast'){ if ($exorder[1]=='DESC'){ echo '&darr;'; }else{ echo '&uarr;'; } } ?></div>       
            <?
            
            if ($this->_user->_userinfo['admin']==2){?>
            <div class="dg_td w5"><strong><?=$this->LANG['compsource']['userlist_rule']?></strong></div>
            <?}
            
            ?>     
            <div class="dg_td w5">&nbsp;</div>
           </div><?
    
    $QW = $this->_Q->QW("SELECT * FROM <||>user ".$where." ORDER BY ".$order." ".$limit);
    foreach($QW as $i=>$row){
    	if ($row['id']!=''){
    	   ?>
          
           <div class="dg_tr<? if($row['act']!=1){echo ' na';} ?>">
           <div class="dg_td w5"><img src="<?=$ico[$row['admin']]?>" /></div>
            <div class="dg_td w20"><a href="<?=_URL_?>update&id=<?=$row['id']?>"><?=$row['name']?></a></div>
            <div class="dg_td w20"><a href="<?=_URL_?>update&id=<?=$row['id']?>"><?=$row['login']?></a> (id:<?=$row['id']?>)</div>
            <div class="dg_td w20"><?=$row['mail']?></div>
            <div class="dg_td w20"><?= date("d.m.Y (H:i)",$row['datelast']) ?></div>
            <div class="dg_td w10"><?=$row['iplast']?></div>           
            <?
            
            if ($this->_user->_userinfo['admin']==2){?>
            <div class="dg_td w5"><?if($row['admin']==1){
                ?>
            <a href="<?=_URL_?>rule&id=<?=$row['id']?>"><img src="/dg_system/dg_img/icons/computer_key.png" title="<?=$this->LANG['compsource']['userlist_rule']?>" /></a>    
                <?
            }else{ echo '-'; }?></div>
            <?}
            
            ?>    
            <div class="dg_td w5"><? if ($this->_user->_userinfo['id']!=$row['id'] && (($this->_user->_userinfo['admin']!=2 && $row['admin']<2) || $this->_user->_userinfo['admin']==2)){ ?><a href="<?=_URL_?>remove&id=<?=$row['id']?>&re=<?=urlencode($_SERVER["REQUEST_URI"]) ?>" class="removeaccess"><img src="/dg_system/dg_img/icons/cross.png" title="<?=$this->LANG['main']['remove']?>" /></a><?}?></div>
           </div>
           
           <?
    	}
    }
    


    
    ?></div><?
    echo page_parse(30,$this->_Q->QN("SELECT * FROM <||>user ".$where.""));
    
}

if ($this->_func=='update'){//TODO:update
/**
*создаем, редактируем пользователя
*/
if ($this->access('users','update')){    
     if ( array_key_exists('id',$_GET) ){
        
        $inf = $this->_Q->QA("SELECT * FROM <||>user WHERE `id`='".$this->_Q->e($_GET['id'])."'");
    } 
    
    if ($inf['id']=='' OR $this->_user->_userinfo['admin']==2 OR $this->_user->_userinfo['id']==$inf['id'] OR ( $this->_user->_userinfo['admin']==1 AND $inf['admin']!='' AND $inf['admin']<1 )){
   
    
    if ( array_key_exists('go',$_POST) ){
   
        $error='';
        
        if (trim($_POST['name'])==''){ $error.='<li>'.$this->LANG['compsource']['userlist_name_error'].'</li>'; }
        
        if (trim($_POST['login'])==''){ $error.='<li>'.$this->LANG['compsource']['userlist_login_error'].'</li>'; }else{
            if ($_POST['login']!=$inf['login'] && $this->_Q->QN("SELECT `login` FROM <||>user WHERE `login`='".$this->_Q->e($_POST['login'])."'")>0){ $error.='<li>'.$this->LANG['compsource']['userlist_login_error2'].'</li>'; }
        }
        
        if (trim($_POST['mail'])==''){ $error.='<li>'.$this->LANG['compsource']['userlist_mail_error'].'</li>'; }else{
            if ($_POST['mail']!=$inf['mail'] && $this->_Q->QN("SELECT `mail` FROM <||>user WHERE `mail`='".$this->_Q->e($_POST['mail'])."'")>0){ $error.='<li>'.$this->LANG['compsource']['userlist_mail_error2'].'</li>'; }
        } 
        
        if ($inf['id']=='' && strlen(trim($_POST['pass']))<6){$error.='<li>'.$this->LANG['compsource']['userlist_pass_error'].'</li>';}
        if ($inf['id']!='' && trim($_POST['pass'])!='' && strlen(trim($_POST['pass']))<6){$error.='<li>'.$this->LANG['compsource']['userlist_pass_error'].'</li>';}
        
        if ($this->_user->_userinfo['admin']!=2 && $_POST['admin']>0){$error.='<li>'.$this->LANG['compsource']['userlist_admin_error'] .'</li>';}
                    
                    $QW = $this->_Q->QW("SELECT * FROM <||>user__groups");
                    foreach($QW as $i=>$row){
                        if ($row[0]!=''){
                            if ($_POST['group_'.$row['id']]==1){$group[]=$row['id'];}
                        }
                    } 
                      
                      if(is_array($group)){$arr['groups']=';'.implode(';',$group).';'; $inf['groups']=$arr['groups'];}
                      
        if($error==''){
            
            $arr['name']=htmlspecialchars_decode($_POST['name']);
            $arr['login']=htmlspecialchars_decode($_POST['login']);
            $arr['mail']=htmlspecialchars_decode($_POST['mail']);
            if ($this->_user->_userinfo['id']!=$inf['id']){
                    $arr['admin']=htmlspecialchars_decode($_POST['admin']);
                    $arr['act']=htmlspecialchars_decode($_POST['act']);
            }
            if (trim($_POST['pass'])!=''){
                $arr['pass']=md5(htmlspecialchars_decode($_POST['pass']));
            }
            

            
            
           $this->_Q->_table='user';
           $this->_Q->_arr=$arr;
            if($inf['id']==''){
                $this->_Q->QI();
            }else{
                $this->_Q->_where="WHERE `id`=".$inf['id'];
                $this->_Q->QU();
            }   
            
            header("Location:"._URL_."index");     
            
        }else{
            
            foreach($_POST as $i=>$v){
            	$inf[$i]=htmlspecialchars_decode($v);
            }
           
           
            
        }
    
    
    }
    
     //TODO:update_form
    ?>
    
    <h2><? if ($inf['id']==''){echo $this->LANG['compsource']['userlist_add'];}else{ echo $inf['name'].' : '.$this->LANG['compsource']['userlist_edit']; } ?></h2>
    
    <form method="post" autocomplete="off"> <?=$this->_security->creat_key()?>
        <div class="dg_form">
        <?
                if ($error!=''){
            ?>
            <div class="dg_error"><?=$error?></div>

            <?
        }   
        
        ?>
<div class="dg_table w100">
	<div class="dg_tr">
		<div class="dg_td w50">            <p><?=$this->LANG['compsource']['userlist_name']?><br /><input type="text" name="name" value="<?=htmlspecialchars($inf['name']) ?>" /></p>
            <p><?=$this->LANG['compsource']['userlist_login']?><br /><input type="text" name="login" value="<?=htmlspecialchars($inf['login']) ?>" /></p>
            <p><?=$this->LANG['compsource']['userlist_mail']?><br /><input type="text" name="mail" value="<?=htmlspecialchars($inf['mail']) ?>" /></p>
            <p><?=$this->LANG['compsource']['userlist_pass']?><br /><? if ($inf['id']!=''){?><span class="comment"><?=$this->LANG['compsource']['userlist_pass_note']?></span><br /><?} ?><input type="password" name="pass" id="pass" /></p>
            
            
           <?
           
           if ($this->_user->_userinfo['id']!=$inf['id']){
           
           ?> 
            <p><?=$this->LANG['compsource']['userlist_admin']?><br />
                <select name="admin">
                    <? if ($this->_user->_userinfo['admin']==2){ ?><option value="2"<? if($inf['admin']==2){ echo ' selected'; } ?>><?=$this->LANG['compsource']['userlist_2']?></option>
                    <option value="1"<? if($inf['admin']==1){ echo ' selected'; } ?>><?=$this->LANG['compsource']['userlist_1']?></option><?}?>
                    <option value="0"<? if($inf['admin']==0){ echo ' selected'; } ?>><?=$this->LANG['compsource']['userlist_0']?></option>
                    <option value="-1"<? if($inf['admin']==-1){ echo ' selected'; } ?>><?=$this->LANG['compsource']['userlist_-1']?></option>
                </select>
                <label> <input type="checkbox" name="act" value="1" <? if($inf['act']==1){ echo ' checked'; } ?> /> <?=$this->LANG['compsource']['userlist_act']?></label>
            </p>
            <?}?>
            
            
            </div>
		<div class="dg_td w50"> 
            <p><strong><?=$this->LANG['compsource']['userlist_group']?></strong></p>
            <?
        $QW = $this->_Q->QW("SELECT * FROM <||>user__groups");
        foreach($QW as $i=>$row){
            
            if ($row[0]!=''){
         ?>
         
         <p> <label> <input type="checkbox" name="group_<?=$row['id']?>" value="1" <? if ( substr_count($inf['groups'],';'.$row['id'].';')===1 ){ echo ' checked '; } ?> /> <?=$row['name']?></label> </p>
         
         <?       
            }   
            
        }             
            ?>
        </div>
	</div>
</div>
 <p><input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" /></p>
        </div>
       
    </form>
    
    <?
    }else{
        ?>
        <div class="dg_no_access"><?=$this->LANG['main']['no_access']?></div>
        <?
    }
}
}


if ($this->_func=='rule'){//TODO:rule

  if ($this->_user->_userinfo['admin']==2){  
    $inf = $this->_Q->QA("SELECT * FROM <||>user WHERE `id`='".$this->_Q->e($_GET['id'])."'");
    
    if ($inf['admin']==1 && $inf['id']!=''){
        
        if ( array_key_exists('go',$_POST) ){
            
            $this->_Q->_table="moders";
            
            $QW = $this->_Q->QW("SELECT * FROM <||>moders");
            foreach($QW as $i=>$row){
            	if ($row[0]!==''){
            	   
                   if ($_POST['a_'.$row['id']]==1){
                    
                    if (substr_count($row['moders'],'{'.$inf['id'].'}')==0){ $this->_Q->_arr=array('moders'=>$row['moders'].'{'.$inf['id'].'}'); }
                    
                   }else{
                        $this->_Q->_arr=array('moders'=>str_replace('{'.$inf['id'].'}','',$row['moders']));
                   }
                   $this->_Q->_where=" WHERE `id`=".$row['id'];
                   $this->_Q->QU();
                   
            	}
            }       
            
            header("Location:"._URL_.'rule&id='.$inf['id']);
             
        }
        
        ?><h2><?=$inf['name']?> : <?=$this->LANG['compsource']['userlist_rule']?></h2>
        
        <form method="post"> <?=$this->_security->creat_key()?>
            <div class="dg_form">
        <?
        
            $QW = $this->_Q->QW("SELECT * FROM <||>moders");
            foreach($QW as $i=>$row){
            	if ($row[0]!==''){
            	   ?>
                   
                   <p><label><input type="checkbox" name="a_<?=$row['id']?>" value="1"  class="gaccess" <? if ( substr_count($row['moders'],'{'.$inf['id'].'}')===1 ){ echo ' checked '; } ?> /> <?=$this->LANG[$row['comp']][$row['func']]?></label></p>
                   
                   <?
            	}
            }
        
        ?>
         <p><input type="submit" name="go" value="<?=$this->LANG['main']['save']?>" /></p>
            </div>
        </form>
        
        <?

        
    }else{
        echo $this->LANG['compsource']['userlist_rule_nomoder'];
    }
    
    
  }else{
         ?>
        <div class="dg_no_access"><?=$this->LANG['main']['no_access']?></div>
        <?    
  }
}

if ($this->_func=='remove'){//TODO:remove
/**
*удаляем пользователя
*/
 if ($this->access('users','update') && $this->access('users','remove')){
     $inf = $this->_Q->QA("SELECT * FROM <||>user WHERE `id`='".$this->_Q->e($_GET['id'])."'");
     if ($inf['id']!='' && $this->_user->_userinfo['id']!=$inf['id'] && (($this->_user->_userinfo['admin']!=2 && $inf['admin']<2) || $this->_user->_userinfo['admin']==2)){
        
        
        echo '<h2>'.$inf['name'].' : '.$this->LANG['compsource']['userlist_remove'] .'</h2>';
        if($this->accesspassword()){
                $this->_Q->_table='user';
                $this->_Q->_where="WHERE `id`=".$inf['id'];
                $this->_Q->QD();     
                header("Location:"._URL_.'index');               
        }
        
     }else{
        ?>
        <div class="dg_no_access"><?=$this->LANG['main']['no_access']?></div>
        <?       
     }
   }
}

if ($this->_func=='groups'){//TODO:groups
if ($this->access('users','groups')){
/**
*список групп
*/
    
    ?>
    <h2><?=$this->LANG['compsource']['userlist_group']?></h2>
    
    <div class="dg_table w95 dg_list ">
    	<div class="dg_tr">
    		<div class="dg_td w60"><?=$this->LANG['compsource']['userlist_group_name']?></div>
    		<div class="dg_td w35"><?=$this->LANG['compsource']['userlistname']?></div>
            <div class="dg_td w5">&nbsp;</div>
    	</div>
        <?
        
        $QW = $this->_Q->QW("SELECT * FROM <||>user__groups");
        foreach($QW as $i=>$row){
            
            if ($row[0]!=''){
             ?>
             
    	<div class="dg_tr">
    		<div class="dg_td w60"><a href="<?=_URL_?>group_update&id=<?=$row['id']?>"><?=$row['name']?></a></div>
    		<div class="dg_td w35"><a href="<?=_URL_?>index&group=<?=$row['id']?>"><?=$this->_Q->QN("SELECT `groups` FROM <||>user WHERE `groups` LIKE '%;".$row['id'].";%'")?></a></div>
            <div class="dg_td w5"><a href="<?=_URL_?>group_remove&id=<?=$row['id']?>&re=<?=urlencode($_SERVER["REQUEST_URI"])?>" class="removeaccess"><img src="/dg_system/dg_img/icons/cross.png" title="<?=$this->LANG['main']['remove']?>" /></a></div>
    	</div>
             
             <?   
            }
        	
        }
        ?>
    </div>

    
    <?
    }
}

if ($this->_func=='group_update'){//TODO:group_update
/**
*создаем, редактируем группу
*/
if ($this->access('users','groups')){
    if ( array_key_exists('id',$_GET) ){
        
        $inf = $this->_Q->QA("SELECT * FROM <||>user__groups WHERE `id`='".$this->_Q->e($_GET['id'])."'");
    }
    
    if ( array_key_exists('add',$_POST) ){
        
        $error='';
        if (trim($_POST['name'])==''){ $error.='<li>'.$this->LANG['compsource']['userlist_group_error1'].'</li>'; }else{
            if ($inf['name']!=$_POST['name'] && $this->_Q->QN("SELECT * FROM <||>user__groups WHERE `name`='".$this->_Q->e($_POST['name'])."'")>0 ){
                $error.='<li>'.$this->LANG['compsource']['userlist_group_error2'].'</li>';
            }
        }
        
        if ($error==''){
            
            $this->_Q->_arr=array('name'=>htmlspecialchars_decode($_POST['name']));
            $this->_Q->_table='user__groups';
            if ($inf['id']==''){
                $this->_Q->QI();
            }else{
                $this->_Q->_where="WHERE `id`=".$inf['id'];
                $this->_Q->QU();
            }
            
            header("Location:"._URL_.'groups');
        }
        
    }
    
    ?>
<h2><? if ($inf['id']==''){ echo $this->LANG['compsource']['userlist_group_add']; }else{ echo $this->LANG['compsource']['userlist_group_edit']; } ?></h2>
<form method="post"> <?=$this->_security->creat_key()?>
    <div class="dg_form w95">

        <p><?=$this->LANG['compsource']['userlist_group_name']?><br />
            <?
        if ($error!=''){
            ?>
            <div class="dg_error"><?=$error?></div>
            <p>&nbsp;</p>
            <?
        }    
    ?>
    
    <input type="text" name="name" value="<?=htmlspecialchars($inf['name'])?>" />
    <input type="submit" name="add" value="<?=$this->LANG['main']['next']?>" /></p>
    </div>
</form>
    
    <?
    }
}

if ($this->_func=='group_remove'){//TODO:group_remove
    /**
    *удаляем группу
    */
    if ($this->access('users','groups')){
     $inf = $this->_Q->QA("SELECT * FROM <||>user__groups WHERE `id`='".$this->_Q->e($_GET['id'])."'");
     if ($inf['id']!=''){
        ?>
        <h2><?=$inf['name']?> : <?=$this->LANG['compsource']['userlist_group_remove']?></h2>
        <?
        
        if ($this->accesspassword()){
                $this->_Q->_table='user__groups';
                $this->_Q->_where="WHERE `id`=".$inf['id'];
                $this->_Q->QD();     
                header("Location:"._URL_.'groups');       
        }
        
     }
     }
}


if ($this->_func=='index' || $this->_func=='update' || $this->_func=='remove' || $this->_func=='rule'){

    $this->_right='
    <h2>'.$this->LANG['compsource']['userlistname'].'</h2>
    <li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'update">'.$this->LANG['compsource']['userlist_add'].'</a></li>
    <div class="r"></div>
    <li style="background:url(/dg_system/dg_img/icons/text_list_numbers.png) no-repeat left center;"><a href="'._URL_.'index">'.$this->LANG['compsource']['userlist_all'].'</a></li>
    <li style="background:url('.$ico[2].') no-repeat left center;"><a href="'._URL_.'index&st=2">'.$this->LANG['compsource']['userlist_2'].'</a></li>
    <li style="background:url('.$ico[1].') no-repeat left center;"><a href="'._URL_.'index&st=1">'.$this->LANG['compsource']['userlist_1'].'</a></li>
    <li style="background:url('.$ico[0].') no-repeat left center;"><a href="'._URL_.'index&st=0">'.$this->LANG['compsource']['userlist_0'].'</a></li>
    <li style="background:url('.$ico[-1].') no-repeat left center;"><a href="'._URL_.'index&st=-1">'.$this->LANG['compsource']['userlist_-1'].'</a></li>
    <div class="r"></div>
    <li style="background:url(/dg_system/dg_img/icons/user_group.png) no-repeat left center;"><a href="'._URL_.'groups">'.$this->LANG['compsource']['userlist_group'].'</a></li>
    
';
}
//TODO:right

if ($this->_func=='groups' || $this->_func=='group_update'|| $this->_func=='group_remove'){

    $this->_right='
    <h2>'.$this->LANG['compsource']['userlist_group'].'</h2>
    <li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'group_update">'.$this->LANG['compsource']['userlist_group_add'].'</a></li>
    <li style="background:url(/dg_system/dg_img/icons/user_group.png) no-repeat left center;"><a href="'._URL_.'groups">'.$this->LANG['compsource']['userlist_group'].'</a></li>    
    <div class="r"></div>
    <li style="background:url('.$ico[0].') no-repeat left center;"><a href="'._URL_.'index">'.$this->LANG['compsource']['userlistname'].'</a></li>

    
';
}
}
?>