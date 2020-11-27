<?php
/*
	Template Name: Шаблон "Наши клиенты"
*/
?>
<?php get_header()?>
	<?php while(have_posts()) { the_post(); ?>
        <div class="page-set">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header>
                    <h1><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <div>
                        <?php the_content(); ?>
                    </div>
                    <div class="portfolio d-flex flex-row flex-wrap" id="portfolio">
                        <?php
                        if( have_rows('portfolio') ):
                            while ( have_rows('portfolio') ) : the_row(); 
                                $image = get_sub_field('photo');
                                if($image):
                                ?>
                                <div class="portfolio__item" data-src="<?=$image["sizes"]["medium_large"]?>">
                                    <img src="<?=$image["sizes"]["medium"]?>">
                                </div>
                                <? endif;
                            endwhile;
                        endif;
                        ?>
                    </div>
                </div>
            </article>
        </div>
	<?php } ?>
    <script>
       $('#portfolio').lightGallery({
            selector: '.portfolio__item',
            subHtmlSelectorRelative: true,
            width: '980px',
            height: '666px',
            mode: 'lg-fade',
            addClass: 'fixed-size',
            counter: false,
            download: false,
        });
    </script>
<?php
get_footer();
?>