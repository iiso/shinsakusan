


var tapCount=0;



/**

$(function() {//アーティストを登録
	 $("body").on('click', 'span#register', function(){
		

                        //++tapCount;
			
						 if(tapCount<=1){
                    var img = $(this).attr("value");
                    var name = $(this).attr('name');
		     var title = $(this).attr('title');
	
                    $.post('ajax_register.php', {
                        name: name,
			img : img,
			title : title
		
                    });
                    $(this).removeAttr('id').attr('id','del_registration').removeClass("add-button-off").addClass("add-button-on").attr('onclick','');
		     $(this).parent().removeClass('register-button').addClass("register-button active");
		   
		    
		      if($("#fb:checked").val()) {
   
      $.post('ajax_fbpost.php', {
                        name: name,
			img : img,
			title : title
		
                    });
     
     
     
   }
		    
                    tapCount=0;
						  }else{
                          tapCount=0;
                          }
			  noty({text: name+'を登録しました',
			      layout: 'bottom',
			      type: 'success',
			      timeout: 1000,
			     }
			      ); 
                          });
                          });

**/
$(function() {//アーティストを登録
	 $("body").on('click', '#register', function(){
		

                        //++tapCount;
			
						 if(tapCount<=1){
                    var img = $(this).attr("value");
                    var name = $(this).attr('name');
		     var title = $(this).attr('title');
	
                    $.post('ajax_register.php', {
                        name: name,
			img : img,
			title : title
		
                    });
                    $(this).removeAttr('id').attr('id','del_registration');
		    $(this).removeClass('register-button').addClass("register-button active");
		    
		   
		    
		      if($("#fb:checked").val()) {
   
      $.post('ajax_fbpost.php', {
                        name: name,
			img : img,
			title : title
		
                    });
     
     
     
   }
		    
                    tapCount=0;
						  }else{
                          tapCount=0;
                          }
			/**  noty({text: name+'を登録しました',
			      layout: 'bottom',
			      type: 'success',
			      timeout: 1000,
			     }
			      ); **/
                          });
                          });

$(function() { //解除
	 $("body").on('click','#del_registration', function(){   tapCount=-1;
 
                       // ++tapCount;
						 if(tapCount<=1){
                     var img = $(this).attr("value");
                    var name = $(this).attr('name');
                    $.post('ajax_del_registration.php', {
                        name: name,
			img : img
                    });
		    
                    $(this).removeAttr('id').attr('id','register');
		    $(this).removeClass('register-button active').addClass("register-button");
		    
		 
		    
                    tapCount=0;
		    
		    
						  }else{
                          tapCount=0;
                          }
			/** noty({text: name+'の登録を解除しました',
			      layout: 'bottom',
			      type: 'error',
			      timeout: 1000,
			     }
			      ); **/
                          });


                          });





/**

$(function() { //解除
	 $("body").on('click','#del_registration', function(){ 

                       // ++tapCount;
						 if(tapCount<=1){
                     var img = $(this).attr("value");
                    var name = $(this).attr('name');
                    $.post('ajax_del_registration.php', {
                        name: name,
			img : img
                    });
		    
                    $(this).removeAttr('id').attr('id','register').removeClass("add-button-on").addClass("add-button-off");
		    $(this).parent().removeClass('register-button active').addClass("register-button");
		    
		 
		    
                    tapCount=0;
		    
		    
						  }else{
                          tapCount=0;
                          }
			 noty({text: name+'の登録を解除しました',
			      layout: 'bottom',
			      type: 'error',
			      timeout: 1000,
			     }
			      ); 
                          });


                          });

**/

//register-fbでアーティストを解除

$(function() {
$("div.added-layer-top").live('click',function(){
                        ++tapCount;
						 if(tapCount<=1){
                   
                    var id = $(this).attr('id');
                    $.post('ajax_fbdel_registration.php', {
                        id: id,
			
                    });
		$(this).removeClass("added-layer-top").addClass("layer-top");
		
		 $(this).empty();
		 $(this).attr('onclick','');
		
                    
                    tapCount=0;
						  }else{
                          tapCount=0;
                          }
                          });
                          });

//register-fbでアーティストを登録
$(function() {
$("div.layer-top").live('click',function(){
                        ++tapCount;
						 if(tapCount<=1){
                   
                    var id = $(this).attr('id');
                    $.post('ajax_fbregister.php', {
                        id: id,
			
                    });
		$(this).removeClass("layer-top").addClass("added-layer-top");
		 $(this).append('<div class="added-mark" > <img class="check-icon" src="./img/basic/check.png"><p>登録中</p></div>');
                    tapCount=0;
						  }else{
                          tapCount=0;
                          }
                          });
                          });

//hide keyboard when autocpmplete has clicked
$(function() {
	 $("body").on('click','li.ui-menu-item', function(){
    $("input#artist").blur();}
)
});

/**
$("li.ui-menu-item").click(function(){
$("input#artist").blur();
});
**/


