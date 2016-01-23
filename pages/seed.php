<?php
/**************************************************************************
 MantisBT Seeder Plugin
 Copyright (c) MantisHub - Victor Boctor
 All rights reserved.
 MIT License
 **************************************************************************/

access_ensure_global_level( ADMINISTRATOR );

require_once( dirname( dirname( __FILE__ ) ) . '/core/Seeder.php' );

html_page_top1();
html_meta_redirect( plugin_page( 'config_page') );
html_page_top2();

$f_create_issues = gpc_isset( 'create_issues' );

$g_enable_email_notification = OFF;
$t_seeder = new Seeder();

if( $f_create_issues !== OFF ) {
    $t_project_ids = $t_seeder->createProjects();
    $t_seeder->createIssues( $t_project_ids );
}

echo '<div class="success-msg">';
echo lang_get( 'operation_successful' );
echo '</div>';

html_page_bottom();
