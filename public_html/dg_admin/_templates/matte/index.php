<? defined("_DG_") or die ("ERR");	 ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>demiurgo.cms v.<?=$this->ver?> <?=$this->subver?></title>

<?=$this->head()?>
<style type="text/css">
ul.sub_navig li a[href='?comp=<?=$_GET['comp']?>&use=<?=$_GET['use']?>']{color:#000000; text-decoration:none;}
</style>
</head>
<body>
<div id="savemess"><?=$this->LANG['main']['savemess']?></div>
<div id="wrapper">
    <header> 
          <? include_once _DR_.'/dg_admin/_templates/'.$this->_tpl.'/menu.php'; ?>
    </header><!-- #header-->
    
        <section id="content">
        
        		<div class="dg_table">
                 <div class="dg_tr">
                  <div class="dg_td left">
                   <div class="content" id="incontent"><? $this->content(); ?></div>
                  </div>
                 <aside class="dg_td right">
        		  <div class="sn"><?=$this->_right?></div>
        		 </aside>        
                </div>
               </div>
    
    </section>
</div>
<iframe src="about:blank"  name="inframe" style="display:none;"></iframe>
</body>
</html>