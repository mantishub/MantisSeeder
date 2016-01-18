<?php
/**************************************************************************
 MantisBT Seeder Plugin
 Copyright (c) MantisHub - Victor Boctor
 All rights reserved.
 MIT License
 **************************************************************************/

auth_ensure_user_authenticated();
access_ensure_global_level( ADMINISTRATOR );

# helper_begin_long_process();

require_once( dirname( dirname( __FILE__ ) ) . '/core/Seeder.php' );

html_page_top1();
html_meta_redirect( 'view_all_bug_page.php', 0 );
html_page_top2();

$g_enable_email_notification = OFF;
$t_seeder = new Seeder();
$t_seeder->seed(100);

html_page_bottom();
