<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */



?>
<nav> 
        <ul>
           <li<? if(($_GET['comp']=='source' && $_GET['use']=='pages') || ($_GET['comp']=='' && $_GET['use']=='')){ echo ' class="act "'; } ?> title="ctrl + alt + p"><img src="/dg_system/dg_img/icons/chart_organisation.png"/><a href="?comp=source&use=pages"><?=$this->LANG['compsource']['pagesname']?></a></li>
           <li<? if($_GET['comp']=='source' && $_GET['use']=='filemanager'){ echo ' class="act "'; } ?> title="ctrl + alt + f"><img src="/dg_system/dg_img/icons/folder.png"  /><a href="?comp=source&use=filemanager"><?=$this->LANG['compsource']['filemanagername']?></a></li>
           <li<? if($_GET['comp']=='source' && $_GET['use']=='users'){ echo ' class="act "'; } ?> title="ctrl + alt + u"><img src="/dg_system/dg_img/icons/user.png" /><a href="?comp=source&use=users"><?=$this->LANG['compsource']['userlistname']?></a></li>
           <li<? if($_GET['comp']=='design' && $_GET['use']=='templates'){ echo ' class="act "'; } ?>  title="ctrl + alt + t"><img src="/dg_system/dg_img/icons/palette.png" /><a href="?comp=design&use=templates"><?=$this->LANG['compdesign']['designname']?></a></li>
           <li<? if($_GET['comp']=='design' && $_GET['use']=='blockmodules'){ echo ' class="act "'; } ?>  title="ctrl + alt + m"><img src="/dg_system/dg_img/icons/layout.png" /><a href="?comp=design&use=blockmodules"><?=$this->LANG['compdesign']['blockmodulesname']?></a></li>
           <li<? if($_GET['comp']=='system' && $_GET['use']=='configurationcomponent'){ echo ' class="act "'; } ?> title="ctrl + alt + c"><img src="/dg_system/dg_img/icons/color_swatch_2.png" /><a href="?comp=system&use=configurationcomponent"><?=$this->LANG['compsystem']['configurationcomponentname']?></a></li>
           <li<? if($_GET['comp']=='system' && $_GET['use']=='setting'){ echo ' class="act "'; } ?> title="ctrl + alt + s"><img src="/dg_system/dg_img/icons/hammer.png" /><a href="?comp=system&use=setting"><?=$this->LANG['compsource']['settingsname']?></a></li>
           <li id="logout"><a href="?logout"><img src="/dg_system/dg_img/icons/door_out.png" /></a></li>
        </ul>
</nav>         