<?
$im = '';
$GLOBALS['_OG'] = array('title'=>$this->_app->_infoPAGE['name'].' '.$row['name'],'des'=>$row['des'],'url'=>'http://'.$_SERVER['HTTP_HOST'].$url);


$this->_app->_title = htmlspecialchars($this->_app->_infoPAGE['name'].' '.$row['name']);

?><div id="o_<?=$row["id"]?>" class="cat" itemscope itemtype="http://schema.org/Product">

    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td id="400" valign="top"><?
                if ($row['img']!='') {echo '<img itemprop="image" src="'.img(array('src'=>$row['img'],'w'=>400,'h'=>'auto','bg'=>'000000','wm'=>_TPL_.'/img/w.png')).'" class="i" />';
                
                $im = ' data-image="http://'.$_SERVER['HTTP_HOST'] . img(array('src'=>$row['img'],'w'=>600,'h'=>'auto','bg'=>'000000','wm'=>_TPL_.'/img/w.png')) .'" ';
                $GLOBALS['_OG']['image'] = 'http://'.$_SERVER['HTTP_HOST'] . img(array('src'=>$row['img'],'w'=>600,'h'=>'auto','bg'=>'000000','wm'=>_TPL_.'/img/w.png')) ;
                }
            ?></td>
            <td   valign="top"> 
            <div style="padding-left: 20px;">
                <h2 itemprop="name"><?=$row['name']?></h2>
                <?
                    if (!$this->_app->_ajax){
                ?>
                <p>&larr; <a href="<?=$p[$page]["url"]?>"><?=$p[$page]["name"]?></a></p>
                <?}?>
                
                 <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="//yastatic.net/share2/share.js"></script>
<div class="ya-share2" <?=$im?> data-url="http://<?=$_SERVER['HTTP_HOST'].$url?>" data-title="<?= htmlspecialchars($this->_app->_infoPAGE['name'].' '.$row['name'])?>" data-services="collections,vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,lj,viber,whatsapp,skype,telegram"></div>
                
                
                <p class="des" itemprop="description"><?=$row['des']?></p>
                
                <div id="ONEORDER">
                
                <p  itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <meta itemprop="price" content="<?=$row['price1']?>">
                <meta itemprop="priceCurrency" content="RUB">
                <?=($row['total1']!='')?$row['total1'].'<br />':''?><span class="price"><?=$GLOBALS['dgshop']->price($row['price1'])?>тг.</span> <span class="inshp"><?=$GLOBALS['dgshop']->add_in_shop($row['id'],$row['name'].' / '.$row['total1'],$row['price1'],$url,$row['des'],$row['img1'],'&nbsp;')?></span></p>
                 
                
                <?
                 	 
                if ($row['price2']>0){
                    ?>
                    <p  itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <meta itemprop="price" content="<?=$row['price2']?>">
                <meta itemprop="priceCurrency" content="RUB">
                    <?=($row['total2']!='')?$row['total2'].'<br />':''?><span class="price"><?=$GLOBALS['dgshop']->price($row['price2'])?>тг.</span> <span class="inshp"><?=$GLOBALS['dgshop']->add_in_shop($row['id'],$row['name'].' / '.$row['total2'],$row['price2'],$url,$row['des'],$row['img1'],'&nbsp;')?></span></p>
                    <?
                }
                ?>
                </div>
                
                <?
                    if ($this->_app->_ajax){
                        ?>
                        <p><a class="bbtn" href="#" onclick="return closeAJ();">Закрыть</a></p>
                        <?
                    }
                ?>
               
                </div>
            </td>
        </tr>
    </table>
</div>