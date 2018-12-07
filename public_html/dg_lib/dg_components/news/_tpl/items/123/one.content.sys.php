            <div class="dg_news_one_content" id="<?=$this->_css_id_key?>_<?=$row['id']?>">
                <h2 class="dg_news_title"><?=$row['title']?></h2>
                <time class="dg_news_date" data-time="<?=$row['_timestamp']?>"><?=$row['date']?></time>
<?if ($this->_show_mainimg && $this->_show_mainimg_on_one){
                        
                        ?>                <?=$row['image']['html']?>

<?
                    }?>
<?
                
                    if ($this->_show_anons && $this->_show_anons_on_one){
                        ?>                <div class="dg_news_anons"><?=$row['anons']?></div>

<?
                    }
                
                ?>
                <div class="dg_news_text"><?=$row['text']?></div>
                <div class="clear"></div>
            </div>
