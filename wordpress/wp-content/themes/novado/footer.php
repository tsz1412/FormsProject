<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>

	</div><!-- #content -->
    <?php get_template_part('template-parts/footers/footer-1') ?>
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>