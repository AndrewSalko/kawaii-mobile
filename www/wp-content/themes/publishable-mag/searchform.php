<form method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url() ); ?>" _lpchecked="1">
	<fieldset>
		<input type="text" aria-label="Search this site" name="s" id="s" value="<?php esc_attr_e('Search this site...','publishable-mag'); ?>" onblur="if (this.value == '') {this.value = '<?php esc_attr_e('Search this site...','publishable-mag'); ?>';}" onfocus="if (this.value == '<?php esc_attr_e('Search this site...','publishable-mag'); ?>') {this.value = '';}" >
		<input type="submit" value="<?php esc_attr_e( 'Search', 'publishable-mag' ); ?>" />
	</fieldset>
</form>
