<?php 
/*
	Template Name: Шаблон "Дилеры"
*/
?>

<?php get_header()?>
<?php 


$args = array(
	'posts_per_page' => -1,
	'orderby' => 'comment_count',
	'post_type' => 'dealers_content',
	'meta_key'			=> 'izdelie_sort',
	'orderby'			=> 'meta_value',
	'order'				=> 'ASC'
);

$query = new WP_Query( $args );


?>
	<?php while(have_posts()) { the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="mx-auto w-75">
				<h2 class="text-success"><strong><?php  echo get_field('deal_h', get_the_ID()); ?></strong></h2>
				<?php  echo get_field('deal_desc', get_the_ID()); ?>
			</div>
			<h4 class="text-danger text-center"><strong><?php  echo get_field('deal_h_izdelie', get_the_ID()); ?></strong></h4>
			<div class="opt-items row">
				<?php 
				
						// Цикл
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								?>
								<div class="col-sm-6">
									<div class="opt-item media">
										<img src="<?php echo get_field('izdelie_thumb', get_the_ID());?> " class="mr-3" alt="...">
										<div class="media-body">
											<h5 class="mt-0"><?php  the_title(); ?></h5>
											<p>Цена за кв.м: <span class="text-danger"><?php  echo get_field('izdelie_price', get_the_ID()); ?></span> <?php  echo get_field('izdelie_currency', get_the_ID()); ?></p>
										</div>
									</div>
								</div>
								<?php 
							}
						} else {
							// Постов не найдено
						}
						// Возвращаем оригинальные данные поста. Сбрасываем $post.
						wp_reset_postdata();

										
				
				?>
			</div>

			<div class="mb-4 text-center">
				<p class="h4 mx-auto w-75"><?php  echo get_field('deal_text', get_the_ID()); ?></p>
			</div>
			<br>

			<div class="mb-4 row">
				<div class="col-sm-6 text-left">
					<strong><?php  echo get_field('deal_footer', get_the_ID()); ?></strong>
				</div>
				<div class="col-sm-6 text-right">
					<!-- <a href="http://zakupki.gov.ru/epz/contractfz223/extendedSearch/results.html?morphology=on&pageNumber=1&sortDirection=false&recordsPerPage=_10&statuses=0&supplierTitle=860221660260&currencyId=-1&regionDeleted=false&sortBy=BY_UPDATE_DATE">
						<img class="img-fluid" src="<?php bloginfo('template_url')?>/images/rf.jpg">
						Информация о нас на госзакупках
					</a> -->
				</div>
			</div>
			<?php /*<header class="text-left mb-4">
				<h2><?php the_title(); ?></h2>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>*/?>
		</article>
	<?php } ?>
<?php get_footer()?>