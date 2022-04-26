<?php

if( class_exists( 'bbpress' ) ) {

    add_filter('bbp_template_include', function ($template) {
        if(is_bbpress()) {
            return get_page_template();
        }
        return $template;
    }, 100);

    add_filter('bbp_get_template_part', function ($templates, $slug, $name) {
        foreach ($templates as $template) {
            $theme_template = locate_template( app('sage.finder')->locate("bbpress/{$template}") );
            if( !empty( $theme_template ) ) {
                $view = app('view.finder')->getPossibleViewNameFromPath($theme_template);
                $view = trim($view, '\\/.');
                echo view($view)->render();
                return get_stylesheet_directory() . '/index.php';
            }
        }
        return $templates;
    }, PHP_INT_MAX, 3);

}
