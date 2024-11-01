<?php
/**
* Plugin Name: PokerStars VIP Status
* Plugin URI: http://www.skivsoft.net/wp-pokerstars/
* Description: Is a simple widget for displaying your PokerStars VIP status in your blog.
* Version: 0.2
*
* Author: SkivSoft
* Author URI: http://skivsoft.net
*/

define('WP_DEBUG', true);

class WP_PokerStars_Widget extends WP_Widget
{
    function WP_PokerStars_Widget()
    {
        parent::__construct('wp_pokerstars_widget', __('PokerStars VIP'), array('description' => __('Use this widget to show your PokerStars VIP status')));
    }


    function widget($args, $instance)
    {
        extract ( $args );
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        if ($title)
            echo $before_title . $title . $after_title;
        echo '<img src="' . plugins_url( '/wp-pokerstars/vip/' . $instance['status']. '_small.jpg') . '"/>';
        echo $after_widget;
    }


    function update($new_instance, $old_instance)
    {
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['status'] = strip_tags($new_instance['status']);
        return $instance;
    }

    function form($instance)
    {
        if ( $instance ) {
            $title = esc_attr( $instance['title'] );
        }
        else {
            $title = __( 'Spam Blocked' );
        }
        $viplist = array(
            'bronze'          => 'BronzeStar',
            'chrome'          => 'ChromeStar',
            'silver'          => 'SilverStar',
            'gold'            => 'GoldStar',
            'platinum'        => 'PlatinumStar',
            'supernova'       => 'Supernova',
            'supernova-elite' => 'Supernova Elite'
        );
?>        
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
        <p><label for="<?php echo $this->get_field_id('status');?>"><?php _e('VIP Status:', 'wp-pokerstars'); ?></label>
            <?php 
            echo '<select name="' . $this->get_field_name('status') . '">';
            foreach ($viplist as $k => $v)
            {
                $sel = ($k == $instance['status']) ? ' selected' : '';
                echo "<option value=\"$k\"$sel>$v</option>";
            }
            echo '</select></p>';
    }

}

function wp_register_widgets()
{
    register_widget('WP_PokerStars_Widget');
}

add_action('widgets_init', 'wp_register_widgets');

?>