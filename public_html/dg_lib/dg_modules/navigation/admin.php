<?php

/**
 * @author mrhard
 * @copyright 2010
 */

defined("ADMIN") or die ("ERR");


 if ( array_key_exists('go',$_POST) ){
 	if (trim($_POST['p1'])=='') $_POST['p1']=0;
    $this->_Q->_table="mods";
    $this->_Q->_arr = array('param'=>$_POST['p0'].';'.$_POST['p1'].';'.htmlspecialchars_decode($_POST['p2']));
    $this->_Q->_where="WHERE `id`=".$inf['id'];
    $this->_Q->QU();
    header("Location:"._URL_.'index');
 }

$param = explode(';',$inf['param']);


    $QW = $this->_Q->QW("SELECT * FROM `<||>pages` ORDER BY `order`");
    foreach ($QW as $i=>$row){
        
        $p = $row['parent'];
        $pages[$p][$m] = $row;
        $m++;
        
    }
    function mod_nav_pagetree($sel,$pages,$parent=0,$gl=1,$url='/'){
        $y=0;

        if (is_array($pages[$parent])){
            foreach($pages[$parent] as $i=>$row){
              $row['menu'] = ($row['menu'] != "") ? $row['menu'] : $row['name'];
                $s=''; if ($row['id']==$sel){
                     $s=' selected '; 
                }        
                echo '<option value="'.$row['id'].'"'.$s.'>'.str_repeat("&nbsp;&nbsp;",$gl).$row['menu'].'</option>';
                   
                if (array_key_exists($row['id'],$pages)){
                    mod_nav_pagetree($sel,$pages,$row['id'],($gl+1),$url);
                }

            }

        }
    }

?>
<form method="post">    <?=$this->_security->creat_key()?>
    <div class="dg_form">
        <p><?=$this->LANG['mod_navigation']['parent']?><br />
        <select name="p0">
         <option value="0"><?=$this->LANG['mod_navigation']['root']?></option>
        <?=mod_nav_pagetree($param[0],$pages)?>
         <option value="-1"<?if($param[0]==-1){ echo' selected '; }?>><?=$this->LANG['mod_navigation']['this']?></option>
        </select></p>
        <p><?=$this->LANG['mod_navigation']['m']?><br /><input name="p1" type="number" size="5" value="<?=htmlspecialchars($param[1])?>" required /></p>
        <p><?=$this->LANG['mod_navigation']['class']?><br /><input name="p2" type="text" size="10" value="<?=htmlspecialchars($param[2])?>" /><br /></p>
        <p><input type="submit" name="go" value="<?=$this->LANG['main']['save']?>" /></p>
    </div>
</form>