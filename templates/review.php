<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tourfic
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="tf_comments-area">

	<?php if ( have_comments() ) : ?>
		<div class="tf-comments-count-wrapper">

			<h3 class="comments-title">
				<?php
				$comments_title = apply_filters(
					'astra_comment_form_title',
					sprintf( // WPCS: XSS OK.
						/* translators: 1: number of comments */
						esc_html( _nx( 'Based on %1$s review', 'Based on %1$s reviews', get_comments_number(), 'comments title', 'tourfic' ) ),
						number_format_i18n( get_comments_number() ),
					)
				);

				echo esc_html( $comments_title );
				?>
			</h3>


		</div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" aria-label="<?php esc_attr_e( 'Comments Navigation', 'tourfic' ); ?>">
			<h3 class="screen-reader-text"><?php echo esc_html( astra_default_strings( 'string-comment-navigation-next', false ) ); ?></h3>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( astra_default_strings( 'string-comment-navigation-previous', false ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( astra_default_strings( 'string-comment-navigation-next', false ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; ?>

		<ol class="ast-comment-list">
			<?php
			wp_list_comments(
				array(
					//'callback' => 'tf_comment_callback',
					'style'    => 'ol',
					'type'      => 'comment',
					'max_depth' => 1,
				)
			);
			?>
		</ol><!-- .ast-comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" aria-label="<?php esc_attr_e( 'Comments Navigation', 'tourfic' ); ?>">
			<h3 class="screen-reader-text"><?php echo esc_html( astra_default_strings( 'string-comment-navigation-next', false ) ); ?></h3>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( astra_default_strings( 'string-comment-navigation-previous', false ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( astra_default_strings( 'string-comment-navigation-next', false ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php endif; ?>

	<?php endif; ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php echo esc_html( astra_default_strings( 'string-comment-closed', false ) ); ?></p>
	<?php endif; ?>

	<?php get_tf_review_form(); ?>

</div><!-- #comments -->
