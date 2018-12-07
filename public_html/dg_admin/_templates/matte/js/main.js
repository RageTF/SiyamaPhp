function showsave(m){
    if (m){
        $("#savemess").css('display','block').animate({opacity:1,top:20},'slow',function(){
        $("#savemess").animate({opacity:0,top:-20},'slow',function(){ $("#savemess").css('display','none') });
        });
    }
}

function gt(from,to){
    if ($(from).val()!=''){ 
        $(to).addClass('wt');
        $.post('/dg_system/dg_func/googletranslate.php',{q:$(from).val(),forurl:true,lang:DGLANG},function(data){
            if (data!=''){
                $(to).removeClass('wt').val(data);
                
            }
        });
    }
}

$(document).ready(function() {
var textareaclear = false;



	$('form.ajax').keyup(function(e){
		if (e.keyCode==113){
				showsave(true);
                //$(this).ajaxForm();
			    $(this).submit(); 
                 return false;
		}
	});
	
	$('form.ajax input[type="submit"]').click(function(){
	   showsave(true);
	})
	
	            $('form.ajax').ajaxForm(function(data) { 
	               
                   if (data!='ok') alert(data);
                 
            	}); 
            	

    $.datepicker.setDefaults($.datepicker.regional[DGLANG]);
    $.datetimepicker.setDefaults($.datepicker.regional[DGLANG]);
    $(".datetime").datetimepicker({ dateFormat: 'yy-mm-dd',timeFormat: ' hh:ii:ss' });
    $(".date").datepicker({ dateFormat: 'yy-mm-dd'});
    

    $(".na").css('opacity',.5);

    
    
    $(".file_png, .file_jpg, .file_jpeg, .file_png, .file_gif").hover( function(){
        var h = $(this).attr('href');
        $(this).before('<div class="img_pre"><img src="'+h+'"></div>');
    },function(){
        $('.img_pre').remove();
    } );

    $(".dir_list li div").hover(function(){
        var dp =$(this).children('div');
        
        $(dp).css('display','block');
    },function(){
        $(".filecontent").css('display','none');
    });
    
    
    $("body").keyboard(
			'ctrl alt p',
			function () {
				window.location.href='/dg_admin/?comp=source&use=pages';
			}
		).keyboard(
			'ctrl alt f',
			function () {
				window.location.href='/dg_admin/?comp=source&use=filemanager';
			}
		)
        .keyboard(
			'ctrl alt u',
			function () {
				window.location.href='/dg_admin/?comp=source&use=users';
			}
		).keyboard(
			'ctrl alt t',
			function () {
				window.location.href='/dg_admin/?comp=design&use=templates';
			}
		).keyboard(
			'ctrl alt m',
			function () {
				window.location.href='/dg_admin/?comp=design&use=blockmodules';
			}
		).keyboard(
			'ctrl alt c',
			function () {
				window.location.href='/dg_admin/?comp=system&use=configurationcomponent';
			}
		).keyboard(
			'ctrl alt s',
			function () {
				window.location.href='/dg_admin/?comp=system&use=setting';
			}
		).keyboard(
			'ctrl alt n',
			function () {
				window.location.href='/dg_admin/?comp=source&use=pages&func=update';
			}
		).keyboard(
			'ctrl alt l',
			function () {
				 $("#logs").remove();
                 var logs = $('<div id="logs" title="demiurgo.logs"></div>');
                 $(logs).dialog({ width: 800,height: 600, }).load('/dg_admin/?comp=system&use=logs');
                 
			}
		).keyboard(
			'ctrl alt r',
			function () {
				window.location.href='/dg_admin/?setupcpmponent';
			}
		).keyboard(
			'ctrl alt a',
			function () {
				 $("#about").remove();
                 var about = $('<div id="about" title="about demiurgo.cms"></div>');
                 $(about).dialog({ width: 400,height: 400, }).load('/dg_admin/?comp=system&use=about');
                 
			}
		);
        
        $(".logs li").click(function(){
            d = $(this).children('detals');
            $(d).css('display','block');
        })
        $("a.removeaccess").click(function(){
            h = $(this).attr('href');
            if (h=='') return true;
                 $("#removeaccess").remove();
                 var removeaccess = $('<div id="removeaccess" title="'+accesspassword+'"><form method="post" class="dg_form" autocomplete="off" action="'+h+'"><input type="password" name="accesspassword" id="accesspasswordin" /><input type="hidden" name="goaccess" value="true" /></form></div>');
                 $(removeaccess).dialog({ modal: true })
                 $("#accesspasswordin").focus();
            return false;
        }); 
})