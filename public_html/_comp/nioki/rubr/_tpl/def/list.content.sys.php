<li<? if ($row['link']==$this->_app->_PAGE->url($this->_app->_infoPAGE['id'])) echo ' class="act"'; ?>><strong><a href="<?=$row['link']?>"><?=$row['name']?></a></strong><a href="<?=$row['link']?>"><img src="<?=img(array('src'=>$row['img'],'w'=>100,'h'=>100,'bg'=>'000000'))?>" alt="<?=$row['name']?>" width="100" height="100" /></a></li>