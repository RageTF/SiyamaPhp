var modal = '';


function reordergo(obj){
    h = $(obj).attr('href')+'&ajax';
    span = $(obj).parent('span');
    div = $(span).parent('div');
    input = $(div).children('input.order_total');
    
    
    
    $.getJSON(h, function(data) {
           if (data.error==0){
           
            $(".totalitems, #basket_info strong").text(data.items);
            $(".totalprices").text(data.summ);
            $(".dgshopskl").text(data.skl);
            $(".totalprices_sale").text(data.summ_sale);
            $(input).attr('title',$(input).val());
            $(span).html('');
            $("span#totalprice_"+$(div).attr('name')).text(data.totalprice);
             
            if ($("#minibas").length==1){
                 
                $("#minibas").load('/?ajax&loadminibas',function(data){
                    $( "input:submit, a.button").button();
                });
            }
            }else{
                alert('Ошибка!');
            }
        });

}
function reorder(obj){  
    
    if (parseInt($(obj).val())!=$(obj).val()){
        $(obj).addClass('warning');
    }else{
        
        
        if (parseInt($(obj).val())<=0){
            $(obj).addClass('warning');
        }else{
            $(obj).removeClass('warning');
        
            div = $(obj).parent('div');
            span = $(div).children('span');
            if ($(obj).val()!=$(obj).attr('title')){
               $(span).html(' <a href="'+dg_shop_url+'?dgshop_reorder&ids='+$(div).attr('name')+'&total='+$(obj).val()+'" onClick="reordergo(this); return false;">пересчитать?</a>'); 
            }else{
                $(span).html(''); 
            }
        }
    }
}



function dgshopadd(){
   
   total_item = $("#dgshopadd #dgshop_total").val();
   key = $("#dgshopadd #dgshop_add").val();
    
   $.post('/?ajax',{total:total_item,dg_item_add:key},function(data){
    if (data!=parseInt(data)) {alert ('Ошибка!') }else{
      $.getJSON('/?ajax&gettotalinfo', function(data) {
           if (data.error==0){
           
            $(".totalitems, #basket_info strong").text(data.items);
            $(".totalprices").text(data.summ);
            $(".totalprices_sale").text(data.summ_sale);
            $(".dgshopskl").text(data.skl);
            
            
             
            if ($("#minibas").length==1){
                
                $("#minibas").load('/?ajax&loadminibas',function(data){
                   $( "input:submit, a.button").button();
                });
            }
            
            }else{
                alert('Ошибка!');
            }
        });
      
    }
    
   });
   $(modal).dialog("destroy");
   $(".dgshop_modal").remove();
}


function dg_in_basket(o){
    
     $(".dgshop_modal").remove();
	   id = $(o).attr('id');
       name = $(o).attr('title');
       modal = $('<form method="post" id="dgshopadd" action="'+dg_shop_url+'"><div title="Добавить товар в корзину" class="dgshop_modal"><p><strong>'+name+'</strong></p><p>Кол-во: <input type="text" size="5" value="1" name="total" id="dgshop_total" /><input type="hidden" name="dg_item_add" id="dgshop_add"  value="'+id+'" /></p><p><input type="submit" class="dgshop_button" value="Оформить заказ"> <input type="button" id="dgshop_button_add" class="dgshop_button" value="Продолжить" onClick="dgshopadd()"></p></form></div>');
       $(modal).appendTo('body');
       $(modal).attr('title','Добавить в корзину');
        $(modal).dialog({
			width: 400,
			modal: true
		});
       $( ".dgshop_button" ).button();
       return false;
    
}
$(document)

.ready(function()	{
/*	$(".dg_in_basket").click(function(){
	   return dg_in_basket(o);
	});*/
    
    
    $( "input:submit, a.button").button();
    $('.order').each(function(){
        h = $(this).attr('href')+'&shop';
        $(this).attr('href',h);
    });
    
    $("input.order_total").keyup(function(){ reorder(this); }).click(function(){ reorder(this); });
  
				})