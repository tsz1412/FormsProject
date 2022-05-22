<?php
/**
 * Template Name: Homepage
 */

get_header('shop');
get_template_part('template-parts/hero-slider');
$about_top_img_top = get_field('about_top_img');
$about_bottom_img_top = get_field('about_bottom_img');
$about_title = get_field('about_title');
$about_subtitle = get_field('about_subtitle');
$args = array(
    'post_type' => 'services',
    'post_status' => 'publish',
    'posts_per_page' => 8,
    'orderby' => 'title',
    'order' => 'ASC',
    );

//$services = new WP_Query( $args );
$services = get_field('services_visible');
$args_testi = array(
    'post_type' => 'testimonials',
    'post_status' => 'publish',
    'posts_per_page' => 8,
    'orderby' => 'title',
    'order' => 'ASC',
);
//$testimonials = new WP_Query( $args_testi );
$testimonials = get_field('testimonials');
?>

    <div class="introduction-one">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <div class="introduction-one-image">
                    <div class="introduction-one-image__detail"><img src="<?php echo $about_top_img_top['url']; ?>" alt="background"/><img src="<?php echo $about_bottom_img_top['url']; ?>" alt="background"/></div>
                    <div class="introduction-one-image__background">
                        <div class="background__item">
                            <div class="wrapper" ref="{bg1}"><img data-depth="0.5" src="<?php echo trailingslashit(get_template_directory_uri()).'/src/'?>assets/images/introduction/IntroductionOne/bg1.png" alt="background"/></div>
                        </div>
                        <div class="background__item">
                            <div class="wrapper" ref="{bg2}"><img data-depth="0.3" data-invert-x="" data-invert-y="" src="<?php echo trailingslashit(get_template_directory_uri()).'/src/'?>assets/images/introduction/IntroductionOne/bg2.png" alt="background"/></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="introduction-one-content">
                    <h5><?= $about_subtitle['primary'];?> <span><?= $about_subtitle['secondary'];?></span></h5>
                    <div class="section-title " style="margin-bottom: 1.875em">
                        <h2><?= get_field('about_title');?></h2><img src="<?php echo trailingslashit(get_template_directory_uri()).'/src/'?>assets/images/introduction/IntroductionOne/content-deco.png" alt="Decoration"/>
                    </div>
                    <p><?= get_field('about_content'); ?></p><a class="btn -white" href="#">Appointment</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="introduction-two">
    <div class="video-frame" style="height: 500px; width: 888.889px;">
<!--        <div class="video-frame__poster"><img src="--><?php //echo trailingslashit(get_template_directory_uri()).'/src/' ?><!--assets/images/introduction/IntroductionTwo/4.png" alt="Video poster"/></div><a class="btn -white -round" href="#" style="height: 50px; width: 50px; line-height: 50px; padding: 0px;"><i class="fas fa-play"></i></a>-->
        <div class="video-frame__poster"><img src="<?= get_field('services_video')['thumbnail']['url']?>" alt="Video poster"/></div><a class="btn -white -round" href="#" style="height: 50px; width: 50px; line-height: 50px; padding: 0px;"><i class="fas fa-play"></i></a>
    </div>

    <div class="introduction-two-content">
        <div class="container">
            <?php $count = 0; foreach ($services as $service): $count ++; ?>
                <div class="introduction-two-content__item" data-cover="<?php echo trailingslashit(get_template_directory_uri()).'/src/'?>assets/images/introduction/IntroductionTwo/1.png" data-src="https://www.youtube.com/embed/80e0QHPYRG4"><span><?= str_pad($count, 2, '0', STR_PAD_LEFT); ?></span><a href="#"><?= $service->post_title ?></a></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="product-slide">
    <div class="container">
        <div class="section-title -center" style="margin-bottom: 1.875em">
            <h2>Beauty Products</h2><img src="<?php echo trailingslashit(get_template_directory_uri()).'/src/'?>assets/images/introduction/IntroductionOne/content-deco.png" alt="Decoration"/>
        </div>
<!--        <div class="product-slider">-->
<!--            --><?php //get_template_part('template-parts/loop/products-grid') ?>
<!--            --><?php //get_template_part('template-parts/loop/quick-view') ?>
<!---->
<!--            <div class="text-center"><a class="btn -transparent -underline" href="shop-fullwidth-4col.html">View all product</a>-->
<!--            </div>-->
<!--        </div>-->
        <?php
        if ( woocommerce_product_loop() ) {

            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action( 'woocommerce_before_shop_loop' );

            woocommerce_product_loop_start();

            if ( wc_get_loop_prop( 'total' ) ) {
                while ( have_posts() ) {
                    the_post();

                    /**
                     * Hook: woocommerce_shop_loop.
                     */
                    do_action( 'woocommerce_shop_loop' );

                    wc_get_template_part( 'content', 'product' );
                }
            }

            woocommerce_product_loop_end();

            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
        } else {
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action( 'woocommerce_no_products_found' );
        }
        ?>
    </div>
</div>
<div class="testimonial">
    <div class="section-title -center" style="margin-bottom: 3.125rem">
        <h5><?= get_field('testimonials_title') ?></h5>
        <h2><?= get_field('testimonials_subtitle') ?></h2><img src="<?php echo trailingslashit(get_template_directory_uri()).'/src/'?>assets/images/introduction/IntroductionOne/content-deco.png" alt="Decoration"/>
    </div>
    <div class="container">
        <div class="testimonial-slider">
            <div class="row">
                <div class="col-12">
                    <div class="slide-for">
                        <div class="slide-for__wrapper">
                        <?php foreach ($testimonials as $testimonial): $id = $testimonial->ID ?>
                            <div class="slide-for__item">
                                <div class="slide-for__item__header">
                                    <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
                                    <div class="customer__info">
                                        <h3><?= get_field('name', $id) ?></h3>
                                        <h5><?= get_field('address', $id) ?></h5>
                                    </div>
                                </div>
                                <p class="slide-for__item__content"><?= get_field('content', $id) ?></p>
                            </div>
                        <?php endforeach; ?>
                        </div>
                        <div class="testimonial-one__slider-control"><a class="prev" href="#"><i class="fa fa-angle-left"> </i>Prev</a><a class="next" href="#">Next<i class="fa fa-angle-right"> </i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cta -style-1" style="background-image: url('<?php echo trailingslashit(get_template_directory_uri()).'/src/'?>assets/images/cta/CTAOne/1.png');">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 mx-auto">
                <div class="cta__form">
                    <div class="section-title " style="margin-bottom: 1.875em">
                        <h2>Book Service</h2><img src="<?php echo trailingslashit(get_template_directory_uri()).'/src/'?>assets/images/introduction/IntroductionOne/content-deco.png" alt="Decoration"/>
                    </div>

                    <?= do_shortcode('[contact-form-7 id="'.get_field('contact_us_form').'" title="טופס יצירת קשר 1" html_class="cta__form__detail validated-form"]') ?>
<!--                    <form class="cta__form__detail validated-form" action="#">-->
<!--                        <div class="input-validator">-->
<!--                            <input type="text" placeholder="Your name" name="name" required="required"/>-->
<!--                        </div>-->
<!--                        <div class="input-validator">-->
<!--                            <input type="text" placeholder="Your phone" name="phone" required="required"/>-->
<!--                        </div>-->
<!--                        <div class="input-validator">-->
<!--                            <select class="customed-select required" name="service">-->
<!--                                <option value="" hidden="hidden">Choose a services</option>-->
<!--                                <option value="Spa">Spa</option>-->
<!--                                <option value="Salon">Salon</option>-->
<!--                                <option value="Nail">Nail</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="input-validator">-->
<!--                            <select class="customed-select required" name="date">-->
<!--                                <option value="" hidden="hidden">Choose a data</option>-->
<!--                                <option value="Yesterday">Yesterday</option>-->
<!--                                <option value="Today">Today</option>-->
<!--                                <option value="Tomorow">Tomorow</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <button class="btn -light-red">Appoitment-->
<!--                        </button>-->
<!--                    </form>-->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>