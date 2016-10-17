jQuery(document).ready(function($) {
	wp.customize('edu_footer_text', function( value ) {
        value.bind(function(to) {
            $('#footer .contact').html( to );
        });
    });
});