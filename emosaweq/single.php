<?php get_header() ?>
<div class="row">
    <div class="col-md-8">
        <main>
            <?php while( have_posts() ): the_post() ?>
                <article>
                    <header class="art-header">
                        <a href="<?php echo mw_first_category_link() ?>" class="art-cat"><i class="fa fa-hashtag"></i> <?php echo mw_first_category_name() ?></a>
                        <h1><?php the_title() ?></h1>
                        <time><i class="fa fa-clock"></i> <?php mw_post_time_ago() ?></time>
                    </header>

                    <figure class="art-img">
                        <?php the_post_thumbnail('full', 'sizes="(max-width: 575px) 100vw, (max-width: 767px) 516px, (max-width: 991px) 456px, (max-width: 1199px) 616px, (max-width: 1399px) 736px, 856px"') ?>
                    </figure>

                    <main class="art-body">
                        <?php the_content() ?>
                    </main>

                    <footer class="art-tags">
                        <?php the_tags(null, ' ') ?>
                    </footer>

                </article>

            <?php endwhile; ?>

            <?php
                $related = mw_related_posts( get_the_ID(), 3 );
                if( $related->have_posts() ):
            ?>
                <section class="related-posts">
                    <header class="headline">
                        <h2 class="title">مقالات ذات صلة</h2>
                    </header>
                    <div class="row">
                        <?php while( $related->have_posts() ): $related->the_post(); ?>
                            <div class="col-lg-4 col-md-6">
                                <article class="related-post">
                                    <figure class="related-thumb animated-img">
                                        <a href="<?php the_permalink() ?>">
                                            <?php the_post_thumbnail('medium') ?>
                                        </a>
                                    </figure>
                                    <div class="related-det">
                                        <a href="<?php echo mw_first_category_link() ?>" class="rel-cat"><i class="fa fa-tag"></i> <?php echo mw_first_category_name() ?></a>
                                        <h3 class="related-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                                    </div>
                                </article>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php endif; ?>

        </main>
    </div>
    <div class="col-md-4">
        <?php get_sidebar() ?>
    </div>

</div>
<?php get_footer() ?>