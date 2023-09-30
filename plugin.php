<?php

/*
 * Plugin Name: Column Management
 */


function manage_posts_columns_func($column){

    $column['id'] = "ID";
    $column['thumbnails'] = "Thumbnails ";
    $column['wordcount'] = "WordCount";
    return $column;
}

add_filter('manage_posts_columns','manage_posts_columns_func');


function manage_posts_custom_columns_func($column,$post_id){
    if('id' == $column){
        echo $post_id;
    }elseif('thumbnails' == $column){
        $thumbnail = get_the_post_thumbnail($post_id,array(100,100));
        echo $thumbnail;
    }

    elseif('wordcount' == $column){
       $wordn = get_post_meta($post_id,'wordn',true);

       echo $wordn;
    }
   
    return $column;
}

add_filter('manage_posts_custom_column','manage_posts_custom_columns_func',10,2);

function init_function(){
    $posts = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => 'post',
        'post_status' => 'any',

    ));
    foreach($posts as $p){
        $content = $p->post_content;
        $wordn = str_word_count(strip_tags($content));
        update_post_meta($p->ID, 'wordn', $wordn);

    }
}

add_action('init','init_function');