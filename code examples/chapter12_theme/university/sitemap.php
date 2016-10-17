<?php
/*
Template Name: Sitemap
*/
?>

<?php get_header(); ?>
<div id="content" class="section">
	
	<h2>All Pages</h2>
    <ul class="nobullet">
        <?php wp_list_pages("post_status=publish,private&title_li=&sort_by=menu-order"); ?>    
    </ul>
	
</div> <!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>