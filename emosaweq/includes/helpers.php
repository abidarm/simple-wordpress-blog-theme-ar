<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Returns the post first category object
 * @param int $post_id
 * @return \WP_Term|null
 */
function mw_first_category( $post_id = false ) {
    $categories = get_the_category($post_id);
    if ( count( $categories ) ) {
        if ( in_array( $categories[0]->slug, ['slider', 'index']) && count($categories) > 1 ) {
            if ( in_array( $categories[1]->slug, ['slider', 'index']) && count($categories) > 2 ) {
                return $categories[2];
            }
            return $categories[1];
        }
        return $categories[0];
    }
} 

/**
 * Prints the post first category name with ahref link
 * @param int $post_id
 */
function mw_the_first_category( $post_id = false, $args = '' ) {
    $category = mw_first_category( $post_id );
    if ( $category ) {
        $cat_link = get_category_link($category);
        $cat_name = $category->name;
        echo '<a href="'. $cat_link .'" '. $args .'>'. $cat_name . '</a>' ;
    }
}

/**
 * Returns the post first category name
 * @param int $post_id
 * @return string|null
 */
function mw_first_category_name( $post_id = false ) {
    $category = mw_first_category( $post_id );
    if ( $category ) {
        return $category->name;
    }
} 

/**
 * Returns the post first category link
 * @param int $post_id
 * @return string|null
 */
function mw_first_category_link( $post_id = false ) {
    $category = mw_first_category( $post_id );
    if ( $category ) {
        return get_category_link($category);
    }
} 

function mw_comment_time_ago() {
    printf( 'منذ %s', human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) );
}

function mw_post_time_ago() {
    printf( 'منذ %s', human_time_diff( get_the_date('U') ) );
}

/**
 * Return the WP_User inside the author template
 * @return \WP_User
 */
function mw_single_author() {
    return (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
}

function mw_assets($link) {
    return get_template_directory_uri() . '/' . trim( $link, '/' );
}

function mw_find_latest_posts($limit) {
    return new WP_Query([
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false
    ]);
}

function mw_find_posts_by_category($catId, $limit, $excluded = []) {
    return new WP_Query([
        'cat' => $catId,
        'order' => 'DESC',
        'post_status' => 'publish',
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'no_found_rows' => true,
        'post__not_in' => $excluded,
        'posts_per_page' => $limit
    ]);
}

function mw_related_posts($post_id, $limit) {
    $exclude = [$post_id];
    return new WP_Query([
        'post_type' => 'post',
        // 'cat' => $category,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'posts_per_page' => $limit,
        'post__not_in' => $exclude
    ]);
}

function mw_str_limit_words($text, $nb_words, $after = '...') {
    $text = strip_tags( $text );

    $exploded = explode(' ', $text);

    if ( count( $exploded ) > $nb_words ) {
        $sliced = array_slice( $exploded, 0, $nb_words );
        $text = implode(' ', $sliced) . $after;
    }

    return $text;
}

function mw_most_viewed( $limit = 10 ) {
    return new WP_Query([
        'posts_per_page' => $limit,
        'orderby' => 'rand',
        'post_status' => 'publish',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ]);
}

function mw_most_commented( $limit = 10 ) {
    return new WP_Query([
        'posts_per_page' => $limit,
        'orderby' => 'comment_count',
        'post_status' => 'publish',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ]);
}

function is_ajax_request() {
    if( ! empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) == 'xmlhttprequest' ) {
        return true;
    }
    return false;
}

function mw_remove_subdomain($host_with_subdomain) {
    // $scheme = parse_url( $host_with_subdomain, PHP_URL_SCHEME );
    $array = explode(".", $host_with_subdomain);

    // return $scheme . '://' . (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "").".".$array[count($array) - 1];
    return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "").".".$array[count($array) - 1];
}

/**
 * @param $video_id
 * @param $quality  sd,md,hq,maxres
 * @return string
 */
function mw_youtube_thumb_url( $video_id, $quality = 'sd' ) {
    return "https://img.youtube.com/vi/{$video_id}/{$quality}default.jpg";
}

function mw_youtube_thumb_url_from_link( $link, $quality = 'sd' ) {
    // $id = 
    $query = parse_url( $link, PHP_URL_QUERY);
    $params = [];
    parse_str( $query, $params );
    $video_id = $params['v'];
    return mw_youtube_thumb_url( $video_id, $quality );
}

function mw_ytb_get_id_from_url( $url ) {
    $query = parse_url( $url, PHP_URL_QUERY);
    $params = [];
    parse_str( $query, $params );
    return $params['v'];
}


function mw_requested_url() {
    $server = $_SERVER;

    $subfolder = '/';
    if( isset($server['SCRIPT_NAME']) ) {
        $subfolder = dirname( $server['SCRIPT_NAME'] );
    }
    else if( isset($server['PHP_SELF']) ) {
        $subfolder = dirname( $server['PHP_SELF'] );
    }
    else {
        global $wp;
        $home_url = home_url( $wp->request );
        $subfolder = parse_url( $home_url, PHP_URL_PATH );
    }

    $url = '';

    if( isset( $server['REQUEST_URI'] ) ) {
        $url = $server['REQUEST_URI'];
    }
    else if( isset( $server['SCRIPT_URL'] ) ) {
        $url = $server['SCRIPT_URL'];
    }
    else if( isset( $server['REDIRECT_URL'] ) ) {
        $url = $server['REDIRECT_URL'];
    }
    else if( isset( $server['REDIRECT_SCRIPT_URL'] ) ) {
        $url = $server['REDIRECT_SCRIPT_URL'];
    }

    $url = preg_replace('/\?.*/', '', $url);

    $new_url = str_replace( $subfolder, '', $url );

    return $new_url;
}

function extract_video_id_from_url($entry) {
    $entry = esc_textarea($entry);

    // Is URL
    if( filter_var($entry, FILTER_VALIDATE_URL) ) {
        $parsed = parse_url($entry);
        $domain = get_domain_from_host($parsed['host']);
        $path = $parsed['path'];
        $query = $parsed['query'];

        if( $domain == 'youtube.com') {
            parse_str($query, $query_parts);
            if ( array_key_exists('v', $query_parts) ) {
                $entry = $query_parts['v'];
            }
        }
        else if( $domain == 'vimeo.com' ) {
            $path_parts = explode('/', trim($path, '/') );
            if ( count($path_parts) >= 1 ) {
                $entry = $path_parts[0];
            }
        }
        else if( $domain == 'dailymotion.com' ) {
            $path_parts = explode('/', trim($path, '/') );
            if ( count($path_parts) >= 2 && $path_parts[0] == 'video' ) {
                $entry = $path_parts[1];
            }
        }
        else if( $domain == 'facebook.com' ) {
            parse_str($query, $query_parts);
            if ( array_key_exists('v', $query_parts) ) {
                $entry = $query_parts['v'];
            }
        }
        else if( $domain == 'fb.watch' ) {
            $entry = trim($path, '/');
        }
        else if( $domain == 'youtu.be' ) {
            $entry = trim($path, '/');
        }
    }

    return $entry;
}

function extract_video_id_from_embed_url($entry) {
    $entry = esc_textarea($entry);

    // Is URL
    if( filter_var($entry, FILTER_VALIDATE_URL) ) {
        $parsed = parse_url($entry);
        $domain = get_domain_from_host($parsed['host']);
        $path = $parsed['path'];
        $query = $parsed['query'];

        if( $domain == 'youtube.com') {
            $parts = explode('/', $path);
            if( count($parts) >= 3 ) {
                return $parts[2];
            }
        }
        else if( $domain == 'vimeo.com' ) {
            $parts = explode('/', $path);
            if( count($parts) >= 3 ) {
                return $parts[2];
            }
        }
        else if( $domain == 'dailymotion.com' ) {
            $parts = explode('/', $path);
            if( count($parts) >= 4 ) {
                return $parts[3];
            }
        }
        else if( $domain == 'facebook.com' ) {
            parse_str($query, $query_parts);
            if ( array_key_exists('href', $query_parts) ) {
                return $query_parts['href'];
            }
        }
    }

    return '';
}

function extract_src_type_from_embed_url($entry) {
    $entry = esc_textarea($entry);

    // Is URL
    if( filter_var($entry, FILTER_VALIDATE_URL) ) {
        $parsed = parse_url($entry);
        $domain = get_domain_from_host($parsed['host']);

        if( $domain == 'youtube.com') {
            return 'youtube';
        }
        else if( $domain == 'vimeo.com' ) {
            return 'vimeo';
        }
        else if( $domain == 'dailymotion.com' ) {
            return 'dailymotion';
        }
        else if( $domain == 'facebook.com' ) {
            return 'facebook';
        }
        else if( $domain == 'fb.watch' ) {
            return 'facebook';
        }
        else if( $domain == 'youtu.be' ) {
            return 'youtube';
        }
    }

    return '';
}

function get_domain_from_host($host) {
    $parts = explode('.', $host);
    $new_parts = array_slice($parts, -2, 2);
    return implode('.', $new_parts);
}

function video_url_from_id($src, $id) {
    if( $src == 'youtube' ) {
        return 'https://www.youtube.com/watch?v='. $id;
    }
    else if ( $src == 'vimeo' ) {
        return 'https://vimeo.com/'. $id;
    }
    else if( $src == 'dailymotion' ) {
        return 'https://www.dailymotion.com/video/'. $id;
    }
    else if( $src == 'facebook' ) {
        return 'https://www.facebook.com/watch/?v='. $id;
    }
}

function get_video_embed_url($src, $id) {
    if ( $src == 'youtube' ) {
        return 'https://www.youtube.com/embed/'. $id;
    }
    else if ( $src == 'vimeo' ) {
        return 'https://player.vimeo.com/video/'. $id;
    }
    else if ( $src == 'dailymotion' ) {
        return 'https://www.dailymotion.com/embed/video/'. $id;
    }
    else if ( $src == 'facebook' ) {
        return 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F'. $id .'%2F&width=500&show_text=false&height=280';
    }
}

function mw_get_post_thumbnail_data( $size ) {
    return wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size );
}

function mw_most_popular_tags($limit) {
    // global $wpdb;
    // $term_ids = $wpdb->get_col("
    //     SELECT term_id FROM $wpdb->term_taxonomy
    //     INNER JOIN $wpdb->term_relationships ON $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id
    //     INNER JOIN $wpdb->posts ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
    //     WHERE DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= $wpdb->posts.post_date");
    // if( count($term_ids) )   

    return get_tags(array(
        'orderby' => 'count',
        'order'   => 'DESC',
        'number'  => 28,
        'number' => $limit,
        'hide_empty' => true
        // 'include' => $term_ids,
    ));
}