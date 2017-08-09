<?php

/**
 * YouTube Information Widget
 * settings file
 */

// registers a menu and a settings page for this plugin
add_action('admin_menu', 'yiw_create_menu');
function yiw_create_menu() {
	add_options_page( 'YouTube Information Widget', 'YouTube Info', 'manage_options', 'yt-info', 'yiw_settings_page' );
	add_action( 'admin_init', 'register_yiw_settings' );
}
// registers bbPress Ultimate settings and options fields
function register_yiw_settings() {
	register_setting( 'ytiw-settings', 'ytiw_s_1' );
	register_setting( 'ytiw-settings', 'ytiw_s_2' );
	register_setting( 'ytiw-settings', 'ytiw_s_3' );
	register_setting( 'ytiw-settings', 'ytiw_s_4' );
	register_setting( 'ytiw-settings', 'ytiw_s_5' );
	register_setting( 'ytiw-settings', 'ytiw_s_6' );
}
// outputs content in the plugin's settings page (options-general.php?page=bbpress_ultimate)
function yiw_settings_page() {
	?>
		<div class="wrap">
			<p class="yiw-nav">
				<a href="options-general.php?page=yt-info" <?php echo ( ! isset( $_GET["pg"] ) || $_GET["pg"] !== "settings" && $_GET["pg"] !== "pro" ) ? "style=\"color: #444;text-decoration: none;\"" : ''; ?>>Generate shortcodes</a>
				&vert;
				<a href="options-general.php?page=yt-info&pg=settings" <?php echo ( isset( $_GET["pg"] ) && $_GET["pg"] == "settings" ) ? "style=\"color: #444;text-decoration: none;\"" : ''; ?>>Settings</a>
			</p>
			<?php
			if ( isset( $_GET["pg"] ) && $_GET["pg"] == "settings" ) {
				?>
					<h1>Settings</h1>
					<form method="post" action="options.php">
					    <?php
					    settings_fields( 'ytiw-settings' );
					    do_settings_sections( 'ytiw-settings' );
						?>
						<table class="widefat striped">	
							<tr>
								<td>
									<label for="ytiw-s-1">'Latest uploads' tab's defaut name:</label>
								</td>
								<td>
									<input type="text" name="ytiw_s_1" value="<?php echo esc_attr( get_option('ytiw_s_1') ); ?>" id="ytiw-s-1" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="ytiw-s-2">'Popular uploads' tab's defaut name:</label>
								</td>
								<td>
									<input type="text" name="ytiw_s_22" value="<?php echo esc_attr( get_option('ytiw_s_2') ); ?>" id="ytiw-s-2" />
								</td>
							</tr>
							<tr>
								<td>						
									<label for="ytiw-s-3">'Channel info' tab's defaut name:</label>
								</td>
								<td>
									<input type="text" name="ytiw_s_3" value="<?php echo esc_attr( get_option('ytiw_s_3') ); ?>" id="ytiw-s-3" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="ytiw-s-4">Default cache clearing period:</label>
								</td>
								<td>
									<input type="number" name="ytiw_s_4" value="<?php echo esc_attr( get_option('ytiw_s_4') ); ?>" id="ytiw-s-4" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="ytiw-s-5">Default max videos to show in 'latest' & 'popular' tabs:</label>
								</td>
								<td>
									<input type="number" name="ytiw_s_5" value="<?php echo esc_attr( get_option('ytiw_s_5') ); ?>" id="ytiw-s-5" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="ytiw-s-6">Custom CSS:</label>
									<p>
										<sub>Here's the plugin <a href="<?php echo plugin_dir_url( __FILE__ );?>style.css" target="_blank">style file</a>, if you want to look up some CSS selectors</sub>
									</p>
								</td>
								<td>
									<textarea name="ytiw_s_6" id="ytiw-s-6" rows="5"><?php echo esc_attr( get_option('ytiw_s_6') ); ?></textarea>
								</td>
							</tr>
							<tr>
								<td>						
									<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Settings">
									<label for="clear_caches" class="button" onclick="return confirm('Are you sure?');">Empty caches</label>
								</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</form>
					<form action="#" method="post" style="display: none;">
						<input type="submit" name="clear_caches" id="clear_caches" />
					</form>
				<?php

				if ( isset( $_POST["clear_caches"] ) ) {
					global $wpdb;
					$q_key = $wpdb->get_results( 
							"
							SELECT option_name
							FROM $wpdb->options
							WHERE option_name LIKE '%force_update%' AND option_value = 0
							"
						);
					$c_count = count($q_key);
					foreach ( $q_key as $meta ) {
						$name = $meta->option_name;
						$prfx = substr($name, 0, 3);
						$prfx2 = substr($name, 0, 7);
						if ( $prfx == "yiw" || $prfx2 == "liteyiw" ) {
							update_option($name, '1');
						}
					}
					if ( $c_count > 0 )
						echo "<script>window.alert(\"Cache cleared successfully for $c_count item(s)\")</script>";
					else
						echo "<script>window.alert(\"No caches to clear.\")</script>";
				}
			}
			if ( ! isset( $_GET["pg"] ) || $_GET["pg"] !== "settings" && $_GET["pg"] !== "pro" ) {
				?>
					<h1>Shortcodes Generator</h1>
					<p>Fill out this quick form to generate a shortcode to use:</p>
				    <form action="#gen-msg" method="post">
				        <?php
						$atts = '';
						$html = "";
						$val_1 = "";
						$val_2 = "";
						$val_3 = "";
						$val_4 = "";
						$val_5 = "";
						$val_6 = "";
						if ( isset( $_POST["yiw_scd_submit"] ) && $_POST["yiw_scd_id"] != '' ) {
							$val_1 = ( isset( $_POST["yiw_scd_id"] ) ) ? esc_attr( $_POST["yiw_scd_id"] ) : "";
							$val_2 = ( isset( $_POST["yiw_scd_is_id"] ) ) ? esc_attr( $_POST["yiw_scd_is_id"] ) : "";
							$val_3 = ( isset( $_POST["yiw_scd_max"] ) ) ? esc_attr( $_POST["yiw_scd_max"] ) : "";
							$val_4 = ( isset( $_POST["yiw_scd_h"] ) ) ? esc_attr( $_POST["yiw_scd_h"] ) : "";
							$val_5 = ( isset( $_POST["yiw_scd_w"] ) ) ? esc_attr( $_POST["yiw_scd_w"] ) : "";
							$val_6 = ( isset( $_POST["yiw_scd_cc"] ) ) ? esc_attr( $_POST["yiw_scd_cc"] ) : "";
							$id = ( isset( $_POST["yiw_scd_id"] ) ) ? $atts .= "channel=\"". esc_attr( $_POST["yiw_scd_id"] ). "\"" : '';
							$is_id = ( isset( $_POST["yiw_scd_is_id"] ) ) ? $atts .= " id=\"1\"" : '';
							$m = ( isset( $_POST["yiw_scd_max"] ) && $_POST["yiw_scd_max"] != ''  ) ? $atts .= " max=\"". esc_attr( $_POST["yiw_scd_max"] ). "\"" : '';
							$h = ( isset( $_POST["yiw_scd_h"] ) && $_POST["yiw_scd_h"] != '' ) ? $atts .= " height=\"". esc_attr( $_POST["yiw_scd_h"] ). "\"" : '';
							$w = ( isset( $_POST["yiw_scd_w"] ) && $_POST["yiw_scd_w"] != ''  ) ? $atts .= " width=\"". esc_attr( $_POST["yiw_scd_w"] ). "\"" : '';
							$c = ( isset( $_POST["yiw_scd_cc"] ) && $_POST["yiw_scd_cc"] != ''  ) ? $atts .= " cache=\"". esc_attr( $_POST["yiw_scd_cc"] ). "\"" : '';
							$html .= "<div id=\"gen-msg\" style=\"background-color: #fff;padding: 1em;border:1px solid #E5E5E5;\">";
							$html .= "<h3>Generated!</h3>";
							$html .= "<span>Congratulations, here's your shortcode, add it somewhere around your site:</span>";
							$html .= "<p></p>";
							$html .= "<p><textarea onclick=\"this.select();\" rows=\"2\" cols=\"70\" style=\"background-color: #fff;display: inline-block;padding: .5em 1em;font-family: Consolas,Monaco,monospace;border: 1px solid #C7C7C7;max-width:100%;\">[yt-info $atts]</textarea></p>";
							$html .= "<p></p><span>Once used, the data will be imported to database.</span>";
							$html .= "</div>";
						}
						if ( isset( $_POST["yiw_scd_submit"] ) && ! isset( $_POST["yiw_scd_id"] ) ) {
							$html .= "<div id=\"gen-msg\" style=\"background-color: #fff;padding: 1em;border:1px solid #E5E5E5;\">";
							$html .= "<p><strong>Please fill out the required fields to generate a shortcode.</strong></p>";
							$html .= "</div>";
						}
						?>
						<table class="widefat striped">	
							<tr>
								<td>
									<label for="yiw_scd_id">YouTube username or channel ID: <i>(required)</i></label>
								</td>
								<td>
									<input type="text" name="yiw_scd_id" id="yiw_scd_id" value="<?php echo $val_1; ?>" required="required" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="yiw_scd_is_id">Thick this if you are providing a channel ID above:</label>
								</td>
								<td>
									<input type="checkbox" name="yiw_scd_is_id" <?php if ( $val_2 != "" ) echo "checked=\"checked\""; ?> id="yiw_scd_is_id" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="yiw_scd_max">Max videos to show: <i>(optional)</i></label>
								</td>
								<td>
									<input type="number" name="yiw_scd_max" value="<?php echo $val_3; ?>" id="yiw_scd_max" max="50" min="1" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="yiw_scd_h">Videos height: <i>(optional)</i></label>
								</td>
								<td>
									<input type="number" name="yiw_scd_h" value="<?php echo $val_4; ?>" id="yiw_scd_h" max="5000" min="10" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="yiw_scd_w">Videos width: <i>(optional)</i></label>
								</td>
								<td>
									<input type="number" name="yiw_scd_w" value="<?php echo $val_5; ?>" id="yiw_scd_w" max="5000" min="10" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="yiw_scd_cc">Clear cache every <code>?</code> hour(s) <i>(optional)</i></label>
								</td>
								<td>
									<input type="number" name="yiw_scd_cc" value="<?php echo $val_6; ?>" id="yiw_scd_cc" max="200" min="1" />
								</td>
							</tr>
							<tr>
								<td>
									<input type="submit" name="yiw_scd_submit" value="Generate Shortcode!" class="button" />
								</td>
								<td>&nbsp;</td>
							</tr>
						</table>
				    </form>
				    <?php echo $html; ?>
					</div>
				<?php
			}
			if ( isset( $_GET["pg"] ) && $_GET["pg"] == "pro" ) {
				?>
					<style type="text/css">
						.yiw-pro img {
						    box-shadow: 0 0 3px #7D7171;
						    position: relative;
						    max-width: 100%;
						    display: inline-block;
						    margin: 6px 0;
						    vertical-align: top;
						}
						.yiw-pro h2 {
							text-decoration: underline;
						}
						.yiw-pro a {
    						background-color: #D54E21!important;
							border-color: #A84423!important;
							font-size: 115%;
						}
						.yiw-footer {
							display: none;
						}
					</style>
					<div class="yiw-pro">
						<h2>Premium Plugin in screenshots</h2>
						<p>
							<a href="http://codecanyon.net/item/youtube-info-widgets-channel-video-cards-more/12594315?ref=elhardoum" class="button button-primary" target="_new">Find out more / purchase on CodeCanyon</a>
						</p>
						<p>
							<img src="https://0.s3.envato.com/files/146255203/01-screenshot-1.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/02-screenshot-2.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/03-screenshot-3.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/04-screenshot-4.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/05-screenshot-5.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/06-screenshot-6.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/07-screenshot-7.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/08-screenshot-8.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/09-screenshot-9.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/10-screenshot-10.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/11-screenshot-11.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/12-screenshot-12.png" alt="screenshot">
							<img src="https://0.s3.envato.com/files/146255203/13-screenshot-13.png" alt="screenshot">
						</p>
						<p>
							<a href="http://codecanyon.net/item/youtube-info-widgets-channel-video-cards-more/12594315?ref=elhardoum" class="button button-primary" target="_new">Find out more / purchase on CodeCanyon</a>
						</p>
					</div>
				<?php
			}
		?>
			<style type="text/css">
				.yiw-footer { border: 1px solid #D5D5D5; padding: 1em;line-height: 2; }
				.yiw-footer a { margin-bottom: 2px!important; }
				.yiw-footer .dashicons { vertical-align: bottom;font-size: 140%;padding-right: 3px; }
			</style>
			<fieldset class="yiw-footer">
				<p>Thank you for using our plugin. Enjoying it? then consider rating it! we depened on your ratings and reviews to improve the plugin's performance and optimize it:</p>
				<a class="button" href="https://wordpress.org/support/plugin/youtube-information-widget">
					<span class="dashicons dashicons-wordpress"></span>Support forum on WordPress.org &raquo;
				</a>
				<br style="clear: both;"> 
				<a class="button" href="https://twitter.com/intent/tweet?text=@samuel_elh%20">
					<span class="dashicons dashicons-twitter"></span>Get support on Twitter, mention '@samuel_elh' &raquo;
				</a>
				<br style="clear: both;"> 
				<a class="button" href="https://wordpress.org/support/view/plugin-reviews/youtube-information-widget?rate=5#postform">
					<span class="dashicons dashicons-admin-comments"></span>Rate &amp; Review this plugin &raquo;
				</a>
				<br style="clear: both;">
				<a class="button" href="https://twitter.com/intent/follow?screen_name=samuel_elh">
					<span class="dashicons dashicons-twitter"></span>Follow @samuel_elh &raquo;
				</a>
				<br style="clear: both;">
				<a class="button" href="https://twitter.com/intent/tweet?text=Check%20out%20YouTube%20Information%20Widget%20plugin%20on%20WordPress%20https://wordpress.org/plugins/youtube-information-widget/%20via%20@samuel_elh">
					<span class="dashicons dashicons-twitter"></span>Share on Twitter &raquo;
				</a>
				<br style="clear: both;">
				<a href="options-general.php?page=yt-info&pg=pro" class="button">
					<span class="dashicons dashicons-info"></span>Premium version &raquo;
				</a>
			</fieldset>

		</div>
		<?php
}