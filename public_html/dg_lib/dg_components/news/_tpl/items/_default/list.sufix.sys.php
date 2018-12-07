<? if ($this->_show_select_year) echo '     '.$this->select_year();?>
<? if ( $this->_show_pager ) echo '     '.page_parse($this->_maxobjectonpage,$total_result,$this->_pager_total,$this->_pager_cont);     ?>
    </div>
</div>