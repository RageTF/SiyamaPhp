<?php

/**
 * @author mrhard
 * @copyright 2010
 */
defined("CONTENT") or die ("ERR");

    $dg_news = new dg_news($this);
    $dg_news->_page_id = $this->_infoPAGE['id'];
    $dg_news->_format_date = $this->_regedit->read('dg_news_datetimeformat_'.$this->_infoPAGE['id'],0);
    $dg_news->_maxobjectonpage = $this->_infoPAGE['max'];
    $dg_news->_show_anons = ($this->_regedit->read('dg_news_showanons_'.$this->_infoPAGE['id'],1)==1)?true:false;
    $dg_news->_show_anons_on_one = ($this->_regedit->read('dg_news_showanons_on_news_'.$this->_infoPAGE['id'],1)==1)?true:false;
    $dg_news->_showonlylist = false;
    $dg_news->_strurl =  ($this->_regedit->read('dg_news_stringurl_'.$this->_infoPAGE['id'],1)==1)?true:false;
    $dg_news->_tpl = $this->_regedit->read('dg_news_listtpl_'.$this->_infoPAGE['id'],'default');
    $dg_news->_show_mainimg = ($this->_regedit->read('dg_news_showmainimg_'.$this->_infoPAGE['id'],1))?true:false;
    $dg_news->_show_mainimg_on_one = ($this->_regedit->read('dg_news_showmainimg_on_news_'.$this->_infoPAGE['id'],1))?true:false;
    $dg_news->_main_img_w = $this->_regedit->read('dg_news_mainimg_w_'.$this->_infoPAGE['id'],100);
    $dg_news->_main_img_h = $this->_regedit->read('dg_news_mainimg_h_'.$this->_infoPAGE['id'],100);
    $dg_news->_main_img_bgcolor = $this->_regedit->read('dg_news_mainimg_bgcolor_'.$this->_infoPAGE['id'],'#FFFFFF');
    $dg_news->_show_select_year = ($this->_regedit->read('dg_news_showyear_select_'.$this->_infoPAGE['id'],1))?true:false;
    $dg_news->_use_seo = ($this->_regedit->read('dg_news_seo_'.$this->_infoPAGE['id'],1))?true:false;
    $dg_news->content();
?>