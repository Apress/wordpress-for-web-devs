    <div id="footer" class="section">
	
		<p class="copyright"><?php echo '&copy; ' . date( ' Y ' ) . get_bloginfo( 'name' ); ?></p>
		<div class="contact"><?php echo wpautop( get_theme_mod( 'edu_footer_text', '' ) ); ?></div>

</div>
<?php wp_footer(); ?>
</body>
</html>