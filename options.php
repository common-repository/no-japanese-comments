<?php
function no_japanese_comments_register_settings() {
	add_option('no_japanese_comments_notice', '申し訳ありませんが、ブログは日本語でコメントをお受けしておりません。
Sorry, but the blog do not accept comments in Japanese language.');
	add_option('no_japanese_comments_mode', 'wordpress');
	register_setting('no_japanese_comments_options', 'no_japanese_comments_notice');
	register_setting('no_japanese_comments_options', 'no_japanese_comments_mode');
}
add_action('admin_init', 'no_japanese_comments_register_settings');

function no_japanese_comments_register_options_page() {
	add_options_page(__('No Japanese Comments Options Page', NO_JAPANESE_COMMENTS_TEXT_DOMAIN), __('No Japanese Comments', NO_JAPANESE_COMMENTS_TEXT_DOMAIN), 'manage_options', NO_JAPANESE_COMMENTS_TEXT_DOMAIN.'-options', 'no_japanese_comments_options_page');
}
add_action('admin_menu', 'no_japanese_comments_register_options_page');

function no_japanese_comments_get_select_option($select_option_name, $select_option_value, $select_option_id){
	?>
	<select name="<?php echo $select_option_name; ?>" id="<?php echo $select_option_name; ?>">
		<?php
		for($num = 0; $num < count($select_option_id); $num++){
			$select_option_value_each = $select_option_value[$num];
			$select_option_id_each = $select_option_id[$num];
			?>
			<option value="<?php echo $select_option_id_each; ?>"<?php if (get_option($select_option_name) == $select_option_id_each){?> selected="selected"<?php } ?>>
				<?php echo $select_option_value_each; ?>
			</option>
		<?php } ?>
	</select>
	<?php
}

function no_japanese_comments_options_page() {
?>
<div class="wrap">
	<h2><?php _e("No Japanese Comments Options Page", NO_JAPANESE_COMMENTS_TEXT_DOMAIN); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields('no_japanese_comments_options'); ?>
		<h3><?php _e("General Options", NO_JAPANESE_COMMENTS_TEXT_DOMAIN); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="no_japanese_comments_notice"><?php _e("Disallow Japanese Language Comments Notice: ", NO_JAPANESE_COMMENTS_TEXT_DOMAIN); ?></label></th>
					<td>
						<textarea name="no_japanese_comments_notice" id="no_japanese_comments_notice" rows="5" cols="60"><?php echo get_option("no_japanese_comments_notice"); ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="no_japanese_comments_mode"><?php _e("Blog Comments Mode: ", NO_JAPANESE_COMMENTS_TEXT_DOMAIN); ?></label></th>
					<td>
						<?php no_japanese_comments_get_select_option("no_japanese_comments_mode", array(__('Wordpress Default', NO_JAPANESE_COMMENTS_TEXT_DOMAIN), __('AJAX', NO_JAPANESE_COMMENTS_TEXT_DOMAIN)), array('wordpress', 'ajax')); ?>
						<?php _e("(If you don't know what it means, Please try both)", NO_JAPANESE_COMMENTS_TEXT_DOMAIN); ?>
					</td>
				</tr>
			</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}
?>