<?php
/**************************************************************************
 MantisBT Seeder Plugin
 Copyright (c) MantisHub - Victor Boctor
 All rights reserved.
 MIT License
 **************************************************************************/

access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

require_once( dirname( dirname( __FILE__ ) ) . '/core/Seeder.php' );

html_page_top();
?>

<br />
<div class="form-container">
<form action="<?php echo plugin_page( 'seed' ) ?>" method="post">
<fieldset>
	<legend>
		<?php echo plugin_lang_get( 'title' ) ?>
	</legend>

	<?php echo form_security_field( 'plugin_MantisSeeder_config' ) ?>

	<!-- Import Access Level  -->
	<div class="field-container">
		<label for="create_issues">
			<span><?php echo plugin_lang_get( 'create_issues' ) ?></span>
		</label>
		<span class="select">
		    <?php echo sprintf( plugin_lang_get( 'create_issues_desc' ), MANTIS_SEEDER_ISSUES_COUNT ); ?>
		    <br /><br />
    		<input type="submit" id="create_issues" value="<?php echo plugin_lang_get( 'create_issues' ) ?>"/>
		</span>
		<span class="label-style"></span>
	</div>

</fieldset>
</form>
</div>

<?php
html_page_bottom();
