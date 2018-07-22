var $ = jQuery,
	BH_tickets = {

		/**
		 * params
		 */
		params : {},

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

		},

		/**
		 * ticketnet_purchase_link
		 *
		 * Display Ticketnet purchase link including Google Analytics client ID
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		ticketnet_purchase_link : function(link) {

			window.open(link + '&googleCid=' + _BH_GA_cid, 'Tickets Purchase', 'width=900,height=550');

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

			BH_tickets.alignments();

		},

		/**
		 * alignments
		 *
		 * Align components after window resize event
		 *
		 * @param	N/A
		 * @return	N/A
		 */
		alignments : function() {}

	};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());

$(BH_tickets.init);
$(window).load(BH_tickets.loaded);