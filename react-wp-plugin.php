<?php
/**
 * Plugin.
 * @package reactplug
 * @wordpress-plugin
 * Plugin Name:     React App With WP Plugin and Shortcode
 * Description:     ReactJS app plugin for Wordpress using shortcode.
 * Author:          Lucas Bodet
 * Author URL:      https://github.com/lucasbodev
 * Version:         1.0
 */

define("REACT_APP_ID", "react-wp-plugin");

add_shortcode(constant("REACT_APP_ID"), 'displayReactApp');

add_action('wp_enqueue_scripts', 'enq_react');

function displayReactApp()
{
    ob_start();
    ?>
    <div id="<?php echo constant("REACT_APP_ID"); ?>"></div>
    <script>
        window.reactAppId = '<?php echo constant("REACT_APP_ID"); ?>';
    </script>
    <?php
    $output = ob_get_contents();
    ob_get_clean();
    return $output;
}

function enq_react()
{
    $asset_file = plugin_dir_path(__FILE__) . 'build/index.asset.php';

    if (!file_exists($asset_file)) {
        return;
    }

    $asset = include $asset_file;

    wp_register_script(
        'display-react',
        plugin_dir_url(__FILE__) . '/build/index.js',
        $asset['dependencies'],
        $asset['version'],
        array(
            'in_footer' => true,
        )
    );

    wp_enqueue_script('display-react');
}