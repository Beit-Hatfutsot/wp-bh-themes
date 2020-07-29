var $ = jQuery,
	BH_general = {

		/**
		 * params
		 */
		params : {

			page					: '',									// current page (string)
			woocommerce				: false,								// woocommerce page (true/false)

			// gallery params
			galleries				: {},
			photos_columns			: 3,
			photos_more_interval	: 12,

			window_width			: 0,									// client window width - used to maintain window resize events (int)
			breakpoint				: '',									// CSS media query breakpoint (int)
			prev_breakpoint			: '',									// Previous media query breakpoint (int)
			api						: js_globals.template_url + '/api/',
			timeout					: 400									// general timeout (int)

		},

		/**
		 * init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		init : function() {

			// jQuery extentions
			$.fn.setAllToMaxHeight = function() {
				return this.height( Math.max.apply(this, $.map(this, function(e) { return $(e).height() })) );
			}

			// set page
			BH_general.params.page = BH_general.get_page();

			// set woocommerce indication
			BH_general.params.woocommerce = BH_general.params.page && (BH_general.params.page.substring(0, 11) == 'woocommerce' || BH_general.params.page == 'shop-why-shop-with-us' || BH_general.params.page == 'shop-about');

			// woocommerce page
			if (BH_general.params.woocommerce) {
				// shop cart popup
				BH_general.shop_cart_popup();
			}

			// woocommerce shop homepage / single product page
			if (BH_general.params.page == 'woocommerce-shop-home' || BH_general.params.page == 'woocommerce' || BH_general.params.page == 'woocommerce-single-product') {
				if (BH_general.params.page == 'woocommerce-shop-home' || BH_general.params.page == 'woocommerce') {
					// woocommerce shop homepage

					// shop featured products
					BH_general.shop_featured_products();
				}
				else {
					// woocommerce single product page
					BH_general.shop_single_product();
				}

				// shop products sliders
				BH_general.shop_products_slider();
			}

			// woocommerce taxonomy archive page
			if (BH_general.params.page == 'woocommerce-tax') {
				// awpf
				BH_general.awpf();
			}

			// shop - why shop with us page
			if (BH_general.params.page == 'shop-why-shop-with-us') {
				// why shop with us banners
				BH_general.shop_wswu_banners();
			}

			// newsletter popup
			BH_general.languages_switcher();

			// newsletter popup
			BH_general.newsletter_popup();

			// faqs
			$('.faqs li .question').click(function() {
				$(this).toggleClass('expanded');
				$(this).next().next().slideToggle(BH_general.params.timeout);
			});

			// embedded video - responsive treatment
			$('.page-content').find('iframe, object, embed').each(function() {
				if ( $(this).attr('name') == 'chekout_frame' || $(this).attr('name') == 'pelecard_frame' || $(this).hasClass('no-flex') )
					return;
					
				var src = $(this).attr('src');
				
				$(this).wrap("<div class='flex-video'></div>");
				
				// add some usefull attributes
				if (src.indexOf('youtube.com') >= 0) {
					src = src.concat('/?showinfo=0&autohide=1&rel=0&wmode=transparent');
					$(this).attr('src', src);
					$(this).attr('wmode', 'Opaque');
				}
			});

			// Gallery
			if (js_globals.galleries.length > 0) {
				var image_galleries = $.parseJSON(js_globals.galleries);

				$.each( image_galleries, function(id, images) {
					// Init gallery
					BH_general.params.galleries[id] = {
						images			: images,
						active_photos	: 0,
						active_column	: 0
					};

					BH_general.lazyLoad(id, BH_general.params.galleries[id]);

					// Bind click event to gallery 'load more' btn
					$('.'+id).next('.load-more').bind('click', function() {
						BH_general.lazyLoad(id, BH_general.params.galleries[id]);
					});

					// PhotoSwipe
					BH_general.initPhotoSwipeFromDOM('.'+id);
				});
			}

			// images facebook share
			$('img.fb-share').each(function() {
				var url = $(this).attr('src'),
					fbShareCode = '<div class="fb-share-button" data-href="' + url + '" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=' + url + '&amp;src=sdkpreparse">Share</a></div>';

				$(this).wrap('<div class="fb-share-wrap"></div>');
				$(this).after(fbShareCode);
			});

			// footer menu
			BH_general.footer_menu();

		},

		/**
		 * get_page
		 *
		 * Get client current page
		 * Called from init
		 *
		 * @param	N/A
		 * @return	(string)
		 */
		get_page : function() {

			var classes = $('body').attr('class').split(' ');

			if ( $.inArray('woocommerce', classes) >= 0 ) {
				// woocommerce page
				var search_term = "tax-",
					search = new RegExp(search_term , "i"),
					arr = $.grep(classes, function (value) {
						return search.test(value);
					});

				if (arr.length) {
					// woocommerce taxonomy archive page
					return 'woocommerce-tax';
				}
				else if ( $.inArray('search', classes) >= 0 ) {
					// woocommerce search archive page
					return 'woocommerce-search';
				}
				else if ( $.inArray('single-product', classes) >= 0 ) {
					// woocommerce single product page
					return 'woocommerce-single-product';
				}
				else if ( $.inArray('archive', classes) >= 0 ) {
					// woocommerce shop homepage
					return 'woocommerce-shop-home';
				}
				else if ( $.inArray('page-template-shop-about', classes) >= 0 ) {
					// shop - about page
					return 'shop-about';
				}
				else if ( $.inArray('page-template-shop-why-shop-with-us', classes) >= 0 ) {
					// shop - why shop with us page
					return 'shop-why-shop-with-us';
				}
				else {
					// other woocommerce page
					return 'woocommerce';
				}
			}
			else {
				return '';
			}

		},

		/**
		 * shop_cart_popup
		 *
		 * Maintain functionality for open/close shop cart popup
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		shop_cart_popup : function() {

			var shop_cart_popup_wrapper		= $('header .shop-cart-header-mid-popup'),
				shop_cart_popup_btn			= shop_cart_popup_wrapper.children('.shop-cart-popup-btn'),
				shop_cart_popup_content		= shop_cart_popup_wrapper.children('.shop-cart-popup-content');

			// bind click events
			shop_cart_popup_btn.click(function() {
				shop_cart_popup_content.toggle();
			});

		},
		
		/**
		 * shop_featured_products
		 *
		 * Maintain functionality for shop featured products
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		shop_featured_products : function() {

			$('.featured-product-item').each(function() {
				var item		= $(this),
					image		= item.find('.product-item-image a .image'),
					image_hover	= item.find('.product-item-image a .image-hover');

				item.hover(function() {
					if (image_hover.length > 0) {
						image.hide();
						image_hover.show();
					}

					item.addClass('active');
				}, function() {
					if (image_hover.length > 0) {
						image.show();
						image_hover.hide();
					}

					item.removeClass('active');
				});
			});

		},

		/**
		 * shop_single_product
		 *
		 * Initialize single product gallery slider and manipulate images display
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		shop_single_product : function() {

			// set gallery margin-top based on product title placeholder height
			$('.product-images').css('margin-top', $('.product-title').outerHeight(true)*(-1));

			// single product gallery slider
			BH_general.single_product_gallery_slider();

			// expose products images
			$('.product-images').css('height', 'auto');

			// add to cart
			BH_general.single_product_add_to_cart();

		},

		/**
		 * single_product_gallery_slider
		 *
		 * Initialize single product gallery slider
		 * Called from shop_single_product
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		single_product_gallery_slider : function() {

			var slideshow = $('.product-gallery-slider-carousel');

			slideshow.cycle();

		},

		/**
		 * single_product_add_to_cart
		 *
		 * Add to cart form
		 * Called from shop_single_product
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		single_product_add_to_cart : function() {

			var qty_select	= $('#qty-select'),
				lis			= qty_select.find('li'),
				button		= $('.add-to-cart a.button');

			// quantity button toggle
			qty_select.click(function() {
				var collapsed = $(this).hasClass('collapsed') ? true : false;

				if (collapsed) {
					$(this).removeClass('collapsed');
				}
				else {
					$(this).addClass('collapsed');
				}
			});

			// quantity button select
			lis.click(function() {
				var current	= $(this).hasClass('current') ? true : false;

				if (current)
					return;

				// remove current class from all select options
				lis.removeClass('current');

				// add current class
				$(this).addClass('current');

				// set current amount
				qty_select.attr('data-content', $(this).text());

				// modify add to cart button quantity
				button.attr('data-quantity', $(this).text());
				button.data('quantity', $(this).text());
			});

			// add to cart button
			button.click(function() {
				qty_select.removeClass('collapsed');
			});

		},

		/**
		 * shop_products_slider
		 *
		 * Initialize products slider
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		shop_products_slider : function() {

			var slideshow = $('.products-slider-carousel');

			if (slideshow.length) {
				slideshow.cycle();
				$('.products-slider').fadeIn(BH_general.params.timeout);
			}

		},

		/**
		 * awpf
		 *
		 * Add ons for AWPF
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		awpf : function() {

			// product filters toggle
			$('.awpf-filters-toggle').click(function() {
				var active = $(this).hasClass('collapsed') ? true : false;

				if (active) {
					$(this).removeClass('collapsed');
				}
				else {
					$(this).addClass('collapsed');
				}
			});

			// internal link button
			$('.awpf-filter .goto-products').click(function() {
				var header_height = $('header').height();
				$('html, body').animate({scrollTop: $('.products-list').offset().top - header_height }, 'slow');
			});

		},

		/**
		 * shop_wswu_banners
		 *
		 * Display why shop with us banners
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		shop_wswu_banners : function() {

			var banners		= $('.col-shop-wswu').length,
				fadeSpeed	= 1000,		// fadeIn time
				delayTime	= 1250,		// delay before transform banner to active
				gap			= 0;		// gap between banners exposure

			for (var i=0 ; i<banners ; i++) {
				setTimeout(function(index) {
					$('.col-shop-wswu:eq('+index+')').find('.image-wrapper').fadeIn(fadeSpeed);
				}, i*(fadeSpeed+delayTime+gap), i);
				
				setTimeout(function(index) {
					$('.col-shop-wswu:eq('+index+')').addClass('active');
				}, i*(fadeSpeed+delayTime+gap)+fadeSpeed+delayTime, i);
			}

		},

		/**
		 * languages_switcher
		 *
		 * Maintain functionality for open/close languages switcher
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		languages_switcher : function() {

			var languages_switcher_wrapper	= $('.header-mid-elements .languages-switcher'),
				languages_switcher_btn		= languages_switcher_wrapper.children('.languages-switcher-btn'),
				languages_switcher_content	= languages_switcher_wrapper.children('.languages-switcher-content');

			// bind click event
			languages_switcher_btn.click(function() {
				$(this).next().toggle();
			});

		},

		/**
		 * newsletter_popup
		 *
		 * Maintain functionality for open/close newsletter popup
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		newsletter_popup : function() {
			
			var newsletter_popup_wrapper	= $('header .newsletter-popup'),
				newsletter_popup_btn		= newsletter_popup_wrapper.children('.newsletter-popup-btn'),
				newsletter_popup_content	= newsletter_popup_wrapper.children('.newsletter-popup-content'),
				newsletter_popup_close		= newsletter_popup_wrapper.find('.close-btn');
			
			// bind click event
			newsletter_popup_btn.click(function() {
				$(this).next().toggle();
				$(this).children('a').toggleClass('active');
				
				// reset newsletter popup expiry
				BH_general.set_newsletter_popup('set');
			});
			
			newsletter_popup_close.click(function() {
				newsletter_popup_content.hide();
				newsletter_popup_btn.children('a').removeClass('active');
				
				// reset newsletter popup expiry
				BH_general.set_newsletter_popup('set');
			});
			
			// popup newsletter
			setTimeout(function() {
				BH_general.set_newsletter_popup('open');
			}, 30000);
			
		},
		
		/**
		 * set_newsletter_popup
		 *
		 * Set expiry for newsletter popup cookie using AJAX
		 * Called from newsletter_popup
		 *
		 * @param	action (string) set/open
		 * @return	(bool)
		 */
		set_newsletter_popup : function(action) {
			
			var newsletter_popup_wrapper	= $('header .newsletter-popup'),
				newsletter_popup_btn		= newsletter_popup_wrapper.children('.newsletter-popup-btn'),
				newsletter_popup_content	= newsletter_popup_wrapper.children('.newsletter-popup-content');
			
			$.ajax({
				
				url		: BH_general.params.api + 'newsletter-popup.php',
				type	: 'POST',
				data	: {
					action		: action
				},
				error: function() {
					return false;
				},
				success: function(result) {
					var r = JSON.parse(result);
					if (r.status == 0) {
						if (action == 'open' && r.operation == 'popup' && !newsletter_popup_btn.children('a').hasClass('active')) {
							newsletter_popup_content.show();
							newsletter_popup_btn.children('a').addClass('active');
						}
						
						return true;
					}
					
					return false;
				}
				
			});
			
		},
		
		/**
		 * lazyLoad
		 *
		 * Load gallery images
		 *
		 * @param	id (int) Gallery ID
		 * @param	gallery (obj) Gallery object
		 * @return	N/A
		 */
		lazyLoad : function (id, gallery) {

			var index, j;

			for (index=gallery['active_photos'], j=0 ; j<BH_general.params.photos_more_interval && gallery['images'].length>index ; index++, j++) {
				// expose photo
				var photoItem =
					'<figure class="gallery-item" data-index="' + index + '" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">' +
						'<a href="' + gallery['images'][index]['url'] + '" itemprop="contentUrl">' +
							'<img class="no-border" src="' + gallery['images'][index]['url'] + '" itemprop="thumbnail" alt="' + gallery['images'][index]['alt'] + '" />' +
						'</a>' +
						'<figcaption itemprop="caption description">' + gallery['images'][index]['title'] + '<br><span>' + gallery['images'][index]['caption'] +  '</span></figcaption>' +
					'</figure>'
					;

				$(photoItem).appendTo( $('.'+id+' .col' + gallery['active_column']%BH_general.params.photos_columns) );

				// Update active column
				gallery['active_column'] = gallery['active_column']%BH_general.params.photos_columns + 1;
			}

			if ( index == gallery['images'].length ) {
				// hide more btn
				$('.'+id).next('.load-more').css('display', 'none');
			} else {
				// expose more btn
				$('.'+id).next('.load-more').css('display', 'block');
			}

			// Update active photos
			gallery['active_photos'] += j;

		},

		/**
		 * initPhotoSwipeFromDOM
		 *
		 * PhotoSwipe init
		 *
		 * @param	gallerySelector (string)
		 * @return	N/A
		 */
		initPhotoSwipeFromDOM : function(gallerySelector) {

			// parse slide data (url, title, size ...) from DOM elements
			// (children of gallerySelector)
			var parseThumbnailElements = function(el) {
				var galleryCols = el.children('.gallery-col'),
					items = [];

				$(galleryCols).each(function() {
					var galleryColItems = $(this).children('.gallery-item');

					$(galleryColItems).each(function() {
						var index = $(this).attr('data-index'),
							link = $(this).children('a'),
							caption = $(this).children('figcaption'),
							img = link.children('img');

						// create slide object
						var item = {
							src: link.attr('href'),
							w: img[0].naturalWidth,
							h: img[0].naturalHeight,
							msrc: img.attr('src')
						};

						if (caption) {
							item.title = caption.html();
						}

						item.el = $(this)[0]; // save link to element for getThumbBoundsFn

						items[index] = item;
					});
				});

				return items;
			};

			// triggers when user clicks on thumbnail
			var onThumbnailsClick = function(e) {
				e = e || window.event;
				e.preventDefault ? e.preventDefault() : e.returnValue = false;

				var eTarget = e.target || e.srcElement;

				// find root element of slide
				var clickedListItem = $(eTarget).parent().parent();

				if(!clickedListItem) {
					return;
				}

				// find index of clicked item
				var clickedGallery = clickedListItem.parent().parent(),
					index = clickedListItem.attr('data-index');

				if(clickedGallery && index >= 0) {
					// open PhotoSwipe if valid index found
					openPhotoSwipe( index, clickedGallery );
				}

				return false;
			};

			var openPhotoSwipe = function(index, galleryElement) {
				var pswpElement = document.querySelectorAll('.pswp')[0],
					gallery,
					options,
					items;

				items = parseThumbnailElements(galleryElement);

				// define options (if needed)
				options = {

					// define gallery index (for URL)
					galleryUID: galleryElement.attr('data-pswp-uid'),

					getThumbBoundsFn: function(index) {
						// See Options -> getThumbBoundsFn section of documentation for more info
						var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
						pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
						rect = thumbnail.getBoundingClientRect(); 

						return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
					},

					index: parseInt(index, 10)

				};

				// exit if index not found
				if( isNaN(options.index) ) {
					return;
				}

				// Pass data to PhotoSwipe and initialize it
				gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
				gallery.init();
			};

			// loop through all gallery elements and bind events
			var galleryElements = document.querySelectorAll( gallerySelector );

			for(var i = 0, l = galleryElements.length; i < l; i++) {
				galleryElements[i].setAttribute('data-pswp-uid', i+1);
				galleryElements[i].onclick = onThumbnailsClick;
			}

		},

		/**
		 * footer_menu
		 *
		 * Footer menu functionality
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		footer_menu : function() {

			// copy parent items with href attribute into their sub menu
			$('.footer-menu li.menu-item-has-children').each(function() {
				if ($(this).children('a').attr('href') && $(this).children('.sub-menu').length) {
					// create cloned element
					var li = $(this).clone();

					// remove id attribute, menu-item-has-children class and sub menu from cloned element
					li.removeAttr('id');
					li.removeClass('menu-item-has-children');
					li.children('.sub-menu').remove();

					// append cloned element to original sub-menu
					li.prependTo($(this).children('.sub-menu'));

					// remove href attribute from original element
					$(this).children('a').removeAttr('href');
				}
			});

			// bind click event to footer menu elements
			$('.footer-menu li.menu-item-has-children > .item-before').bind('click', BH_general.footer_sub_menu_toggle);
			$('.footer-menu li.menu-item-has-children > a').bind('click', BH_general.footer_sub_menu_toggle);

			// bind click event to mobile menu button
			$('.mobile-menu-btn a').click(function() {
				var header_height = $('header').height();
				$('html, body').animate({scrollTop: $('.footer-menu').offset().top - header_height }, 'slow');
			});

		},

		/**
		 * footer_sub_menu_toggle
		 *
		 * Toggle footer item sub menu
		 * Called from footer_menu
		 *
		 * @param	event (object)
		 * @return	N/A
		 */
		footer_sub_menu_toggle : function(event) {

			var current = event.currentTarget,
				li = $(current).parent(),
				mobile = $('.footer-menu').hasClass('mobile') ? true : false,
				active = li.hasClass('collapsed') ? true : false;

			if (mobile || li.parent().hasClass('sub-menu')) {
				// prevent closing top level footer sub menus for desktop resolution
				li.parent().find('li.menu-item-has-children').removeClass('collapsed');
			}

			if (active) {
				li.removeClass('collapsed').find('li.menu-item-has-children').removeClass('collapsed');
			}
			else {
				li.addClass('collapsed');
			}

		},

		/**
		 * breakpoint_refreshValue
		 *
		 * Set window breakpoint values
		 * Called from loaded/alignments
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		breakpoint_refreshValue : function () {

			var new_breakpoint = window.getComputedStyle(
				document.querySelector('body'), ':before'
			).getPropertyValue('content').replace(/\"/g, '').replace(/\'/g, '');

			BH_general.params.prev_breakpoint = BH_general.params.breakpoint;
			BH_general.params.breakpoint = new_breakpoint;

		},

		/**
		 * set_content_top
		 *
		 * Adjust page content margin-top according to header height
		 * Called from loaded/alignments
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		set_content_top : function() {

			var header_height = $('header').height();

			$('.main-wrapper, .page-content').css('margin-top', header_height + 'px');

		},

		/**
		 * footer_links
		 *
		 * Adjust footer links height
		 * Called from loaded/alignments
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		footer_links : function() {

			// footer alignment
			$('.footer-links .link-box .link').height('auto').setAllToMaxHeight();

		},

		/**
		 * shop_single_wswu_banner
		 *
		 * Display Why Shop With Us banner
		 * alled from loaded/alignments
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		shop_single_wswu_banner : function() {

			var banner	= $('.wswu-banner'),
				content	= banner.children('.wswu-content'),
				height	= content.outerHeight();

			banner.height(height);
			banner.children('.item-after').css({'border-top-width': height/2, 'border-bottom-width': height/2});

			// expose banner
			banner.css('visibility', 'visible');

		},

		show_recently_viewed : function() {
			
			$('.recently-products-slider-placeholder').hide();
			
			$.ajax({
				
				url		: BH_general.params.api + 'recently-viewed.php',
				type	: 'POST',
				data	: {
					action		: 'show'
				},
				error: function() {
					return false;
				},
				success: function(result) {
					if (!result.length)
						return false;
						
					BH_general.recently_viewed_content(result);
					$('.recently-products-slider-placeholder').fadeIn(BH_general.params.timeout);
					
					return true;
				}
				
			});
			
		},
		
		add_recently_viewed : function() {
			
			// find post ID (presented in body className as 'postid-x')
			var postid = '';
			
			var classList = $('body').attr('class').split(/\s+/);
			$.each(classList, function(index, item) {
				if (item.indexOf('postid') >= 0) {
					postid = item.substr(item.indexOf('-') + 1);
				}
			});
			
			if (!postid)
				return;
				
			$('.recently-products-slider-placeholder').hide();
			
			$.ajax({
				
				url		: BH_general.params.api + 'recently-viewed.php',
				type	: 'POST',
				data	: {
					action		: 'add',
					postid		: postid
				},
				error: function() {
					return false;
				},
				success: function(result) {
					if (!result.length)
						return false;
						
					BH_general.recently_viewed_content(result);
					$('.recently-products-slider-placeholder').fadeIn(BH_general.params.timeout);
					
					return true;
				}
				
			});
			
		},
		
		remove_recently_viewed : function(item) {
			
			var postid = item.attr('data-postid');
			
			if (!postid)
				return;
				
			$('.recently-products-slider-placeholder').fadeOut(BH_general.params.timeout);
			
			$.ajax({
				
				url		: BH_general.params.api + 'recently-viewed.php',
				type	: 'POST',
				data	: {
					action		: 'remove',
					postid		: postid
				},
				error: function() {
					return false;
				},
				success: function(result) {
					var slideshow = $('.recently-products-slider');
					
					// destroy slideshow
					slideshow.cycle('destroy');
					
					if (!result.length) {
						// empty result
						slideshow.html('');
						
						return false;
					}
					else {
						BH_general.recently_viewed_content(result);
						$('.recently-products-slider-placeholder').fadeIn(BH_general.params.timeout);
						
						return true;
					}
				}
				
			});
			
		},
		
		recently_viewed_content : function(content) {
			
			var slideshow = $('.recently-products-slider');
			
			var	regex = /<li/gm,
				visible_products = content.match(regex);
				
			visible_products = (visible_products) ? visible_products.length : 0;
			
			if (visible_products <= 7) {
				$('#recently-products-slider-prev, #recently-products-slider-next').css('visibility', 'hidden');
			}
			else {
				visible_products = 7;
				$('#recently-products-slider-prev, #recently-products-slider-next').css('visibility', 'visible');
			}
			
			slideshow.attr('data-cycle-carousel-visible', visible_products);
			slideshow.html(content);
			slideshow.cycle();
			
			// recently viewed products - remove product from recently viewed
			$('.recently-products-slider').on('click', '.glyphicon-remove', function(e) {
				BH_general.remove_recently_viewed($(this).parent());
				
				return false;
			});
			
		},
		
		/**
		 * loaded
		 *
		 * Called by $(window).load event
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		loaded : function() {

			BH_general.params.window_width = $(window).width();
			$(window).resize(function() {
				if ( BH_general.params.window_width != $(window).width() ) {
					BH_general.alignments();
					BH_general.params.window_width = $(window).width();
				}
			});

			BH_general.alignments();

		},

		/**
		 * alignments
		 *
		 * Align components after window resize event
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		alignments : function() {
			
			// set window breakpoint values
			BH_general.breakpoint_refreshValue();

			// set content top
			BH_general.set_content_top();

			// footer links
			BH_general.footer_links();

			// close all footer sub menus
			$('.footer-menu li.menu-item-has-children').removeClass('collapsed');

			// woocommerce single product page / shop about
			if (BH_general.params.page == 'woocommerce-single-product' || BH_general.params.page == 'shop-about') {
				// wswu banner
				BH_general.shop_single_wswu_banner();
			}

			if (BH_general.params.breakpoint <= 767) {
				// width <= 767
				$('.footer-menu').addClass('mobile');
			}
			else {
				// width > 767
				$('.footer-menu').removeClass('mobile');
				// collapse top level footer sub menus
				$('.footer-menu > ul > li.menu-item-has-children').addClass('collapsed');
			}

			// reinit products slider
			if (BH_general.params.page == 'woocommerce-shop-home' || BH_general.params.page == 'woocommerce' || BH_general.params.page == 'woocommerce-single-product') {
				if (BH_general.params.prev_breakpoint && (BH_general.params.prev_breakpoint <= 991 && BH_general.params.breakpoint >= 1199 || BH_general.params.prev_breakpoint >= 1199 && BH_general.params.breakpoint <= 991)) {
					$('.products-slider-carousel').cycle('reinit');
				}
			}

			// reinit single product main image zoom
			if (BH_general.params.page == 'woocommerce-single-product') {
				// set gallery margin-top based on product title placeholder height
				$('.product-images').css('margin-top', $('.product-title').outerHeight(true)*(-1));

				// Remove old zoom container
				$('.zoomContainer').remove();

				// reinit ez
				$('#gallery-main-item-img').elevateZoom({
					zoomType			: 'inner',
					cursor				: 'crosshair',
					zoomWindowFadeIn	: 500,
					zoomWindowFadeOut	: 500,
					easing				: true,
					gallery				: 'gallery-navigator',
					galleryActiveClass	: 'active'
				});

				var active = $('#gallery-navigator a.active');

				if (active.length) {
					// swap image in case of window resize in order to prevent reset to first image in gallery
					// use timeout function in order to give elevateZoom some time in order to reinitialize before swap image
					setTimeout(function() {
						var ez = $('#gallery-main-item-img').data('elevateZoom');
						ez.swaptheimage(active.attr('data-image'), active.attr('data-zoom-image'));
					}, 100);
				}
			}

			// reinit single product gallery slider
			if (BH_general.params.page == 'woocommerce-single-product') {
				if (BH_general.params.prev_breakpoint &&
				   (BH_general.params.prev_breakpoint <= 767 && BH_general.params.breakpoint >= 991 ||
				   	BH_general.params.prev_breakpoint >= 991 && BH_general.params.breakpoint <= 767 ||
				   	BH_general.params.prev_breakpoint <= 480 && BH_general.params.breakpoint >= 767 ||
				   	BH_general.params.prev_breakpoint >= 767 && BH_general.params.breakpoint <= 480)) {
					$('.product-gallery-slider-carousel').cycle('reinit');
				}
			}

		}

	};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());

$(BH_general.init);
$(window).load(BH_general.loaded);