$.fn.dgform = function() {
	
	
		if (this.length) {
			
			
			function search(obj){
				
				$(obj).children().each(function(){
				
				 n = $(this).attr('name');
				 v  = $(this).val();
				 t = '';
				 
				 if ( ($(this).is('textarea')) || ($(this).is('input'))   ){
				 	
				 	//alert (n);
				 	
				 }
				 
				 
				 if ( $(this).children().length>0 ){
				 	
				 	
				 	search(this);
				 	
				 }
				
				//alert (t+'->'+t);
				
				 
				
			})
				
			}
		
		
		search(this);
	
			/**/
	
	   }
	
}