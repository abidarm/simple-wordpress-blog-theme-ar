<?php get_header() ?>
<div class="row">
    <div class="col-md-8">
        <main class="main">
            <header class="headline">
                <?php if( is_archive() ): ?>
                    <h2 class="title"><?php the_archive_title() ?></h2>
                <?php else: ?>
                    <h2 class="title">آخر المقالات</h2>
                <?php endif; ?>
            </header>
            <div class="post-cards">
                <?php while( have_posts() ): the_post() ?>
                    <article class="card">
                        <figure class="card-thumb animated-img">
                            <a href="<?php the_permalink() ?>">
                                <?php the_post_thumbnail('large', 'sizes="(min-width: 992px) 280px, (max-width: 768px) 416px, (max-width: 768px) 416px, (max-width: 576px) 476px, 100vw"') ?>
                            </a>
                        </figure>
                        <div class="card-details">
                            <h3 class="card-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                            <div class="card-meta">
                                <div class="card-author">
                                    <i class="fa fa-user-circle"></i>
                                    <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ?>" rel="author"><?php the_author() ?></a>
                                </div>
                                <div class="card-category">
                                    <i class="fa fa-tags"></i>
                                    <?php mw_the_first_category() ?>
                                </div>
                                <div class="card-date">
                                    <i class="fa fa-clock"></i>
                                    <time><?php mw_post_time_ago() ?></time>
                                </div>
                            </div>
                            <div class="card-desc">
                                <p><?php the_excerpt() ?></p>
                            </div>
                            <a class="btn btn-alt card-link" href="<?php the_permalink() ?>" title="<?php the_title() ?>">قراءة المزيد</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </main>
    </div>
    <div class="col-md-4">
        <?php get_sidebar() ?>
    </div>
    
</div>
<?php get_footer() ?>