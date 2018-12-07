            <div class="dg_news_list_content" id="<?=$this->_css_id_key?>_<?=$row['id']?>">
                <h3 class="dg_news_title"><? if (trim(strip_tags($row['text']))!='') echo '<a href="'. $row['object_url'] .'" class="dg_news_title_link">'; ?><?=$row['title']?><? if (trim(strip_tags($row['text']))!='') echo '</a>'; ?></h3>
                <time class="dg_news_date" data-time="<?=$row['_timestamp']?>"><?=$row['date']?></time>
                <?
                    if ($this->_show_mainimg){
                        
                        ?><?=$row['image']['html']?>

<?
                    }
                ?>
                <? if ($this->_show_anons){
                    
                    ?><div class="dg_news_anons"><?=$row['anons']?></div>

<?
                    
                }?>
                <div class="clear"></div>
            </div>
