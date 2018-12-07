<?

$GLOBALS['AAAA']++;

if (!$this->_app->_mobile){
    ?><div class="cat">
    <h2><a class="AJ" href="<?=$url?>"><?=$row['name']?></a></h2>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td width="125" valign="top"><span class="h_v"><?
            
            if ($row['hot']==1) echo '<img src="/files/nioki/img/hot.png" title="Острое блюдо" />';
            if ($row['veg']==1) echo '<img src="/files/nioki/img/veg.png" title="Вегетарианское блюдо" />';
            
            ?></span><?
                if ($row['img']!='') echo '<a href="'.$url.'" class="AJ"><img src="'.img(array('src'=>$row['img'],'w'=>120,'h'=>119,'bg'=>'000000')).'" class="i" /></a>';
            ?></td>
            <td valign="top">
                
                <?
                 
                if ($row['price1']>0){
                    ?>
                    <p style="padding-left: 10px;"><?=$row['total1']?> <span class="price"><?=$GLOBALS['dgshop']->price($row['price1'])?>тг.</span> <span class="inshp"><?=$GLOBALS['dgshop']->add_in_shop($row['id'],$this->_app->_infoPAGE['name']. ' / ' . $row['name'].' / '.$row['total1'],$row['price1'],$_SERVER["REQUEST_URI"],$row['des'],$row['img1'],'&nbsp;')?></span></p>
                    <?
                }
                
                 
                if ($row['price2']>0){
                    ?>
                    <p style="padding-left: 10px;"><?=$row['total2']?> <span class="price"><?=$GLOBALS['dgshop']->price($row['price2'])?>тг.</span> <span class="inshp"><?=$GLOBALS['dgshop']->add_in_shop($row['id'],$this->_app->_infoPAGE['name']. ' / ' . $row['name'].' / '.$row['total2'],$row['price2'],$_SERVER["REQUEST_URI"],$row['des'],$row['img1'],'&nbsp;')?></span></p>
                    <?
                }
                ?>
                <div class="des"><?=$row['des']?></div>
            </td>
        </tr>
    </table>
</div><?
}else{
    ?>
    <div class="cat">
    <h2><a class="AJ" href="<?=$url?>"><?=$row['name']?></a></h2>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td width="125" valign="top"><span class="h_v"><?
            
            if ($row['hot']==1) echo '<img src="/files/nioki/img/hot.png" title="Острое блюдо" />';
            if ($row['veg']==1) echo '<img src="/files/nioki/img/veg.png" title="Вегетарианское блюдо" />';
            
            ?></span><?
                if ($row['img']!='') echo '<a href="'.$url.'" class="AJ"><img src="'.img(array('src'=>$row['img'],'w'=>120,'h'=>119,'bg'=>'000000')).'" class="i" /></a>';
            ?></td>
            <td valign="top">
                <?
                 
                if ($row['price1']>0){
                    ?>
                    <p style="padding-left: 10px;"><span class="inshp"><?=$GLOBALS['dgshop']->add_in_shop_mini($row['id'],$this->_app->_infoPAGE['name']. ' / ' . $row['name'].' / '.$row['total1'],$row['price1'],$_SERVER["REQUEST_URI"],$row['des'],$row['img1'],$row['total1'].' <span class="price">'.$GLOBALS['dgshop']->price($row['price1']).'тг.</span>')?></span></p>
                    <?
                }
                
                 
                if ($row['price2']>0){
                    ?>
                    <p style="padding-left: 10px;"><span class="inshp"><?=$GLOBALS['dgshop']->add_in_shop_mini($row['id'],$this->_app->_infoPAGE['name']. ' / ' . $row['name'].' / '.$row['total2'],$row['price2'],$_SERVER["REQUEST_URI"],$row['des'],$row['img1'],$row['total2'].' <span class="price">'.$GLOBALS['dgshop']->price($row['price2']).'тг.</span>')?></span></p>
                    <?
                }
                ?>
                <div class="des"><?=$row['des']?></div>
            </td>
        </tr>
    </table>
</div>
    <?
}
?>