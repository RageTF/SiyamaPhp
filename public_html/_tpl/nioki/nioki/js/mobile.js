var w=0;
var scrolluse = false;
var dg_shop_url = "/cat/order/";
var g = window.location.href.split("#page");
var thisa = g[0];
var ou ='';

function ie(){
    if ((document.all && !document.querySelector) || (document.all && document.querySelector && !document.getElementsByClassName)) return true; else return false;
}

function getcontroll(){ 
    
    
    
    wlh = window.location.href;
 
    //alert($(document).attr('href'));
    aa = wlh.split("#page");
     //console.log(aa.length);
 
    if (aa.length==2){
        href = aa[1]+'&ajax';
        
        t = 0;   

        if (ou!=href){
            
            
           $("a"). removeClass('act');      
           $("a[href='"+aa[1]+"']").addClass('act');          
           
            if ((aa[1]=='/') || (aa[1]=='/main/') ){
                    $("#loader").css('display','none');
                    
                    $("#content").animate({top:3000},500).css('display','none');    
                    $("#main").css('display','block');
                    //$("#text_in").html('');
                  }else{
                             $("#loader").css('display','block');
                             //console.log(href);
                               
                             $("#main").css('display','none'); 
                             //console.log( $("#content_b").css('opacity'));
                             $("#c").html('');         
                              
                             $("#c").load(href,function(data){
                                    $("#loader").css('display','none');
                                    $("#content").css('display','block').animate({top:150},500); 
                                    aclick()
 if (!ie()) {
          

               
      }
                                    
                                    
                                         
                                    });  
                                     
                            }     
        ou = href;

        
        }

         
    } else {
        
        $("#content").animate({top:3000},500).css('display','none'); 
        $("#main").css('display','block');   
    }
}
function getrandom() { 

var min_random = 0;
var max_random = 100000;

max_random++;

var range = max_random - min_random;
var n=Math.floor(Math.random()*range) + min_random;

return n;
} 

function aclick(){
    
    
    
    $(".remove").click(function(){
        return confirm ('Убрать товар из корзины?');
    });
    
    $("#login").click(function(){
        $("#auth_box").css('display','block');
        return false;
    });
    $("#closelogin").click(function(){
        $("#auth_box").css('display','none');
        return false;
    });
    $(".dg_in_basket_mini").click(function(){
            if (confirm("Добавить товар в корзину?")){
                
                name = $(this).attr('title');
                id = $(this).attr('id');
            
                    
                   $.post(dg_shop_url+'?ajax&rand='+getrandom(),{total:1,dg_item_add:id},function(data){
                    
                    
                    if (data!=parseInt(data)) {console.log(data); alert ('Ошибка!') }else{
                      $.getJSON('/?ajax&gettotalinfo', function(data) {
                           if (data.error==0){
                           
                            $(".totalitems, #basket_info strong").text(data.items);
                            $(".totalprices").text(data.summ);
                            $(".totalprices_sale").text(data.summ_sale);
                            $(".dgshopskl").text(data.skl);
                            
                            
                          
                            
                            }else{
                                alert('Ошибка!');
                            }
                        });
                      
                    }
                    
                   });
                   
                
                
            }
            return false;
           
            return false;
        });
    
        $("#cat li a").click(function(){
        $("#cat li a").removeClass('act');
        $(this).addClass('act');
        
        
        u = $(this).attr('href');   
        if (u!='#'){
        if (u.indexOf('//')>0 || u.indexOf('.jpg')>0 || u.indexOf('.jpeg')>0 || u.indexOf('.JPG')>0 || u.indexOf('.JPEG')>0 || u.indexOf('.png')>0 || u.indexOf('.PNG')>0 || u.indexOf('.pdf')>0 || u.indexOf('.PDF')>0){ return true; }else{
        
        window.location.href = thisa+'#page'+u
        
        return false;

        }
        }else{
            
            
            
            
            
            
        }
    })
    
    //$("a[href$=jpg],a[href$=png],a[href$=gif]").lightBox({fixedNavigation:false});
    
    
 
      return false;
}


$(document).ready(function()	{
    
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
    $("#c").css('min-height',$(window).height());
    
                                        getcontroll();
                                        setInterval("getcontroll()",1000);
	                                    aclick();
	
    /*$("#cat li a").click(function(){
     
     h = $(this).attr('href');
     $("#c").load(h+'&ajax',function(data){
        $("#content").animate({top:150},500);   
     });
     
        
	return false;   
	});*/
				})