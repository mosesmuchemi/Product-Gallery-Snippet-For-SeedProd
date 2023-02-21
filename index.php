function product_gallery_shortcode( $atts ) {
    global $product;
    $atts = shortcode_atts( array(
        'id' => $product->get_id(),
    ), $atts );
 
    if ( !wp_script_is( 'jquery' ) ) {
        wp_enqueue_script( 'jquery' );
    }
 
    ob_start();
    ?>
    <div class="product-gallery">
        <div class="main-image">
            <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $atts['id'] ), 'full' )[0]; ?>" alt="<?php echo get_the_title( get_post_thumbnail_id( $atts['id'] ) ); ?>">
        </div>
        <div class="thumbs">
            <?php
            $product_gallery_images_ids = $product->get_gallery_image_ids();
            foreach( $product_gallery_images_ids as $image_id ) {
                $thumbnail_src = wp_get_attachment_image_src( $image_id, 'thumbnail' )[0];
                $full_src = wp_get_attachment_image_src( $image_id, 'full' )[0];
                ?>
                <img src="<?php echo $thumbnail_src; ?>" class="thumb" data-full-image="<?php echo $full_src; ?>">
                <?php
            }
            ?>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $(document).on("click", ".thumb", function(){
                var fullImage = $(this).data("full-image");
                $(".main-image img").attr("src", fullImage);
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode( 'product_gallery', 'product_gallery_shortcode' );