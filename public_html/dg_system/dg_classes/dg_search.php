<?
/**
 * @author mrhard
 * @copyright 2010
 */

    class dg_search_RussianStemmer {
    var $VERSION = "0.02";
    var $Stem_Caching = 0;
    var $Stem_Cache = array();
    var $VOWEL = '/аеиоуыэюя/';
    var $PERFECTIVEGROUND = '/((ив|ивши|ившись|ыв|ывши|ывшись)|((?<=[ая])(в|вши|вшись)))$/';
    var $REFLEXIVE = '/(с[яь])$/';
    var $ADJECTIVE = '/(ее|ие|ые|ое|ими|ыми|ей|ий|ый|ой|ем|им|ым|ом|его|ого|ему|ому|их|ых|ую|юю|ая|яя|ою|ею)$/';
    var $PARTICIPLE = '/((ивш|ывш|ующ)|((?<=[ая])(ем|нн|вш|ющ|щ)))$/';
    var $VERB = '/((ила|ыла|ена|ейте|уйте|ите|или|ыли|ей|уй|ил|ыл|им|ым|ен|ило|ыло|ено|ят|ует|уют|ит|ыт|ены|ить|ыть|ишь|ую|ю)|((?<=[ая])(ла|на|ете|йте|ли|й|л|ем|н|ло|но|ет|ют|ны|ть|ешь|нно)))$/';
    var $NOUN = '/(а|ев|ов|ие|ье|е|иями|ями|ами|еи|ии|и|ией|ей|ой|ий|й|иям|ям|ием|ем|ам|ом|о|у|ах|иях|ях|ы|ь|ию|ью|ю|ия|ья|я)$/';
    var $RVRE = '/^(.*?[аеиоуыэюя])(.*)$/';
    var $DERIVATIONAL = '/[^аеиоуыэюя][аеиоуыэюя]+[^аеиоуыэюя]+[аеиоуыэюя].*(?<=о)сть?$/';

	function dg_search_RussianStemmer() {
		$Stem_Caching = 0;
	}
    function s(&$s, $re, $to) {
        $orig = $s;
        $s = preg_replace($re, $to, $s);
        return $orig !== $s;
    }

    function m($s, $re) {
        return preg_match($re, $s);
    }

    function stem_word($word) {

        
       $word = mb_strtolower($word,"UTF-8");
        

        if ($this->Stem_Caching && isset($this->Stem_Cache[$word])) {
            return $this->Stem_Cache[$word];
        }
        $stem = $word;
        do {
          if (!preg_match($this->RVRE, $word, $p)) break;
          $start = $p[1];
          $RV = $p[2];
          if (!$RV) break;

    
          if (!$this->s($RV, $this->PERFECTIVEGROUND, '')) {
              $this->s($RV, $this->REFLEXIVE, '');

              if ($this->s($RV, $this->ADJECTIVE, '')) {
                  $this->s($RV, $this->PARTICIPLE, '');
              } else {
                  if (!$this->s($RV, $this->VERB, ''))
                      $this->s($RV, $this->NOUN, '');
              }
          }

     
          $this->s($RV, '/и$/', '');

       
          if ($this->m($RV, $this->DERIVATIONAL))
              $this->s($RV, '/ость?$/', '');

   
          if (!$this->s($RV, '/ь$/', '')) {
              $this->s($RV, '/ейше?/', '');
              $this->s($RV, '/нн$/', 'н');
          }

          $stem = $start.$RV;
        } while(false);
        if ($this->Stem_Caching) $this->Stem_Cache[$word] = $stem;
       
	    return $stem;
	    
    }

    function stem_caching($parm_ref) {
        $caching_level = @$parm_ref['-level'];
        if ($caching_level) {
            if (!$this->m($caching_level, '/^[012]$/')) {
                die(__CLASS__ . "::stem_caching() - Legal values are '0','1' or '2'. '$caching_level' is not a legal value");
            }
            $this->Stem_Caching = $caching_level;
        }
        return $this->Stem_Caching;
    }

    function clear_stem_cache() {
        $this->Stem_Cache = array();
    }
}



function dg_search_search($class,$gq){
            $q='';
            $q1 = htmlspecialchars_decode($gq);
            $q1 = str_replace('+',' ',$q1);
            $q1 = str_replace('%',' ',$q1);
            $q1 = ' '.str_replace('_',' ',$q1).' ';
            $ex = explode(' ',$q1);
            $mor = new dg_search_RussianStemmer;
            

            
            foreach($ex as $m=>$vv){
                $GLOBALS['searchtext'][] = $mor->stem_word($vv);
                
            	if (trim($vv)!=''){
            	   $q[0].="OR `#s` LIKE '%".$class->_Q->e($mor->stem_word($vv))."%' ";
                   $q[1].=$mor->stem_word($vv).',';
            	}
            }

            return $q;
}

function shorttext($text,$q){
    $text = trim(strip_tags($text));
    $ex = explode(' ',$text);
    $total='';
    $start=0;
    
    
    
    for ($i=0; $i<=count($ex);$i++){
        if (is_array($q)){
            if (mb_substr_count($ex[$i],$q[0],'utf-8')>0 && ($start==0 || $start>$i)){ $start=$i; }
        }    
    }
    $start = $start - 10;
    if ($start<0) $start=0;

    if (trim($ex[$start].$ex[($start+1)].$ex[($start+2)].$ex[($start+3)])=='') $start = 0; 
   


    for ($i=$start; $i<=($start+30);$i++){


        $b1='';$b2='';
        if (is_array($q)){
            foreach($q as $ii=>$vv){
            	if (substr_count(mb_strtolower($ex[$i],'utf-8'),mb_strtolower($vv,'utf-8'))>0){ $b1='<b>'; $b2='</b>'; } 
            }
        }
        $total.=$b1.$ex[$i].$b2.' ';


    }
    $total = trim($total);
    if (count($ex)>30) $total.='…';
    if ($start>0) $total='…'.$total;
    return $total;
}

?>