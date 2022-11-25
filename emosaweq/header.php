<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>

    <?php if ( ! is_user_logged_in() && ( !isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false) ): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WQWFMRN6VC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-WQWFMRN6VC');
    </script>
    <?php endif; ?>
</head>
<body <?php body_class() ?>>
    <header class="header">
        <nav class="topbar">
            <div class="container">
                <?php wp_nav_menu(array(
                    'theme_location' => 'top_menu',
                    'container' => 'ul',
                )) ?>
                <div class="head-social">
                    <a href="<?php echo home_url('feed') ?>" rel="me" target="_blank"><i class="fa fa-rss"></i></a>
                    <a href="https://youtube.com/emosaweq" rel="me" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a href="https://linkedin.com/emosaweq" rel="me" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <a href="https://pinterest.com/emosaweq" rel="me" target="_blank"><i class="fab fa-pinterest"></i></a>
                    <a href="https://twitter.com/emosaweq" rel="me" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com/emosaweq" rel="me" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://facebook.com/emosaweq" rel="me" target="_blank"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
        </nav>
        <section class="navbar">
            <div class="container">
                <button class="btn menu-btn"><span></span></button>
                <h1 class="logo">
                    <a href="<?php echo home_url() ?>">المسوق الرقمي</a>
                </h1>
                <nav class="main-nav">
                    <div class="nav-close"><i class="fa fa-times"></i></div>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'main_menu',
                        'container' => 'ul',
                    )) ?>
                </nav>
                <div class="header-buttons">
                    <button class="btn search-btn"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </section>
    </header>
    <div class="content">
        <div class="container">