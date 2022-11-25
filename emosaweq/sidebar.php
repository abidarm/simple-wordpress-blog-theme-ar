<aside class="sidebar">
    
    <?php if( ! is_home() ): ?>
        <section class="widget">
            <header class="headline">
                <h2 class="title">آخر المقالات</h2>
            </header>
            <div class="widget-posts">
                <?php $latest = mw_find_latest_posts(5); while( $latest->have_posts() ): $latest->the_post(); ?>
                    <article class="widget-post">
                        <figure class="widget-thumb animated-img">
                            <a href="<?php the_permalink() ?>">
                                <?php the_post_thumbnail('thumbnail', 'sizes=(max-width: 575px) 100vw, (max-width: 767px) 476px, (max-width: 991px) 176px, 90px') ?>
                            </a>
                        </figure>
                        <h3 class="widget-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                    </article>
                <?php endwhile; ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="widget">
        <header class="headline">
            <h2 class="title">الأكثر مشاهدة</h2>
        </header>
        <div class="widget-posts">
            <?php $popular = mw_most_viewed(5); while( $popular->have_posts() ): $popular->the_post(); ?>
                <article class="widget-post">
                    <figure class="widget-thumb animated-img">
                        <a href="<?php the_permalink() ?>">
                            <?php the_post_thumbnail('small', ['sizes' => "(min-width:768px) 90px, 100vw"]) ?>
                        </a>
                    </figure>
                    <h3 class="widget-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                </article>
            <?php endwhile; ?>
        </div>
    </section>

    <?php /*
    <section class="widget">
        <header class="headline">
            <h2 class="title">الأكثر تعليقا</h2>
        </header>
        <div class="widget-posts">
            <?php $commented = mw_most_commented(5); while( $commented->have_posts() ): $commented->the_post(); ?>
                <article class="widget-post">
                    <figure class="widget-thumb animated-img">
                        <a href="<?php the_permalink() ?>">
                            <?php the_post_thumbnail('thumbnail') ?>
                        </a>
                    </figure>
                    <h3 class="widget-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
    */ ?>

    <section class="widget">
        <header class="headline">
            <h2 class="title">أشهر الوسوم</h2>
        </header>
        <ul class="widget-tags">
            <?php $popular_tags = mw_most_popular_tags(5); foreach( $popular_tags as $tag ): ?>
                <li><a href="<?php echo get_tag_link ($tag->term_id) ?>" rel="tag"><?php echo $tag->name ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="widget">
        <header class="headline">
            <h2 class="title">حساباتنا الاجتماعية</h2>
        </header>
        <ul class="widget-social">
            <li><a href="https://facebook.com/emosaweq" class="social-fb" rel="me" target="_blank" title="فسيبوك"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="https://twitter.com/emosaweq" class="social-tw" rel="me" target="_blank" title="تويتر"><i class="fab fa-twitter"></i></a></li>
            <li><a href="https://instagram.com/emosaweq" class="social-in" rel="me" target="_blank" title="انستغرام"><i class="fab fa-instagram"></i></a></li>
            <li><a href="https://pinterest.com/emosaweq" class="social-pt" rel="me" target="_blank" title="بنترست"><i class="fab fa-pinterest"></i></a></li>
        </ul>
    </section>

</aside>