<?php 
/**
 * PressApps Product Template page
 * @since 1.0.0
 */

/**
 * API callback sample
 * @return Object from API callback. 
 * category: "wordpress/media"  
 * cost: "10.00"
 * id: "11178480"
 * item: "Video Sortable Extension For Layers Builder"
 * last_update: "Tue May 19 00:47:08 +1000 2015"
 * live_preview_url: "https://0.s3.envato.com/files/132193285/preview_590x300.jpg"
 * rating: "0.0"
 * rating_decimal: "0.00"
 * sales: "0"
 * tags: "embed videos, layers builder extension, sortable videos, video extension"
 * thumbnail: "https://0.s3.envato.com/files/132193280/thumbnail_80x80.png"
 * uploaded_on: "Sat May 02 05:38:11 +1000 2015"
 * url: "http://codecanyon.net/item/video-sortable-extension-for-layers-builder/11178480"
 * user: "PressApps"
 */
?>
<script type="text/javascript">
	
	
	jQuery(document).ready(function($) {
	
	$.ajax({
	  url: "http://pressapps.co/wp-admin/admin-ajax.php",
	  data:{
		action: 'pressapps_api',
		type: 'codecanyon' // change this category to retrieve other products
	  }, 
	  method: "post",
	  dataType: 'jsonp',

	})
	.done(function( d ) {
		console.log(d);
		var products = [];
	  	jQuery.each(d['new-files-from-user'],function(i,dd){
	  		var item_thumbnail = [
	  			'<div style="float:left;padding:10px;">',
	  			'<img src="'+dd.thumbnail+'"/>',
	  			'</div>'

	  		];
	  		products.push(item_thumbnail.join(""));
	  	});

	  	jQuery.each(d['new-files-from-user'],function(i,dd){
	  		var item_large = [
	  			'<div style="float:left;padding:4px;">',
	  			'<h3>'+dd.item+'</h3>',
	  			'<a href="javascript:;">',
	  			'<img src="'+dd.live_preview_url+'" style="width:500px"/>',
	  			'</a><br/>',
		  			'<div style="float:right;">',
		  			'<a href="'+dd.url+'" target="_blank" class="button pullright">Live Demo</a> ',
		  			'<a href="'+dd.url+'" target="_blank" class="button-primary pullright">Buy $'+dd.cost+'</a>',
		  			'</div>',
	  			'</div>'

	  		];
	  		products.push(item_large.join(""));
	  	})
	    jQuery("#pa-products").html(products.join(""));
	     
	   
	})
	  
});
</script>
<h2>PressApps Products</h2>
<div id="pa-products">
</div>