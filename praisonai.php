<?php
/**
 * Plugin Name: PraisonAI
 * Plugin URI:  https://wordpress.org/plugins/praisonai/
 * Description: Effortlessly integrate a powerful, AI-driven chatbot onto your WordPress site with PraisonAI.
 * Version:     1.0.3
 * Author:      PraisonAI
 * Author URI:  https://mer.vin/
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: praisonai
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Your plugin code will go here

// Add a menu item to the settings menu
function praisonai_add_admin_menu() {
    add_options_page(
        'PraisonAI Settings',
        'PraisonAI',
        'manage_options',
        'praisonai',
        'praisonai_settings_page_render'
    );
}
add_action('admin_menu', 'praisonai_add_admin_menu');
add_action('admin_enqueue_scripts', 'praisonai_enqueue_admin_scripts');

// Enqueue admin scripts
function praisonai_enqueue_admin_scripts($hook) {
    if ($hook !== 'settings_page_praisonai') {
        return;
    }
    wp_enqueue_script(
        'praisonai-admin',
        plugin_dir_url(__FILE__) . 'js/praisonai-admin.js',
        array('jquery'),
        '1.0.3',
        true
    );
}

// Register settings
function praisonai_register_settings() {
    register_setting('praisonai_settings_group', 'praisonai_openai_api_key', 'praisonai_sanitize_api_key');
}
add_action('admin_init', 'praisonai_register_settings');

// Render the settings page
function praisonai_settings_page_render() {
    ?>
    <div class="wrap">
        <h1>PraisonAI Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('praisonai_settings_group');
            do_settings_sections('praisonai');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Add settings section and fields
function praisonai_add_settings_fields() {
    add_settings_section(
        'praisonai_general_section',
        'API Settings',
        null,
        'praisonai'
    );

    add_settings_field(
        'praisonai_openai_api_key',
        'OpenAI API Key',
        'praisonai_api_key_field_render',
        'praisonai',
        'praisonai_general_section'
    );
}
add_action('admin_init', 'praisonai_add_settings_fields');

// Render the API key field
function praisonai_api_key_field_render() {
    $api_key = get_option('praisonai_openai_api_key');
    echo '<div style="position: relative; display: inline-block; width: 400px;">';
    echo '<input type="password" id="praisonai_openai_api_key_field" name="praisonai_openai_api_key" value="' . esc_attr($api_key) . '" style="width: 100%; padding-right: 60px;">';
    echo '<button type="button" id="praisonai_toggle_api_key" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); cursor: pointer; border: none; background: #f0f0f1; padding: 4px 8px; border-radius: 3px;">Show</button>';
    echo '</div>';
}

// Shortcode for the chatbox
function praisonai_chat_shortcode() {
    // Enqueue scripts and styles only when the shortcode is used
    wp_enqueue_style('praisonai-chat-style', plugin_dir_url(__FILE__) . 'css/praisonai-chat.css', array(), '1.0.0');
    wp_enqueue_script('praisonai-chat-script', plugin_dir_url(__FILE__) . 'js/praisonai-chat.js', array('jquery'), '1.0.0', true);

    // Pass data to the script, like the AJAX URL
    wp_localize_script('praisonai-chat-script', 'praisonai_chat_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('praisonai_chat_nonce')
    ));

    // The HTML for the chatbox
    ob_start();
    ?>
    <div class="praisonai-chat-container">
        <div class="praisonai-chat-history"></div>
        <form class="praisonai-chat-form">
            <input type="text" id="praisonai-chat-input" placeholder="Ask anything..." autocomplete="off">
            <button type="submit" id="praisonai-chat-submit">Send</button>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('praisonai_chat', 'praisonai_chat_shortcode');

// AJAX handler for the chat
function praisonai_handle_chat_message() {
    // Check for a valid AJAX request
    check_ajax_referer('praisonai_chat_nonce', 'nonce');

    $message = isset($_POST['message']) ? sanitize_text_field(wp_unslash($_POST['message'])) : '';
    $api_key = get_option('praisonai_openai_api_key');

    if (empty($api_key)) {
        wp_send_json_error('API key is not set.');
        return;
    }

    $api_url = 'https://api.openai.com/v1/chat/completions';
    $headers = [
        'Authorization' => 'Bearer ' . $api_key,
        'Content-Type'  => 'application/json',
    ];
    $body = [
        'model'    => 'gpt-3.5-turbo',
        'messages' => [['role' => 'user', 'content' => $message]],
    ];

    $response = wp_remote_post($api_url, [
        'headers' => $headers,
        'body'    => json_encode($body),
        'timeout' => 30,
    ]);

    if (is_wp_error($response)) {
        wp_send_json_error('Failed to connect to the API.');
        return;
    }

    $response_body = wp_remote_retrieve_body($response);
    $data = json_decode($response_body, true);

    if (isset($data['choices'][0]['message']['content'])) {
        wp_send_json_success($data['choices'][0]['message']['content']);
    } else {
        wp_send_json_error('Could not get a valid response from the API.');
    }
}
add_action('wp_ajax_praisonai_chat', 'praisonai_handle_chat_message');
add_action('wp_ajax_nopriv_praisonai_chat', 'praisonai_handle_chat_message'); // For non-logged-in users

// Sanitize the API key
function praisonai_sanitize_api_key($input) {
    return sanitize_text_field($input);
}

