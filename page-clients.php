<?php
/*
	Template Name: Шаблон "Наши клиенты"
*/
?>
<?php get_header()?>
	<?php while(have_posts()) { the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="text-left mb-4">
				<h2><?php the_title(); ?></h2>
            </header>
			<div class="entry-content">
                <div class="row" id="lightgallery">
                <?php
                    //Get the images ids from the post_metadata
                    $images = acf_photo_gallery('worrs_gallery', $post->ID);

                    //Check if return array has anything in it
                    if( count($images) ):
                        //Cool, we got some data so now let's loop over it
                        foreach($images as $image):
                            $id = $image['id']; // The attachment id of the media
                            $title = $image['title']; //The title
                            $caption= $image['caption']; //The caption
                            $full_image_url= $image['full_image_url']; //Full size image url
                            //$full_image_url = acf_photo_gallery_resize_image($full_image_url, 262, 160); //Resized size to 262px width by 160px height image url
                            $thumbnail_image_url= $image['thumbnail_image_url']; //Get the thumbnail size image url 150px by 150px
                            $url= $image['url']; //Goto any link when clicked
                            $target= $image['target']; //Open normal or new tab
                            $alt = get_field('photo_gallery_alt', $id); //Get the alt which is a extra field (See below how to add extra fields)
                            $class = get_field('photo_gallery_class', $id); //Get the class which is a extra field (See below how to add extra fields)
                ?>
                <div class="thumbnail">
                    <?php if( !empty($full_image_url) ){ ?><a class="gallery-item" href="<?php echo $full_image_url; ?>"><?php } ?>
                        <img class="img img-fluid" src="<?php echo $full_image_url; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>">
                    <?php if( !empty($full_image_url) ){ ?></a><?php } ?>
                    <div class="text-center"><?php  echo $caption; ?></div>
                </div>
                <?php endforeach; endif; ?>
                </div>
				<?php the_content(); ?>
			</div>
		</article>
	<?php } ?>
<?php
get_footer();
?>