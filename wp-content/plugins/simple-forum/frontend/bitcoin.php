<?php
/**
 * Template Name: Bitcoin
 */
get_header(); ?>
<div class="container-fluid">	
	<div class="row">
		<div class="col-xs-12 text-center">
				<?php echo do_shortcode('[forum]'); ?>
		</div>
		<div class="col-xs-12 text-center">
				<?php echo do_shortcode('[forum]'); ?>
		</div>
    </div>

	<div class="row">
		<div class="col-xs-12 col-md-8 col-md-push-2">
			<div class="col-xs-12 col-md-8">
				<?php while ( have_posts() ) : the_post();?>
					<div class="col-xs-12">
						<div class="col-xs-12 col-sm-9 col-md-9" role="article-presentation">
							<?php the_content(); ?>
						</div>
					</div>
					<hr>
				<?php endwhile; ?>
				<?php include(get_template_directory() . '/faucet/faucetbox/faucet.php'); ?>
			</div>

			<div class="col-xs-12 col-md-4">
				<?php echo do_shortcode('[forum]'); ?>
			</div>

		</div>
	</div>
</div>
</div>
<?php get_footer(); ?>


