<?php
/**
* Auto-update the task_status field every time the task
* is updated using the REST API
* @package Taskbook
* @param object $post The post object
* @param bool $request The current request (not used)
*/

add_action('rest_after_insert_task', 'taskbook_change_status', 10, 2);
function taskbook_change_status($post, $request) {
    $outcome = get_post_meta($post->ID, 'taskbook_outcome', true);

    if ( strlen($outcome) === 0 ) {
        update_post_meta( $post->ID, 'task_status', 'Completed' );
    } else {
        update_post_meta( $post->ID, 'task_status', 'In progress');
    }

    // if ( !isset($outcome) && empty($outcome) ) {
    //     update_post_meta( $post->ID, 'task_status', 'In progress');
    // } else {
    //     update_post_meta( $post->ID, 'task_status', 'Completed' );
    // }
}

add_action( 'rest_api_init', 'taskbook_register_task_status' );
 
function taskbook_register_task_status() {
 
    register_rest_field( 
        'task',
        'task_status', 
        array(
           'get_callback' => 'taskbook_get_task_status',
           'schema' => null,
        )
    );
}
 
function taskbook_get_task_status( $object, $field_name, $request ) { 
    //return the post meta
    return get_post_meta( $object['id'], $field_name, true );
}