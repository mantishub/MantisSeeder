<?php
/**************************************************************************
 MantisBT Seeder Plugin
 Copyright (c) MantisHub - Victor Boctor
 All rights reserved.
 MIT License
 **************************************************************************/

require_once( dirname( __FILE__ ) . '/MantisPhpClient.php' );

/**
 * Seeder
 */
class Seeder
{
    /**
     * Seed the database
     * 
     * @param integer $p_issues_count The number of issues to seed.
     */
    function seed( $p_issues_count ) {
        $t_client = new MantisPhpClient( 'https://www.mantisbt.org/bugs/', '', '' );

        $t_issues_count = 0;
        $t_ids_tested = array();

        auth_attempt_script_login( 'administrator' );

        $t_project_ids = array();
        $t_project_ids[] = $this->ensure_project_exists( 'MantisBT', 'Mantis Bug Tracker' );
        $t_project_ids[] = $this->ensure_project_exists( 'MantisHub', 'MantisBT as a Service' );

        while (true) {
            $t_issue_id = rand( 19000, 20500 );
            if ( !isset( $t_ids_tested[$t_issue_id] ) ) {
                $t_ids_tested[$t_issue_id] = true;
            }

            try {
                $t_issue = $t_client->getIssue( $t_issue_id );
                $t_issues_count++;
            } catch ( SoapFault $e ) {
                if ( strstr( $e->getMessage(), 'Issue does not exist' ) ) {
                    continue;
                }
            }

            $this->ensure_user_exists( $t_issue->reporter );
            
            $t_handler_id = 0;
            
            if ( isset( $t_issue->handler ) ) {
                $this->ensure_user_exists( $t_issue->handler );
                $t_handler_id = user_get_id_by_name( $t_issue->handler->name );
            }

            $t_bug_data = new BugData;
            $t_bug_data->project_id             = $t_project_ids[rand(0, 1)];
            $t_bug_data->reporter_id            = user_get_id_by_name( $t_issue->reporter->name );
            $t_bug_data->handler_id             = $t_handler_id;
            $t_bug_data->view_state             = $t_issue->view_state->id;
            $t_bug_data->category_id            = 1;
            $t_bug_data->reproducibility        = $t_issue->reproducibility->id;
            $t_bug_data->severity               = $t_issue->severity->id;
            $t_bug_data->priority               = $t_issue->priority->id;
            $t_bug_data->projection             = $t_issue->projection->id;
            $t_bug_data->eta                    = $t_issue->eta->id;
            $t_bug_data->resolution             = $t_issue->resolution->id;
            $t_bug_data->status                 = $t_issue->status->id;
            $t_bug_data->summary                = $t_issue->summary;
            $t_bug_data->description            = $t_issue->description;

            $t_bug_id = $t_bug_data->create();

            if ( $t_issues_count == $p_issues_count ) {
                break;
            }
        }
    }

    function ensure_project_exists( $p_name, $p_description ) {
        $t_project_id = project_get_id_by_name( $p_name );
        if ( $t_project_id !== false ) {
            return $t_project_id;
        }
    
        return project_create( 'MantisBT', 'Mantis Bug Tracker', /* status: stable */ 50 );
    }

    function ensure_user_exists( $p_account_info ) {
        if ( $p_account_info === null ) {
            return;
        }
    
        $t_user_id = user_get_id_by_name( $p_account_info->name );
        
        if ( $t_user_id === false ) {
            user_create( $p_account_info->name, '', '', DEVELOPER );
    
        }
        
        return $t_user_id;
    }
}
