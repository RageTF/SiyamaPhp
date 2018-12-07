<?php

/**
 * @author mrhard
 * @copyright 2010
 */

if ($this->access('settings','access')){
define(_URL_,'/dg_admin/?comp=system&use=setting&func=');

?>

<h3><?=$this->LANG['compsource']['settings_plugins']?></h3>
<script>
    $(document).ready(function()	{
    	$("#settingcase form").ajaxForm(function(data) { 
	               
                   showsave(true);
                 
            	}); 
    				})
</script>
<div id="settingcase">
<form method="post">  <?=$this->_security->creat_key()?>
    <div class="dg_form">
    
    <?
    
    $dir = opendir (_DR_.'/dg_lib/dg_plugins/');
      while ( $file = readdir ($dir))
      {
        if (( $file != ".") && ($file != "..") && is_dir(_DR_.'/dg_lib/dg_plugins/'.$file) && $file!='.svn')
        {
          
           if ( array_key_exists('saveplugin',$_POST)){
           	$this->_regedit->edit('dg_plugin_'.$file,strip_tags($_POST['plugin_'.$file]));
           }
          
          ?>
          
          <p><strong><?=$file?></strong>: <select name="plugin_<?=$file?>">
          
<?


                $dir2 = opendir (_DR_.'/dg_lib/dg_plugins/'.$file);
                  while ( $file2 = readdir ($dir2))
                  {
                    if (( $file2 != ".") && ($file2 != "..") && _DR_.'/dg_lib/dg_plugins/'.$file.'/'.$file2 && $file2!='.svn')
                    {
                        $sel='';
                        if($this->_regedit->read('dg_plugin_'.$file)==$file2){ $sel=' selected '; }
                      echo '<option value="'.$file2.'"'.$sel.'>'.$file2.'</option>';
                    }
                  }
                  closedir ($dir2);

?>
          </select></p>
          
          <?
         
          
          
        }
      }
      closedir ($dir);
     if ( array_key_exists('saveplugin',$_POST)){
            header("Location:"._URL_.'index&c='.rand());
          }
    
    ?>
    <p><input type="submit" name="saveplugin" value="<?=$this->LANG['main']['save']?>" /></p>
    </div>
</form>
<h3><?=$this->LANG['compsource']['settings_design']?></h3>
<form method="post">  <?=$this->_security->creat_key()?>
    <div class="dg_form">
    <?
    
     if ( array_key_exists('savedesign',$_POST)){
          $this->_regedit->edit('use.jquery',strip_tags($_POST['usejquery']));
          $this->_regedit->edit('jQuery.link',strip_tags($_POST['jQuerylink']));
          $this->_regedit->edit('use.dgcss',strip_tags($_POST['usedgcss']));
          $this->_regedit->edit('TPLcachehead',strip_tags($_POST['TPLcachehead']));
    }?>    
    <p> <label> <input type="checkbox" name="usejquery" value="yes" <? if ($this->_regedit->read('use.jquery','yes')=='yes'){ echo 'checked'; } ?> /> <?=$this->LANG['compsource']['settings_design_use.jquery']?></label> </p>
    <p><?=$this->LANG['compsource']['settings_design_jQuery.link']?><br /><input type="text" name="jQuerylink" class="w90" value="<?=$this->_regedit->read("jQuery.link",_JQ_LINK_)?>" /></p>
    <p> <label> <input type="checkbox" name="usedgcss" value="yes" <? if ($this->_regedit->read('use.dgcss','yes')=='yes'){ echo 'checked'; } ?> /> <?=$this->LANG['compsource']['settings_design_use.dgcss']?></label> </p>
    <p><?=$this->LANG['compsource']['settings_design_headcache']?> <input type="number" size="5" name="TPLcachehead" value="<?=$this->_regedit->read('TPLcachehead',3600)?>" /> ms</p>
    <p><input type="submit" name="savedesign" value="<?=$this->LANG['main']['save']?>" /></p>
    </div>
    <?
    
     if ( array_key_exists('savedesign',$_POST)){
         $fc = new dg_file;
         $fc->clearcache();
            header("Location:"._URL_.'index&c='.rand());
    }?>
</form>
<h3><?=$this->LANG['compsource']['settings_sourceinfo']?></h3>
<form method="post">  <?=$this->_security->creat_key()?>
    <div class="dg_form">
    <?
    
     if ( array_key_exists('savesourceinfo',$_POST)){
        
          $n='title'; $this->_regedit->edit('seo.'.$n,strip_tags( htmlspecialchars_decode($_POST[$n]) ));
          $n='kw'; $this->_regedit->edit('seo.'.$n,strip_tags( htmlspecialchars_decode($_POST[$n]) ));
          $n='des'; $this->_regedit->edit('seo.'.$n,strip_tags( htmlspecialchars_decode($_POST[$n]) ));
          $n='shortcut_icon'; $this->_regedit->edit('seo.'.$n,strip_tags( htmlspecialchars_decode($_POST[$n]) ));
          $n='a'; $this->_regedit->edit('seo.'.$n,strip_tags( htmlspecialchars_decode($_POST[$n]) ));

    }?>      
    <?$n='title';?><p><?=$this->LANG['compsource']['settings_sourceinfo_'.$n]?><br /><input type="text" name="<?=$n?>" class="w90" value="<?=htmlspecialchars($this->_regedit->read('seo.'.$n,''))?>" /></p>
    <?$n='kw';?><p><?=$this->LANG['compsource']['settings_sourceinfo_'.$n]?><br /><input type="text" name="<?=$n?>" class="w90" value="<?=htmlspecialchars($this->_regedit->read('seo.'.$n,''))?>" /></p>
    <?$n='des';?><p><?=$this->LANG['compsource']['settings_sourceinfo_'.$n]?><br /><input type="text" name="<?=$n?>" class="w90" value="<?=htmlspecialchars($this->_regedit->read('seo.'.$n,''))?>" /></p>
    <?$n='shortcut_icon';?><p><?=$this->LANG['compsource']['settings_sourceinfo_'.$n]?><br /><input type="text" name="<?=$n?>" class="w90" value="<?=htmlspecialchars($this->_regedit->read('seo.'.$n,''))?>" /></p>
    <?$n='a';?><p><?=$this->LANG['compsource']['settings_sourceinfo_'.$n]?><br /><input type="text" name="<?=$n?>" class="w90" value="<?=htmlspecialchars($this->_regedit->read('seo.'.$n,''))?>" /></p>
    
    <p><input type="submit" name="savesourceinfo" value="<?=$this->LANG['main']['save']?>" /></p>
    </div>
<?
    
     if ( array_key_exists('savesourceinfo',$_POST)){
         $fc = new dg_file;
         $fc->clearcache();
            header("Location:"._URL_.'index&c='.rand());
    }?>
</form>    
<h3><?=$this->LANG['compsource']['settings_other']?></h3>
<form method="post">  <?=$this->_security->creat_key()?>
    <div class="dg_form">
    <?
    
    
    $dir = opendir (_DR_.'/dg_system/dg_setting/');
      while ( $file = readdir ($dir))
      {
        if (( $file != ".") && ($file != "..") && is_file(_DR_.'/dg_system/dg_setting/'.$file))
        {
          if ( file_exists(_DR_.'/dg_system/dg_setting/_lang/'.$this->LANGLOAD->_def.'/'.$file) ) include_once _DR_.'/dg_system/dg_setting/_lang/'.$this->LANGLOAD->_def.'/'.$file;  
          include_once _DR_.'/dg_system/dg_setting/'.$file;
        }
      }
      closedir ($dir);
    
    
    
    ?>
    <p><input type="submit" name="saveother" value="<?=$this->LANG['main']['save']?>" /></p></div>
    <?
    
     if ( array_key_exists('saveother',$_POST)){
         $fc = new dg_file;
         $fc->clearcache();
         header("Location:"._URL_.'index&c='.rand());
    }?>
</form>
<?

}

?>
</div>