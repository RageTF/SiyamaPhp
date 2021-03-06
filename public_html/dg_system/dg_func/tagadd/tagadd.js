jQuery.fn.tag_add = function(options){

	     			  var obj = jQuery(this);
	     			  var selecttext='';
                      

                      var options = jQuery.extend({
    				    loadinfo: 'loadtag.php',
    				    minlength: 1,
                        maxlength: 100,
                        maxitem:10
				      },options);
  				    

        var tagtext = '';
        var tag_ex = [];
        var it=0;
        var selqt=0;
        var lastselectrestag='';
        var Showdgs=true;
        var selitemdef=0;
        
		function getCaretPosition (ctrl) {
				 var CaretPos = 0;
				 if (document.selection) {
					ctrl.focus ();
					var Sel = document.selection.createRange ();
					Sel.moveStart ('character', -ctrl.value.length);
					CaretPos = Sel.text.length;
	    		 }else if (ctrl.selectionStart || ctrl.selectionStart == '0')
					CaretPos = ctrl.selectionStart;
				 return (CaretPos);
	   }

		function setCaretPosition(ctrl, pos){

			 	if(ctrl.setSelectionRange)
				{
					ctrl.focus();
				ctrl.setSelectionRange(pos,pos);
				}
				else if (ctrl.createTextRange) {
						var range = ctrl.createTextRange();
						range.collapse(true);
						range.moveEnd('character', pos);
						range.moveStart('character', pos);
						range.select();
				}
		}


		function getCaretPos(obj){
 				 obj.focus();
 				 if(obj.selectionStart) return obj.selectionStart;
 				 else if (document.selection){
  				 	return getCaretPosition (obj);
 				 }

 				return 0;
		}

		function tagtrim ( str, charlist ) {
     			charlist = !charlist ? ' \s\xA0' : charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    			var re = new RegExp('^[' + charlist + ']+|[' + charlist + ']+$', 'g');
    			return str.replace(re, '');
		}

		function substr_replace(s,e,str,sbstr){
      				sbstr=tagtrim(sbstr); 
	 				return str.substr(0,s)+sbstr+str.substr((s+e),(str.length-(s+e)));
		}

  		function searchtext(strtag,cpos){
       			 	var space=true;
       				var startstr=0;
       				var endstr=strtag.length;
      				var res = '';
      				for (i=cpos;i>=0;i--){
						if (startstr==0){
         					if (strtag.substr((i-1), 1)==','){
	   							startstr = i;
	   							if ( (strtag.substr((i), 1)!=' ') && (i!=strtag.length) ){
              						space=false;
	   							}
	 						}
						}
      				}

       				for (i=cpos;i<=strtag.length;i++){
						if (endstr==strtag.length){
         					if (strtag.substr(i, 1)==','){
	   							endstr = i;
	 						}
	 					}
      				}
					       
      				if (startstr==0){ startstr=-1; }
      				if (space){ tagstart =startstr+1; tagend=endstr-startstr-1;
       					res = (strtag.substr((startstr+1), (endstr-startstr-1)));
      				}else{tagstart =startstr; tagend=endstr-startstr;
       					  if (startstr==-1){ startstr=0; }
       					 res = (strtag.substr(startstr, (endstr-startstr)));
      				}      
      				return res;
		}

						
				      function  go_tag_load(e,o,jo){
				      	
				      			if ( (e.keyCode==40)||(e.keyCode==38)||(e.keyCode==13) ){ return false; }
								selqt=0; it=0;
           			      		var tag_text = jQuery(o).val();
           			      	
           			      		var text_search = searchtext(tag_text,getCaretPos(o));
								var tag_ex =tagtext.split(',');
           			      	    if ( (text_search.length >= jo.minlength) && (text_search.length <= jo.maxlength) ){
								 if (tagtext!=''){
								  tl = tagtext;
                                    tl=tl.toLocaleLowerCase();
							 		if(tl.indexOf(text_search.toLocaleLowerCase()) + 1) {
			
      						  		    var tag_str = '';
							   		
							  			jQuery(".tag_add_input_form").remove();
							  			var formtagselect = jQuery('<div class="tag_add_input_form" name="tag_add_input_form_name"></div>').css('opacity','0.9');
            							
                                        poff = jQuery(o).offset();
                                        $(formtagselect).css('left',poff.left).css('top',poff.top+1);
                                        
                                        jQuery(o).before(formtagselect); 
							 			it=0;
					          			for (var key in tag_ex) {
							   				 var val = tag_ex [key];
							  				if ((val.toLocaleLowerCase().indexOf(text_search.toLocaleLowerCase()) + 1) && ( ((jo.maxitem-1)>=it)||(jo.maxitem==0) )) {   it++;
                                  				var item  = jQuery('<li id="tagselid_'+it+'">'+tagtrim(val.split(text_search).join('<b>'+text_search+'</b>'))+'</li>');
							      				jQuery(item).appendTo(formtagselect);
							  
							  				}
							  			}
							  			                
                          				jQuery(".tag_add_input_form li").click(function(){
                    			        		var seltext = jQuery(this).text();
                    			        	
                                        		jQuery(o).val(substr_replace(tagstart,tagend,jQuery(o).val(),seltext));
                    			        		jQuery(".tag_add_input_form").remove(); selqt=0; it=0;
						  				})
				
						  				
						  				
						  				
							 		}else{ jQuery(".tag_add_input_form").remove(); selqt=0; it=0; }
							    }
							   } else { jQuery(".tag_add_input_form").remove(); selqt=0; it=0; }
          			 }
                    
          				function selectrestag(e,o,jo){
          						if ( !jQuery('.tag_add_input_form').length ){return false;}
				 				if (e.keyCode==40){ 
				  					selqt++;          		
				  					if (selqt==(it+1)){ selqt=1; }
          		 				}         		 
  		 						if (e.keyCode==38){ 
				  					selqt--;     		
				  					if (selqt==-1){ selqt=it; }
          		  					if (selqt==0){selqt=it;}
				   				}
				   				if ((e.keyCode==13) && (lastselectrestag!='')){
                                    jQuery(o).val(substr_replace(tagstart,tagend,jQuery(o).val(),jQuery(lastselectrestag).text()));
                    			    jQuery(".tag_add_input_form").remove(); selqt=0; it=0; return false;				 	
				 				}  
          						jQuery("#tagselid_"+selqt).addClass('tag_add_input_form_sel');
								if (lastselectrestag!=''){          			
          							jQuery(lastselectrestag).removeClass('tag_add_input_form_sel');          			
          						}          		
				  				lastselectrestag = "#tagselid_"+selqt;
								return false;        	
          				}
				    jQuery.post(options.loadinfo,function(data){tagtext = data})				    
				    var fs = true;
				    this.attr("autocomplete",'off');
				    
					this.blur(function(){ fs=true; })
					this.click(function(e){go_tag_load(e,this,options); fs=false; return false; });
				    this.keyup(function(e){go_tag_load(e,this,options); return false;});
				    this.keydown(function(e){if ((e.keyCode==40)||(e.keyCode==38)||(e.keyCode==13)){ selectrestag(e,this,options); return false;}});	 		
					
					
				
					jQuery('form').submit(function(){ return fs; })
					
							  			$("*",document.body).click(function(){							  			 
											if ( (jQuery(this).attr('type')=='text') || (jQuery(this).attr('name')=="tag_add_input_form_name")){
                 									 return false;	        
										    }else{
												jQuery(".tag_add_input_form").remove(); selqt=0; it=0; 
											}							  				
							  			})
					  
					  };	 