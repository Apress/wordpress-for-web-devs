jQuery(function() {
      jQuery('#slides').slidesjs({
        width: 576,
        height: 432,
        navigation: false,
		play: {
		          active: true,
		          auto: true,
		          interval: 4000,
		          swap: true,
		          pauseOnHover: true,
		          restartDelay: 2500
		       	}
      });
    });