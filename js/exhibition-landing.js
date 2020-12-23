var $ = jQuery,
	BH_landing = {

		/**
		 * params
		 */
		params : {

			window_width			: 0,			// Client window width - used to maintain window resize events (int)
			breakpoint				: '',			// CSS media query breakpoint (int)
			prev_breakpoint			: '',			// Previous media query breakpoint (int)
			timeout					: 400,			// General timeout (int)
			interval				: ''			// Receives the setTimeout result for the slideshow presentation

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

			// video
			BH_landing.video();

		},

		/**
		 * video
		 *
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		video : function () {

			// responsive video
			BH_landing.videoResponsive();

			// video click event
			$('.video-poster').on('click', function() {
				BH_landing.videoClicked($(this));
			});

			// more info toggle
			BH_landing.videoMoreInfo();

		},

		/**
		 * videoResponsive
		 *
		 * Called from video
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		videoResponsive : function () {

			$('.landing-wrapper').find('iframe, object, embed').each(function() {
				if ( $(this).hasClass('no-flex') )
					return;

				// vars
				var container = $(this).closest('.video-single'),
					id = container.data('video');

				$(this).wrap("<div class='flex-video'></div>");
				$('<button class="video-poster" style="background-image: url(\'https://i.ytimg.com/vi/' + id + '/maxresdefault.jpg\');""></button>').appendTo($(this).parent());
			});

		},

		/**
		 * videoClicked
		 *
		 * Called from video
		 *
		 * @param	el (jQuery)
		 * @return	N/A
		 */
		videoClicked : function (el) {

			// vars
			var container = el.closest('.video-single'),
				id = container.data('video'),
				iframe = container.find('iframe');

			if (container.hasClass('active'))
				return;

			container.addClass('active');

			// build video src
			var src = 'https://www.youtube.com/embed/' + id + '/?autoplay=1&showinfo=0&rel=0&modestbranding=1&cc_load_policy=1&origin=' + window.location.origin + '&wmode=transparent';

			iframe.attr('src', src);
			iframe.attr('wmode', 'Opaque');

		},

		/**
		 * videoMoreInfo
		 *
		 * Called from video
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		videoMoreInfo : function () {

			$('.more-info').click(function() {
				// vars
				current = $(this).closest('.content-wrap');

				current.toggleClass('open');
			});

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

			BH_landing.params.prev_breakpoint = BH_landing.params.breakpoint;
			BH_landing.params.breakpoint = new_breakpoint;

		},

		/**
		 * loopSlideshows
		 *
		 * This function transitions the slideshow to the next slide in an infinite loop
		 * Called from loaded/alignments
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		loopSlideshows : function () {

			// vars
			var slideshows = $('.cycle-slideshow');

			BH_landing.params.interval = setTimeout(function() {
				slideshows.cycle('next');
				BH_landing.loopSlideshows();
			}, 5000);

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

			BH_landing.params.window_width = $(window).width();
			$(window).resize(function() {
				if ( BH_landing.params.window_width != $(window).width() ) {
					BH_landing.alignments();
					BH_landing.params.window_width = $(window).width();
				}
			});

			BH_landing.alignments();

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

			// Set window breakpoint values
			BH_landing.breakpoint_refreshValue();

			// vars
			var slideshows = $('.cycle-slideshow');

			if (BH_landing.params.interval !== '') {
				clearTimeout(BH_landing.params.interval);
			}

			// Reinit slideshows
			slideshows.cycle('reinit');

			// Loop slideshows
			BH_landing.loopSlideshows();

		}

	};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());

$(BH_landing.init);
$(window).load(BH_landing.loaded);