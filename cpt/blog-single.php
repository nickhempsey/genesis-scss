
<?php

add_action( 'genesis_meta', 'bsg_single_layout_genesis_meta' );
function bsg_single_layout_genesis_meta() {
	if(is_single()) {
		add_action( 'genesis_after_header', 'bsg_blog_post_hero' );
		add_action( 'genesis_entry_footer', 'bsg_post_navigation' );
	}
}

function bsg_blog_post_hero() {

	$link = get_permalink();
	$desc = get_the_excerpt();
?>
<div class="wp-block-group pt-10 pb-5 mb-5 bg-flourish has-white-color has-gradient-primary-background-color has-text-color has-background">
	<div class="container container-small">
		<h1><?php the_title(); ?></h1>
		

		<div class="d-flex align-items-center justify-content-between">
			<?php if(!is_singular('education') && !is_singular('case_studies')) { ?>
				<p class="small mb-0">
					<?= get_the_time( 'F j, Y' ); ?> by <?=get_the_author_meta( 'display_name' ); ?>
				</p>
			<?php } ?>
			<div class="social-share">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?= $link; ?>" target="_blank" class="mr-3 text-white">
					<i class="fab fa-facebook-f"></i>
				</a>
				<a href="https://twitter.com/intent/tweet?url=<?= $link; ?>&text=<?= $desc; ?>" target="_blank" class="mr-3 text-white">
					<i class="fab fa-twitter"></i>
				</a>
				<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $link; ?>" target="_blank" class="mr-3 text-white">
					<i class="fab fa-linkedin-in"></i>
				</a>
			</div>
		</div>
	</div>
</div>
<?php
}

function bsg_post_navigation() {
	
	$justify = get_previous_post_link() ? 'justify-content-start' : 'justify-content-end';
?>
<div class="post-navigation my-5 py-5 row align-items-stretch border-top <?= $justify; ?>">
	<?php previous_post_link('<div class="post-navigation-link prev-link col-6"><span class="small text-muted">< PREVIOUS</span> %link</div>'); ?>

	<?php next_post_link('<div class="post-navigation-link next-link col-6"><span class="small text-muted">NEXT ></span> %link</div>'); ?>
</div>
<?php
}