<?php

/**
 * YouTube Information Widget
 * widget file
 */

// registers and creates a new widget for thi plugin
class liteyiw_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'liteyiw_widget', 
			__('YouTube Information Widget', 'wordpress'), 
			array( 'description' => __( 'Adds a channel card showing info and content of your YouTube channel', 'wordpress' ), ) 
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$product_id = apply_filters( 'widget_product_id', $instance['product_id'] );
		$max_vids = apply_filters( 'widget_max_vids', $instance['max_vids'] );
		$vid_h = apply_filters( 'widget_vid_h', $instance['vid_h'] );
		$vid_w = apply_filters( 'widget_vid_w', $instance['vid_w'] );
		$is_channel = apply_filters( 'widget_is_channel', $instance['is_channel'] );
		$is_channel_id = apply_filters( 'widget_is_channel_id', $instance['is_channel_id'] );
		$cc_period = apply_filters( 'widget_cc_period', $instance['cc_period'] );
		$tab_1 = apply_filters( 'widget_tab_1', $instance['tab_1'] );
		$tab_2 = apply_filters( 'widget_tab_2', $instance['tab_2'] );
		$tab_3 = apply_filters( 'widget_tab_3', $instance['tab_3'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		echo yiw_widget_content( $product_id, $max_vids, $vid_h, $vid_w, $is_channel_id, $cc_period, $tab_1, $tab_2, $tab_3 );
		echo $args['after_widget'];
	}

	public function form( $instance ) {

		$title = ( isset( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : '';
		$product_id = ( isset( $instance[ 'product_id' ] ) ) ? $instance[ 'product_id' ] : '';
		$max_vids = ( isset( $instance[ 'max_vids' ] ) ) ? $instance[ 'max_vids' ] : '';
		$vid_h = ( isset( $instance[ 'vid_h' ] ) ) ? $instance[ 'vid_h' ] : '';
		$vid_w = ( isset( $instance[ 'vid_w' ] ) ) ? $instance[ 'vid_w' ] : '';
		$is_channel = ( isset( $instance[ 'is_channel' ] ) ) ? $instance[ 'is_channel' ] : '';
		$is_channel_id = ( isset( $instance[ 'is_channel_id' ] ) ) ? $instance[ 'is_channel_id' ] : '';
		$cc_period = ( isset( $instance[ 'cc_period' ] ) ) ? $instance[ 'cc_period' ] : '';
		$cc_period_val = ( $cc_period !== '' && is_numeric( $cc_period ) ) ? esc_attr( $cc_period ) : '';
		$tab_1 = ( isset( $instance[ 'tab_1' ] ) ) ? $instance[ 'tab_1' ] : '';
		$tab_2 = ( isset( $instance[ 'tab_2' ] ) ) ? $instance[ 'tab_2' ] : '';
		$tab_3 = ( isset( $instance[ 'tab_3' ] ) ) ? $instance[ 'tab_3' ] : '';
		$rand = rand(10, 100);

		?>
			<style type="text/css">
				.yiw-help { display: none!important;padding: 1em; }
				.yiw-help-vis { display: block!important; }
			</style>
			<p>
				<span style="cursor: pointer;text-decoration: underline;" onclick="helpToggle(this)">Show help</span>
				<span> &vert; </span>
				<a href="options-general.php?page=yt-info" title="Generate a shortcode to use instead of this widget, or in addition to it" style="color: #444;"> Generate shortcode(s) </a>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="font-weight:bold;"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat yiw-input" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'product_id' ); ?>" style="font-weight:bold;"><?php _e( 'Username / ID:' ); ?></label> 
				<sub class="yiw-help">Enter your YouTube channel username or ID.<br>Example: username: <code>mullenweg</code> (youtube.com/user/<b>mullenweg</b>).<br>Example channel ID: <code>UCF0pVplsI8R5kcAqgtoRqoA</code> (youtube.com/channel/<b>UCF0pVplsI8R5kcAqgtoRqoA</b>)</sub>
				<input class="widefat yiw-input" onchange="document.getElementById('force_update_<?php echo $rand; ?>').setAttribute('value', '1');" id="<?php echo $this->get_field_id( 'product_id' ); ?>" name="<?php echo $this->get_field_name( 'product_id' ); ?>" type="text" value="<?php echo esc_attr( $product_id ); ?>" />
				<br>
				<input class="widefat yiw-input" onchange="document.getElementById('force_update_<?php echo $rand; ?>').setAttribute('value', '1');" id="<?php echo $this->get_field_id( 'is_channel_id' ); ?>" name="<?php echo $this->get_field_name( 'is_channel_id' ); ?>" type="checkbox" <?php if ( esc_attr($is_channel_id) != '' ) echo "checked"; ?> />
				<label for="<?php echo $this->get_field_id( 'is_channel_id' ); ?>"><?php _e( 'This is a channel ID (not custom slug)' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'max_vids' ); ?>" style="font-weight:bold;"><?php _e( 'Max. videos:' ); ?></label> 
				<sub class="yiw-help">How many videos would you like to show in "last uploads" and "popular uploads" tabs? By default, <code>2</code> videos will show.</sub>
				<input class="widefat yiw-input" onchange="document.getElementById('force_update_<?php echo $rand; ?>').setAttribute('value', '1');" id="<?php echo $this->get_field_id( 'max_vids' ); ?>" name="<?php echo $this->get_field_name( 'max_vids' ); ?>" type="number" value="<?php echo esc_attr( $max_vids ); ?>" min="1" max="20" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'vid_h' ); ?>" style="font-weight:bold;"><?php _e( 'Video height:' ); ?></label>
				<sub class="yiw-help">Enter a height value for the videos shown in "last uploads" and "popular uploads" tabs. Example : <code>250</code> ( in pixels ). The default value is <code>auto</code>.</sub>
				<input class="widefat yiw-input" onchange="document.getElementById('force_update_<?php echo $rand; ?>').setAttribute('value', '1');" id="<?php echo $this->get_field_id( 'vid_h' ); ?>" name="<?php echo $this->get_field_name( 'vid_h' ); ?>" type="number" value="<?php echo esc_attr( $vid_h ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'vid_w' ); ?>" style="font-weight:bold;"><?php _e( 'Video width:' ); ?></label>
				<sub class="yiw-help">Enter a width value for the videos shown in "last uploads" and "popular uploads" tabs. Example : <code>400</code> ( in pixels ). The default value is <code>auto</code>.</sub>
				<input class="widefat yiw-input" onchange="document.getElementById('force_update_<?php echo $rand; ?>').setAttribute('value', '1');" id="<?php echo $this->get_field_id( 'vid_w' ); ?>" name="<?php echo $this->get_field_name( 'vid_w' ); ?>" type="number" value="<?php echo esc_attr( $vid_w ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'cc_period' ); ?>" style="font-weight:bold;display:block;"><?php _e( 'Clear Cache:' ); ?></label>
				<span>Clear cache every</span>
				<input class="yiw-input" onchange="document.getElementById('force_update_<?php echo $rand; ?>').setAttribute('value', '1');" id="<?php echo $this->get_field_id( 'cc_period' ); ?>" name="<?php echo $this->get_field_name( 'cc_period' ); ?>" type="number" value="<?php echo esc_attr( $cc_period_val ); ?>" max="96" min="1" />
				<span>hour(s)</span>
			</p>
			<p>&nbsp;</p>
			<input type="hidden" name="force_update" id="force_update_<?php echo $rand; ?>" value="0" />

		<?php

		$force_update = esc_attr(get_option( 'liteyiw_force_update' ));
		if ( isset( $_POST["force_update"] ) && $_POST["force_update"] == "1" ) {
			if ( $force_update = '' )
				add_option( 'liteyiw_force_update', '1' );
			else
				update_option( 'liteyiw_force_update', '1' );
		}
		$rand = "";
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['product_id'] = ( ! empty( $new_instance['product_id'] ) ) ? strip_tags( $new_instance['product_id'] ) : '';
		$instance['max_vids'] = ( ! empty( $new_instance['max_vids'] ) ) ? strip_tags( $new_instance['max_vids'] ) : '';
		$instance['vid_h'] = ( ! empty( $new_instance['vid_h'] ) ) ? strip_tags( $new_instance['vid_h'] ) : '';
		$instance['vid_w'] = ( ! empty( $new_instance['vid_w'] ) ) ? strip_tags( $new_instance['vid_w'] ) : '';
		$instance['is_channel'] = ( ! empty( $new_instance['is_channel'] ) ) ? strip_tags( $new_instance['is_channel'] ) : '';
		$instance['is_channel_id'] = ( ! empty( $new_instance['is_channel_id'] ) ) ? strip_tags( $new_instance['is_channel_id'] ) : '';
		$instance['cc_period'] = ( ! empty( $new_instance['cc_period'] ) ) ? strip_tags( $new_instance['cc_period'] ) : '';
		$instance['tab_1'] = ( ! empty( $new_instance['tab_1'] ) ) ? strip_tags( $new_instance['tab_1'] ) : '';
		$instance['tab_2'] = ( ! empty( $new_instance['tab_2'] ) ) ? strip_tags( $new_instance['tab_2'] ) : '';
		$instance['tab_3'] = ( ! empty( $new_instance['tab_3'] ) ) ? strip_tags( $new_instance['tab_3'] ) : '';

		return $instance;
	}
}