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

			// video
			BH_landing.video();

			// visit info
			BH_landing.visitInfo();

			// google maps
			BH_landing.googleMaps();

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
		 * visitInfo
		 *
		 * Called from init
		 *
		 * @param   N/A
		 * @return  N/A
		 */
		visitInfo : function() {

			// vars
			var infoTitles = $('.visit-info').find('.title'),
				map = $('.visit-info').find('.map-wrap');

			infoTitles.on('click', function() {
				// vars
				var title = $(this),
					info = title.next('.info');

				// toggle title
				title.toggleClass('open');

				// toggle info
				info.toggleClass('exposed');

				// toggle map
				if (title.hasClass('map')) {
					map.toggleClass('exposed');
				}

			});

		},

		/**
		 * googleMaps
		 *
		 * Called from init
		 *
		 * @param   N/A
		 * @return  N/A
		 */
		googleMaps : function() {

			if ( typeof googleMapsData !== 'undefined' && typeof googleMapsData._googleMapsApi !== 'undefined' ) {
				$('.acf-map').each(function() {

					// vars
					var map = BH_landing.initMap($(this));

				});
			}

		},

		/**
		* initMap
		*
		* Renders a Google Map onto the selected jQuery element
		*
		* @param    $el (object) The jQuery element
		* @return   (object) The map instance
		*/
		initMap : function($el) {

			// find marker elements within map
			var $markers = $el.find('.marker');

			// create gerenic map
			var mapArgs = {
				zoom: $el.data('zoom') || 16,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map($el[0], mapArgs);

			// add markers
			map.markers = [];
			$markers.each(function() {
				BH_landing.initMarker($(this), map);
			});

			// center map based on markers
			BH_landing.centerMap(map);

			// return
			return map;

		},

		/**
		* initMarker
		*
		* Creates a marker for the given jQuery element and map
		*
		* @param    $el (object) The jQuery element
		* @param    map (object) The map instance
		* @return   N/A
		*/
		initMarker : function($marker, map) {

			// get position from marker
			var lat = $marker.data('lat');
			var lng = $marker.data('lng');
			var latLng = {
				lat: parseFloat( lat ),
				lng: parseFloat( lng )
			};

			// create marker instance
			var marker = new google.maps.Marker({
				position: latLng,
				map: map
			});

			// append to reference for later use
			map.markers.push(marker);

			// if marker contains HTML, add it to an infoWindow
			if ($marker.html()) {
				// create info window
				var infowindow = new google.maps.InfoWindow({
					content: $marker.html()
				});

				// show info window when marker is clicked
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, marker);
				});
			}

		},

		/**
		* centerMap
		*
		* Centers the map showing all markers in view
		*
		* @param    map (object) The map instance
		* @return   N/A
		*/
		centerMap : function(map) {

			// create map boundaries from all map markers
			var bounds = new google.maps.LatLngBounds();

			map.markers.forEach(function( marker ){
				bounds.extend({
					lat: marker.position.lat(),
					lng: marker.position.lng()
				});
			});

			// single marker
			if (map.markers.length == 1) {
				map.setCenter( bounds.getCenter() );

			// multiple markers
			} else {
				map.fitBounds(bounds);
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

			if (slideshows.length) {
				BH_landing.params.interval = setTimeout(function() {
					slideshows.cycle('next');
					BH_landing.loopSlideshows();
				}, 5000);
			}

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

			// set window breakpoint values
			BH_landing.breakpoint_refreshValue();

			// vars
			var slideshows = $('.cycle-slideshow');

			if (BH_landing.params.interval !== '') {
				clearTimeout(BH_landing.params.interval);
			}

			// reinit slideshows
			if (slideshows.length) {
				slideshows.cycle('reinit');

				// Loop slideshows
				BH_landing.loopSlideshows();
			}

		}

	};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());

$(BH_landing.init);
$(window).load(BH_landing.loaded);