var l = 0;
var u = '';
function menu(){
    
    
    cl=0;
    a=0;
    ac=0;
    $("#menu ul li").each(function(){
        a++;
        if ($(this).attr('class')=='act') ac=a;
    });
    
    ps = $("#content").offset();
 
   $("#rarr").css('left',ps.left+$("#content").width()-37)
    $("#larr").css('left',ps.left)
    
    /*if (ac>0) {
        pp = 0-(ac*120-$(window).width())-120;
        if (pp>=0) pp=0;
       $("#menu ul").css('margin-left',pp); 
    }*/
    
    w = $("#menu ul li").length*120;
    $("#menu ul").css('width',w);
    l = parseInt($("#menu ul").css('margin-left'));
    
    //console.log(l);
    
    if ( $("#menu").width()<w){
        $("#rarr").css('display','block');
        
        $("#rarr").click(function(){
            
            
            l = l-120;
            if ((0-l)>0) $("#larr").css('display','block');
            
            if ((0-l)>=(w- $("#menu").width()+120)) $("#rarr").css('display','none');
            $("#menu ul").stop().animate({marginLeft:l});
            
             
             
        });
        
        
        
            $("#larr").css('display','block');
            if (l==0) $("#larr").css('display','none');
            $("#larr").click(function(){
                 
                
                
                l = l+120;
               
                if ((0-l)<(w- $("#menu").width()+120)) $("#rarr").css('display','block');
                $("#menu ul").stop().animate({marginLeft:l});
                if (l==0) $("#larr").css('display','none'); 
                
            });
        
        
    }else{
        $("#larr").css('display','none'); 
        $("#rarr").css('display','none'); 
    }
    
    
}
var banner_i = 0;
function bannerlist(){
    
     
        $("#banner li").css('display','none').css('opacity',0);
        $("#bn_"+banner_i).css('display','block').animate({opacity:1},'slow');

        $("#rounds li").removeClass('act');
        $("#rn_"+banner_i).addClass('act');

    bg = $("#bn_"+banner_i+' img').attr('src');
    
    $("#banner").css('background',"url('"+bg+"') center no-repeat");
    
    banner_i++;
    if ((banner_i)>($("#banner li").length-1)) banner_i=0; 
}
function closeAJ(){
    
    $('#WITEM,#WITEMCONTENT').remove(); $('body').removeClass('noover'); return false;
    
}
$(document).ready(function()	{
    $('.matte').attr('href','http://matte.su');
    $('.AJ').click(function(){
        
        $('body').addClass('noover');
        $("#WITEM,#WITEMCONTENT").remove();
        $('<div id="WITEM" onclick="closeAJ()"></div><div id="WITEMCONTENT"></div>').appendTo("body");
        h = $(this).attr('href');
        
        $("#WITEMCONTENT").load(h);
        
        
        return false;
    })
    
    $('#SelectCity h2').click(function(){
        $("#SelectCityU").toggle();
        
    })
    
    if ($("#r_cat").attr('tabindex')=='0') lp = '#r_cat'; else lp = '#r_i';
    
    $("#m").html($(lp).html());
    
    menu();
	$(window).resize(function(){ menu(); });
    
    
    $("#cat_b a").click(function(){
        h = $(this).attr('href');
        $("#m").html($(h).html());
        $("#cat_b a").removeClass('act');
        $(this).addClass('act');
        menu();
        return false;
    });
    
    liid=0;
    rd = $('<ul id="rounds"></ul>');
    $("#banner").after(rd)
    $("#banner li").each(function(){
        $(this).attr('id','bn_'+liid);
        r = $('<li id="rn_'+liid+'" alt="'+liid+'"></li>');
        $(r).appendTo(rd);
        liid++;
    });
    
    $("#rounds li").click(function(){

        clearInterval(interv);
        banner_i = $(this).attr('alt');
        bannerlist();
        interv = setInterval('bannerlist()',10000);
    });
    
    bannerlist()
    interv = setInterval('bannerlist()',5000);
    
    $("#openminibs").click(function(){
       if ($("#minibas").css('display')=='none'){
        $("#minibas").slideDown();
        $(this).addClass('openminibsdown');
       }else{
        $("#minibas").slideUp();
        $(this).removeClass('openminibsdown');
       }
    });
    $("#openauth").click(function(){
        console.log('a');
        $("#auth_box").dialog({
			width: 400,
            height:300,
			modal: true
		});
        return false;
    });
    $("#regauthb").click(function(){
       if ($("#auth_box_form_fio").css('display')=='none'){
        $("#auth_box_form_fio").css('display','block');
        $("#auth_box_form_fio input").focus();
        $(this).text('Вход');
        $("#auth_box_form_go").val('Регистрация');
        u = $("#auth_box_form").attr('action');
        $("#auth_box_form").attr('action',$(this).attr('href'));
        $(this).attr('href',u);
       } else {
        u = $("#auth_box_form").attr('action');
        $("#auth_box_form").attr('action',$(this).attr('href'));
        $(this).attr('href',u);
        
        $("#auth_box_form_fio").css('display','none');
        $(this).text('Регистрация');
        $("#auth_box_form_go").val('Вход');
       }
       console.log($("#auth_box_form").attr('action'));
        return false;
    });
    
				})