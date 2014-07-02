var f_unf={'follow':'un_follow','un_follow':'follow'};


$(function() {
  $("BUTTON").click(function(){
					var buttonName = $(this).attr("name");
					var buttonValue = $(this).attr("value");
					var str = buttonName+"="+$(this).attr("value");
					$.ajax({
						   type: "POST",
						   url: "ajax_setdb_follow.php",
						   dataType: "json",
						   data: str,
						   success: function(data){
						   $('[value='+buttonValue+']').attr("name", f_unf[buttonName]);
						   $('[value='+buttonValue+']').html(data['button']);
						   resetFollow(data,buttonValue);
						   },
						   error: function(xhr, textStatus, errorThrown){
						   alert('Error! ' + textStatus + '. ' + errorThrown);
						   }
						   });
					 });
  });


function resetFollow(_arr,_fid){
	if(_arr['function']=='remove'){
		$("#follow_"+_fid).remove();
	}else{
		$('p#title_follow').after([
								'<ul id="follow_'+_fid+'">',
								'<p>'+_arr['info']['facebook_name']+'</p>',
								'<p><img src="'+_arr['info']['icon']+'">',
								'<BUTTON name="un_follow" class="follower" value="'+_fid+'" >フォローを外す</BUTTON></p>',
								'</ul>',
							   ].join(""));
	}
}
