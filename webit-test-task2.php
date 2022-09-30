<?php
/*
Plugin Name: Webit Test Task 2
Author: Pavel Starikov
Description: Webit Test Task 2
Version: 1.0
*/

// Add Field
add_action('woocommerce_after_order_notes', 'webit_task2_add_field');
function webit_task2_add_field($checkout){
    woocommerce_form_field('webit_task2_yes_or_no', array(
        'type' => 'text',
        'label' => __('Да или нет?'),
        'placeholder' => __('Да или нет?'),
        'required' => true
    ) ,
    $checkout->get_value('webit_task2_yes_or_no'));
}

// Validation Field
add_action('woocommerce_checkout_process', 'webit_task2_validation');
function webit_task2_validation(){
    if (!$_POST['webit_task2_yes_or_no']) {
        wc_add_notice(__('Please enter "Yes or no" value!'), 'error');
    }
}

// Update Field
add_action('woocommerce_checkout_update_order_meta', 'webit_task2_update');
function webit_task2_update($order_id){
    if (!empty($_POST['webit_task2_yes_or_no'])) {
        update_post_meta($order_id, 'webit_task2_yes_or_no_field',sanitize_text_field($_POST['webit_task2_yes_or_no']));
    }
}

// Column
add_filter('manage_edit-shop_order_columns', 'webit_task2_add_columns');
function webit_task2_add_columns( $shop_order_cols ){
    $webit_task2_columns=array(
        'webit_task2_yes_or_no' => 'Да или нет?',
    );
    $shop_order_cols = array_slice( $shop_order_cols, 0, 2, true ) + $webit_task2_columns + array_slice( $shop_order_cols, 2, NULL, true );
    return $shop_order_cols;
}
add_action( 'manage_shop_order_posts_custom_column', 'webit_task2_columns_content', 10, 2 );
function webit_task2_columns_content( $column, $post_id ) {
    if($column=='webit_task2_yes_or_no'){
        $info = get_post_meta($post_id, 'webit_task2_yes_or_no_field', 1);
        echo $info;
    }
}