<?php
/*
 * Plugin Name: WP Simple Random Quote
 * Description: a plugin that shows a random quote using a shortcode
 * Version: 1.0
 * Author: Boris Lutskovsky
 * Author URI: http://www.iamboris.com
 * License: MIT
 */


function wp_random_quote_shortcode($atts){
  $a = shortcode_atts(array(), $atts);
  
  $quotes = preg_split("/\r\n/",get_option('wp-random-quote-quotes'));
  $i = rand(0, count($quotes) - 1);
  
  return $quotes[$i];
}

add_shortcode('wp_random_quote', 'wp_random_quote_shortcode');


add_action('admin_menu', 'wp_random_quote_admin_menu');
function wp_random_quote_admin_menu(){
  add_menu_page('WP Random Quote', 'Random Quote', 'manage_options', 'wp-random-quote', 'wp_random_quote_admin', 'dashicons-clipboard');
  
}

function wp_random_quote_admin(){
  if(isset($_POST['wp-random-quotes-submit']) && $_POST['wp-random-quotes-submit'] == 'Submit'){
    if(check_admin_referer('simple-random-quotes', 'update-quotes'))
    $quotes =  filter_input(INPUT_POST, 'wp-random-quotes', FILTER_SANITIZE_STRING);
    update_option('wp-random-quote-quotes', $quotes);
  } 
  $options = get_option('wp-random-quote-quotes');
  
  
  ?>
  <div class="wrap">
    <h2>WP Random Quote Settings</h2>
    <form method="POST">
      <div class="controls">
        <label for="quotes">Quotes</label>
        <textarea name="wp-random-quotes" cols="100" rows="20"><?php echo esc_textarea($options); ?></textarea>
        <?php wp_nonce_field('simple-random-quotes', 'update-quotes'); ?>
      </div>
      <input type="submit" name="wp-random-quotes-submit"/>
    </form>
  </div>
  <?php
}


?>