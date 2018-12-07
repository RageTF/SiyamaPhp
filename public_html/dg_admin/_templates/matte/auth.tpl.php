<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>demiurgo.cms</title>
<link charset="utf-8" rel="stylesheet" href="/dg_system/dg_css/dg.css" />
<link charset="utf-8" rel="stylesheet" href="_templates/<?=$this->_tpl?>/css/main.css" />
</head>
<body>
    <div id="authform" class="dg_form">
      <form method="post">  <?=$this->_security->creat_key()?>
        <div class="dg_table w100">
            <div class="dg_tr">
                <div class="dg_td w50"><?=$this->LANG['auth']['login']?></div>
                <div class="dg_td w50"><input type="text" name="login" /></div>    
            </div>
            <div class="dg_tr">
                <div class="dg_td w50"><?=$this->LANG['auth']['pass']?></div>
                <div class="dg_td w50"><input type="password" name="pass" /></div>    
            </div>
            <div class="dg_tr">
                <div class="dg_td w50"> <label> <input type="checkbox" name="maxtime" value="1" /> <?=$this->LANG['auth']['memme']?></label> </div>
                <div class="dg_td w50"> <input type="submit" name="auth" value="<?=$this->LANG['auth']['enter']?>" /> </div>    
            </div>
        </div>
        <input type="hidden" value="<?=$_SERVER["REQUEST_URI"]?>" name="req" />
       </form> 
    </div>
</body>
</html>