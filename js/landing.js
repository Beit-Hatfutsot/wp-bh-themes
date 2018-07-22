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

			// Toggles slider more info content
			BH_landing.moreInfo();

		},

		/**
		 * moreInfo
		 *
		 * This function toggles slider more info content
		 * Called from init
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		moreInfo : function () {

			// Variables
			var more = $('.slider .content .more'),
				less = $('.slider .content .less');

			more.click(function() {
				// Variables
				var moreInfo = $(this).parent().parent().find('.more-info');

				// Hide more button
				$(this).toggle();
				$(this).parent().toggleClass('active');

				// Expose more info
				moreInfo.slideDown();
			});

			less.click(function() {
				// Variables
				var excerpt = $(this).parent().parent().find('.excerpt');

				// Hide more info
				$(this).parent().slideUp();

				// Expose more button
				setTimeout(function() {
					excerpt.toggleClass('active');
					excerpt.find('.more').toggle();
				}, BH_landing.params.timeout);

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

			// Variables
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

			// Variables
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