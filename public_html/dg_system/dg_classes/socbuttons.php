<?


class soc_buttons{
    
    public $_title;
    public $_link;
    public $_des;
    public $_img;
    
 
    
    function fb(){
        
        return 'http://www.facebook.com/sharer/sharer.php?u='.urlencode($this->_link).'&t='.$this->_title;
        
    }
    
    function lj(){
        if ($this->_img!='') $img = '<img src="'.$this->_img.'" />'."\n";
        return 'http://www.livejournal.com/update.bml?event='.urlencode($img.$this->_des."\n".$this->_link).'&subject='.$this->_title;
        
    }
    
    function vk(){
        return 'http://vk.com/share.php?url='.urlencode($this->_link).'&title='.$this->_title;
    }
    
    function tw(){
        return 'https://twitter.com/intent/tweet?original_referer='.urlencode($this->_link).'&text='.$this->_title.'&url='.urlencode($this->_link);
    }
    
    function gp(){
        return 'https://plusone.google.com/_/+1/hover?hl=ru&url='.urlencode($this->_link).'&source=widget&isSet=true&referer='.urlencode($this->_link).'';
    }
    
}



?>