
this.screenshotPreview = function(){

	xOffset = 10;
	yOffset = 30;

	$("a.screenshot").hover(function(e){
		this.t = this.title;
		this.title = "";
		var c = (this.t != "") ? "<br/>" + this.t : "";
		$("body").append("<p id='screenshot'><img src='"+ this.rel +"' alt='url preview' />"+ c +"</p>");
		$("#screenshot")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn(500);
	},
	function(){
		this.title = this.t;
		$("#screenshot").remove();
	});

	$("a.screenshot").mousemove(function(e){
		$("#screenshot")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});
};


$(document).ready(function(){
	
	screenshotPreview();
	
	
	
	/* Search */
	$('.button-search').bind('click', function() {
		url = 'index.php?route=product/search';
		var filter_name = $('input[name=\'filter_name\']').attr('value');
		if (filter_name) {
			url += '&filter_name=' + encodeURIComponent(filter_name);
		}
		location = url;
	});
	
	$('#header input[name=\'filter_name\']').keydown(function(e) {
		if (e.keyCode == 13) {
			url = 'index.php?route=product/search';
			var filter_name = $('input[name=\'filter_name\']').attr('value')
			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}
			location = url;
		}
	});
	
	
	
	/* Ajax Cart */
	/*$('#cart > .heading a').bind('click', function() {
		$('#cart').addClass('active');
		$.ajax({
			url: 'index.php?route=checkout/cart/update',
			dataType: 'json',
			success: function(json) {
				if (json['output']) {
					//$('#cart .content').html(json['output']);
					$('#cart .content, #module_cart .cart-module').html(json['output']);
				}
			}
		});
		$('#cart').bind('mouseleave', function() {
			$(this).removeClass('active');
		});
	});
	*/
	
	
	
	$('ul.menu').superfish({
		delay:       600,                            // one second delay on mouseout
		animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
		speed:       'normal',                          // faster animation speed
		autoArrows:  false,                           // disable generation of arrow mark-up
		dropShadows: false                            // disable drop shadows
	});
	
	
	
	$(".list-services a.tooltips").easyTooltip();
	$(".wishlist a.tip").easyTooltip();
	$(".compare a.tip2").easyTooltip();
	
	
	
	$('.column li a').css({paddingLeft:'16px'});
	$('.column li a').hover(function(){
		$(this).stop().animate({paddingLeft:'20px'},300, 'easeOutQuad');
	}, function(){
		$(this).stop().animate({paddingLeft:'16px'},300, 'easeOutQuad');
	});
	
	
	
	$('.box-product.box-subcat li img').hover(function(){
		$(this).stop(true,false).animate({borderTopColor: '#181818', borderLeftColor: '#181818', borderRightColor: '#181818', borderBottomColor: '#181818'}, {duration: 250});
	},function(){
		$(this).stop(true,false).animate({borderTopColor: '#dfe1e4', borderLeftColor: '#dfe1e4', borderRightColor: '#dfe1e4', borderBottomColor: '#dfe1e4'}, {duration: 250});
	});
	
	
	
	$('.jcarousel-list li a img').css({opacity:'0.3'});
	$('.jcarousel-list li a img').hover(function(){
		$(this).stop(true,false).animate({opacity:'1'}, {duration: 250});
	},function(){
		$(this).stop(true,false).animate({opacity:'0.3'}, {duration: 250});
	});
	
	
	
	$('#cart .content').hide();
	$("#cart").hover(function(){
		$('#cart .content').stop(true, true).slideDown(400);
		$.ajax({
			url: 'index.php?route=checkout/cart/update',
			dataType: 'json',
			success: function(json) {
				if (json['output']) {
					$('#cart .content').html(json['output']);
				}
			}
		});
	},
	function(){
		$('#cart .content').stop(true, true).delay(400).slideUp(300);
	});
	
	
	
	$("a[data-gal^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'facebook',slideshow:5000, autoplay_slideshow: true});
	
	
	
	// fade #back-top
	$("#back-top").hide();
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('#back-top').fadeIn();
		} else {
			$('#back-top').fadeOut();
		}
	});
	// scroll body to 0px on click
	$('#back-top a').click(function(){
		$('body,html').animate({scrollTop: 0}, 800);
		return false;
	});
	
	
	
	$('#header .links li').last().addClass('last');
	$('.breadcrumb a').last().addClass('last');
	$('.cart tr').eq(0).addClass('first');

});


$('.success span, .warning span, .attention span, .information span').live('click', function(){
	$(this).parent().fadeOut('slow', function() {
		$(this).remove();
	});
});


function addToCart(product_id) {
	$.ajax({
		url: 'index.php?route=checkout/cart/update',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['error']) {
				if (json['error']['warning']) {
					$('#notification').html('<div class="warning" style="display: none;">' + json['error']['warning'] + '<span class="close"><img src="catalog/view/theme/HDW1/image/close.png" alt="" class="close" /></span></div>');
				}
			}
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<span class="close"><img src="catalog/view/theme/HDW1/image/close.png" alt="" class="close" /></span></div>');
				$('.success').fadeIn('slow');
				$('#cart_total').html(json['total']);
				$('#module_cart .cart-module').html(json['output']);
				
				var image = $('#img_'+product_id).offset();
				if (image) {
					var cart = $('#module_cart').offset();
					$('<img src="' + $('#img_'+product_id).attr('src') + '" id="temp" style="position: absolute; top: ' + image.top + 'px; left: ' + image.left + 'px;" />').appendTo('body');
					
					params = {
						top : cart.top + 'px',
						left : cart.left + 'px',
						opacity : 0.2,
						width : $('#img_'+product_id).width(),
						height : $('#img_'+product_id).height()
					};
					
					// uncomment line below if you also want to scroll up
					//$('html, body').animate({ scrollTop: 0 }, 'slow');
					$('#temp').animate(params, 'slow', false, function(){
						$('#temp').remove();
					});
				}
			}
		}
	});
}


function removeCart(key) {
	$.ajax({
		url: 'index.php?route=checkout/cart/update',
		type: 'post',
		data: 'remove=' + key,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
			if (json['output']) {
				$('#cart_total').html(json['total']);
				//$('#cart .content').html(json['output']);
				$('#cart .content, #module_cart .cart-module').html(json['output']);
			}
		}
	});
}


function removeVoucher(key) {
	$.ajax({
		url: 'index.php?route=checkout/cart/update',
		type: 'post',
		data: 'voucher=' + key,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
			if (json['output']) {
				$('#cart_total').html(json['total']);
				//$('#cart .content').html(json['output']);
				$('#cart .content, #module_cart .cart-module').html(json['output']);
			}
		}
	});
}


function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/update',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<span class="close"><img src="catalog/view/theme/HDW1/image/close.png" alt="" class="close" /></span></div>');
				$('.success').fadeIn('slow');
				$('#wishlist_total').html(json['total']);
			}
		}
	});
}


function addToCompare(product_id) {
	$.ajax({
		url: 'index.php?route=product/compare/update',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<span class="close"><img src="catalog/view/theme/HDW1/image/close.png" alt="" class="close" /></span></div>');
				$('.success').fadeIn('slow');
				$('#compare_total').html(json['total']);
			}
		}
	});
}



(function($){
	$.fn.equalHeights=function(minHeight,maxHeight){
		tallest=(minHeight)?minHeight:0;
		
		this.each(function(){
			if($(this).height()>tallest){
				tallest=$(this).height();
			}
		});
		
		if((maxHeight)&&tallest>maxHeight){
			tallest=maxHeight;
		}
		
		return this.each(function(){
			$(this).height(tallest);
		});
	}
})(jQuery)


