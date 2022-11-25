<?php get_header() ?>
<div class="row">
    <div class="col-md-8">
        <main>
            <?php while( have_posts() ): the_post() ?>
                <article>
                    <header class="art-header">
                        <h1><?php the_title() ?></h1>
                    </header>
                    
                    <?php if( has_post_thumbnail() ): ?>
                        <figure class="art-img">
                            <?php the_post_thumbnail('full') ?>
                        </figure>
                    <?php endif; ?>

                    <main class="art-body">
                        <?php the_content() ?>
                    </main>
                </article>
            <?php endwhile; ?>

        </main>
    </div>
    <div class="col-md-4">
        <?php get_sidebar() ?>
    </div>

</div>
<?php get_footer() ?>