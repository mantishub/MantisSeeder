<?php
/**************************************************************************
 MantisBT / MantisHub Seeder Plugin
 Copyright (c) MantisHub - Victor Boctor
 All rights reserved.
 MIT License
 **************************************************************************/

/**
 * MantisSeederPlugin Class
 */
class MantisSeederPlugin extends MantisPlugin {
	/**
	 * A method that populates the plugin information and minimum requirements.
	 * @return void
	 */
	function register() {
		$this->name = plugin_lang_get( 'title' );
		$this->description = plugin_lang_get( 'description' );
		$this->page = 'config_page';

		$this->version = '1.0.0';
		$this->requires = array(
			'MantisCore' => '1.3.0',
		);

		$this->author = 'Victor Boctor';
		$this->contact = 'victor@mantishub.net';
		$this->url = 'http://www.mantishub.com';
	}
}
