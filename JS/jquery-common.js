var ajax_request = null;

$(document).ready(function(){

	var options = {
		rowsPerPage : 10,
		firstArrow: (new Image()).src="./imgs/1330075057_resultset_first.png",
		prevArrow : (new Image()).src="./imgs/1330074981_resultset_previous.png",
		lastArrow : (new Image()).src="./imgs/1330075058_resultset_last.png",
		nextArrow : (new Image()).src="./imgs/1330074980_resultset_next.png",
	};
	$('#most-requested-tracks table').tablePagination(options);
	
	// autocomplete artist
	$( "#artist" ).autocomplete({
		source: "home.php?action=find_artist",
		minLength: 2,
		select: function( event, ui ) {
			$('#artist').val( ui.item.name );
			$('#artist_mbid').val( ui.item.mbid );
			$('#artist').parent().find('.ajax_loader').show();
			
			// get Top Tracks for Artist
			$.ajax({
				type: "POST",
				url: "home.php",
				data: "ajax=1&action=find_top_tracks&artist_mbid="+ui.item.mbid+"&artist="+encodeURI(ui.item.name),
				dataType:"json",
				success: function(msg) {
					$('#artist').parent().find('.ajax_loader').hide();
					if(msg.success) {
						$("table#tracks tbody").html(msg.html);
					//	$("table#tracks").fadeIn("slow");
					}
				}
			});
			
			return false;
		},
		search: function() {
			$('#artist').parent().find('.ajax_loader').show();
		},
		open: function(){
			$('#artist').parent().find('.ajax_loader').hide();
		}
	})
	// modifiy return list to accept custom data
	.data( "autocomplete" )._renderItem = function(ul, item){
		return $("<li></li>")
			.data("item.autocomplete", item)
			
			.append("<a>"+item.name+"</a>")
			
			.appendTo(ul);
	};
	
	// autocomplete track
	$( "#track" ).autocomplete({
		source: "home.php?action=find_track",
		minLength: 2,
		select: function( event, ui ) {
			$('#track').val( ui.item.name );
			return false;
		},
		search: function() {
			$('#track').parent().find('.ajax_loader').show();
			// reset the track table on each search
			$("table#tracks tbody").html('');
		},
		open: function(){
			$('#track').parent().find('.ajax_loader').hide();
			$("table#tracks").fadeIn();
		}
	})
	// modifiy return list to accept custom data
	.data( "autocomplete" )._renderItem = function(ul, item){
		// append the tracks onto the track table
		$("table#tracks tbody").append('<tr class="'+((item.key%2==0)?'even':'odd')+'"><td class="artist">'+item.artist+'</td><td class="track"><a href="'+item.url+'" target="_blank">'+item.name+'</a></td><td class="request"><a href="#" class="request_link">Request</a></td></tr>');
		return false;
//		return $("<li></li>")
//			.data("item.autocomplete", item)
//			.append("<a>"+item.name+" ("+item.artist+")</a>")
//			.appendTo(ul);
	};

	// a song has been requested
	$('.request_link').live('click',function(){
		// get the row
		var _row = $(this).parents('tr');
		// get the artist name
		var _artist = (_row.find('.artist a').length) ? _row.find('.artist a').html() : _row.find('.artist').html() ;
		
		// save request via Ajax
		$.ajax({
			type: "POST",
			url: "home.php",
			data: "ajax=1&action=request_track&artist="+encodeURI(_artist)+"&track="+encodeURI(_row.find('.track a').html()),
			dataType: "json",
			success: function(msg) {
				if(msg.success) {
					reload_requested();
					ajax_message(msg.msg,'flash_good');
					_row.fadeOut();
				} else {
					ajax_message(msg.msg,'flash_bad');
				}
			}
		});
		
	return false;
	});
});

// display Ajax messages
function ajax_message(text, class_name) {
	if($('.ajax-message').length) {
		$('.ajax-message').fadeOut();
	}
	
	$('#search').before('<p class="ajax-message '+class_name+'">'+text+'</p>');
}

// reload requested tracks
function reload_requested() {
	$.ajax({
		type: "POST",
		url: "home.php",
		data: "ajax=1&action=reload_requested",
		dataType: "json",
		success: function(msg) {
			if(msg.success) {
				$('#most-requested-tracks table tbody tr').fadeOut("slow",function(){
					$('#most-requested-tracks table tbody').html(msg.html);
				});
			} else {
				ajax_message("Error reloading the most requested tracks",'flash_bad');
			}
		}
	});
}