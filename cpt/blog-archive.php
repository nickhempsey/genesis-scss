<?php

add_action( 'genesis_meta', 'bsg_archive_layout_genesis_meta' );
function bsg_archive_layout_genesis_meta() {
	if(
		is_home() || is_category()
		|| is_tag() || is_search() || is_page('blog')
		&& !is_tax(array('faq_topic'))
		&& !is_post_type_archive(array('faq', 'reviews'))
	) {
		add_action( 'genesis_after_header', 'bsg_blog_hero' );
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'bsg_page_blog' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' ,11 ); // force full width layout
		remove_filter( 'genesis_attr-content-sidebar-wrap', 'bsg_add_markup_class' ); // remove .row
		remove_filter( 'genesis_attr-content', 'bsg_add_markup_class' ); // remove .col-* classes from .content
	}
}

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


function bsg_blog_archive_article($post = '') {
	if(!$post) {
		global $post;
	} else {
		$post = $post;
	}
	$postID = $post->ID;
	if(has_post_thumbnail( $postID )) {
		$image = wp_get_attachment_image(get_post_thumbnail_id($postID), 'blog', array( 'class' => 'card-img-top'));
	} else {
		$image = '<img src="http://via.placeholder.com/400x260" alt="Placeholder" />';
	}
	?>
	<article <?php post_class('col-md-4 col-sm-6 mb-4'); ?>>
		<div class="card article-card h-100">

			<a href="<?php echo get_permalink($postID); ?>" class="card-img-top">
				<?php echo $image; ?>
			</a>
			
			<div class="card-body">
				<h4 class="">
					<a href="<?php echo get_permalink($postID); ?>">
						<?php echo get_the_title($postID); ?>
					</a>
				</h4>
				
				<p class="small text-muted">
					<?= get_the_time( 'F j, Y' ); ?> by <?=get_the_author_meta( 'display_name' ); ?>
				</p>
				
				<?php echo get_the_excerpt( $postID ); ?>


				<?php
					$categories = get_the_terms(get_the_ID(), 'category');

				?>
				
			</div>

			<div class="card-footer d-flex align-items-center justify-content-between">
				<div class="">
					<?php
					$term_obj_list = get_the_terms( $postID, 'category' );
    					$terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
					echo '<span class="small text-muted"><i class="far fa-archive"></i> '.$terms_string.'</span>';
					?>
				</div>
				<a href="<?php echo get_permalink($postID); ?>">
					<i class="far fa-lg fa-long-arrow-right"></i>
				</a>
			</div>
		</div>
	</article>
	<?php
}


function bsg_archive_post_loop() {
  global $post;
    bsg_blog_archive_article();
}


function bsg_blog_hero() {
	?>
	<div class="wp-block-group pt-5 bg-flourish has-white-color has-gradient-primary-background-color has-text-color has-background">
		<div class="wp-block-group__inner-container">
			<div class="wp-block-columns mt-5 pt-5 container">
				<div class="wp-block-column pb-5" style="flex-basis:60%">
					<h1>Blog</h1>
				</div>
			</div>
		</div>
	</div>
	<?php
}

function bsg_custom_loop() {
	
  if ( have_posts() ) :
		do_action( 'genesis_before_while' );

        echo '<div class=" row d-flex align-items-stretch mb-5" style="clear:both;">';

    	while ( have_posts() ) : the_post();

    		do_action( 'genesis_before_entry' );

  			bsg_archive_post_loop();

  			do_action( 'genesis_after_entry' );

		endwhile; //* end of one post

        echo '</div>';
		do_action( 'genesis_after_endwhile' );
	else : //* if no posts exist
		do_action( 'genesis_loop_else' );
	endif; //* end loop
}


function bsg_home_blog() {
    if(is_front_page()) {

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
        );

        $posts = new WP_Query($args);

        if($posts->have_posts()) {

            $count = 0;
            echo '<div class="container my-5">';
                echo '<h3 class="section-title mb-3">New Articles</h3>';

                echo '<div class="row d-flex">';

                    while($posts->have_posts()) {
                        $posts->the_post();

                        bsg_blog_archive_article();

                    }
                echo '</div>';

                echo '<div class="text-center row container"><a href="/blog" class="mx-auto btn btn-primary">View More Articles</a></div>';
            echo '</div>'; // End container
        }

    }

}


function bsg_page_blog() {
	$queried_object = get_queried_object();
	//echo '<pre>'.print_r($queried_object, true).'</pre>';

	$shortcode = '[ajax_load_more id="blogPosts" container_type="div"  post_type="post" posts_per_page="9" images_loaded="true" button_label="<span>More Articles</span>" button_loading_label="<span>Loading...</span>" no_results_text="Sorry, no articles were found. " theme_repeater="blog.php"  css_classes="row align-items-stretch pb-5" post_type="post" transition_container="false" ';

	// preloaded="true" preloaded_amount="9"
	//target="articlefilter" filters="true"

	$title = 'Filter Articles';

	if(is_category()) {

		$cat = get_category( get_query_var( 'cat' ) );
		$category = $cat->slug;

		//$title = $cat->name;
		$shortcode .= 'category="'.$category.'" category__and="'.$cat->id.'" pause="false" scroll="true"';

	} elseif(is_tag()) {

		$tag = get_query_var('tag');
		//$title = $tag;
		$shortcode .= 'tag="'.$tag.'" pause="false" scroll="true"';

	} elseif(is_author()) {

		$author = get_the_author_meta('ID');
		//$title = $author;
		$shortcode .= 'author="'.$author.'" pause="false" scroll="true"';

	} elseif(is_year() || is_month() || is_day()) {

		$year = get_the_date('Y');
		$month = get_the_date('m');
		$day = get_the_date('d');

		if(is_year()){
			$title = $year;
			$shortcode .= 'year="' . $year . '"]';
		}  elseif(is_month()){
			$title = get_the_date( 'F Y' );
			$shortcode .= 'year="' . $year . '" month="' . $month . '"';
		}  elseif(is_day()){
			$title = get_the_date();
			$shortcode .= 'year="' . $year . '" month="' . $month . '" day="' . $day . '"';
		}

	} elseif( is_front_page() ) {
		$title = 'Blog Articles';

		$shortcode .= 'pause="false" scroll="false"';

	} elseif(is_home()) {
		$shortcode .= 'scroll="true"';
	}

	$shortcode .= ']';


	?>

	<div class="row align-items-stretch">

		<div class="col-12 col-md-3 bg-light pt-5">
			<div class="container">
				<h3>Filter Articles</h3>
				<?= do_shortcode('[ajax_load_more_filters id="blog" target="blogPosts"]'); ?>
			</div>
		</div>

		<div class="articles-grid pb-5 col-12 col-md-9 pt-5">
			<div class="container">
				<?= do_shortcode($shortcode); ?>
			</div>
		</div>
	</div>

	<?php

}