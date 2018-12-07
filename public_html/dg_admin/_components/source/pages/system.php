<?php

/**
 * @author mrhard
 * @copyright 2010
 */

 define("_COMP_DIR_",_DR_.'/dg_lib/dg_components/'.$comp[1].'/'); 
 define("_COMP_URL_",_URL_.'source&use=pages&func=editpage&id='.$inf['id'].'&act='); 

define("_LDIR_",_COMP_DIR_.'_langs/'.$this->LANGLOAD->_def); 

if (file_exists(_LDIR_)){
    if (is_dir(_LDIR_)){
    $dir = opendir (_LDIR_);
      while ( $file = readdir ($dir))
      {
        if (( $file != ".") && ($file != "..") && (is_file(_LDIR_.'/'.$file)))
        {
          include _LDIR_.'/'.$file;
        }
      }
      closedir ($dir);
    }
}
 if ( file_exists(_COMP_DIR_.'admin.php') ){
    
    include _COMP_DIR_.'admin.php';
                $this->_right.='    <li style="background:url(/dg_system/dg_img/icons/application_go.png) no-repeat left center;"><a href="'. $p->_pages[$inf['id']]['url'] .'" target="_blank">'.$this->LANG['compsource']['title_pages_go'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/hammer.png) no-repeat left center;"><a href="'._URL_.'update&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_setting_page'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/cross.png) no-repeat left center;"><a href="'._URL_.'remove&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_remove'].'</a></li>
                    <div class="r"></div>';    
 } 

?>