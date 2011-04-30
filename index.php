<?php
/**
 * w-log Model
 *
 * @package w-log
 * @copyright (C) 2010 John Cox
 *
 * @subpackage Model
 */

    /* This is the only configuration that you need to do.
     * Please set the following information with a MySQL user
     * That has appropriate permissions to SELECT, TRUNCATE and
     * SET GLOBALs
     */

    // SET HERE
    // Username
    $dbuser = 'root';
    // Password
    $dbpass = 'root';
    // HOST
    $dbhost = 'localhost';

    /* No need to edit anything else.  */

    include_once 'api/w-log.php';
    $w = new wLog($dbuser, $dbpass, $dbhost);


    // Determine what we are displaying
    if (isset($_GET['phase'])){
        $phase = htmlspecialchars($_GET['phase']);
    } elseif (isset($_POST['phase'])){
        $phase = htmlspecialchars($_POST['phase']);
    } else {
        $phase = 'load_page';
    }

    // Display
    switch(strtolower($phase)) {

        case 'load_page':
            $w->setGeneralLog();
            $base_url = "http://".$_SERVER['HTTP_HOST']."/";
            include_once 'templates/load_page.tpl.php';

        break;

        case 'display_log':
            $gl = $w->getGeneralLog();
            if ($gl){
                $thread = '';
                $db = '';
                $count_full = 0;
                $count_selects = 0;

                foreach ($gl as $key => $var){
                    if ( $var['command_type'] == 'Connect' ) {
                        unset($gl[$key]);

                    } elseif ( $var['command_type'] == 'Init DB' ) {
                        $db = $var['query'];
                        $thread = $var['thread_id'];
                        $gl[$key]['set_db'] = true;
                        unset($gl[$key]);

                    } elseif ( (preg_match("/\SELECT\b/i", $var['query'])) AND (!preg_match("/\mysql.general_log\b/i", $var['query'])) AND (!preg_match("/\EXPLAIN\b/i", $var['query']))  ){
                        $gl[$key]['id'] = 'query_'.$key;
                        $count_selects = $count_selects + 1;
                        if ($thread = $var['thread_id']){
                            $gl[$key]['explain'] = $w->explainQuery($db, $var['query']);
                            if ($gl[$key]['explain']) {
                                foreach ($gl[$key]['explain'] as $e){
                                    if ( $e['type'] == 'ALL' ) {
                                        $count_full = $count_full + 1;
                                    }
                                }
                            }
                        }

                    } elseif (empty($var['query'])){
                        unset($gl[$key]);

                    } elseif ( preg_match("/\mysql.general_log\b/i", $var['query']) ) {
                        unset($gl[$key]);

                    } elseif ( preg_match("/\EXPLAIN\b/i", $var['query']) ) {
                        unset($gl[$key]);

                    } elseif ( preg_match("/\SET NAMES\b/i", $var['query']) ) {
                        unset($gl[$key]);

                    } elseif ( preg_match("/\SET GLOBAL\b/i", $var['query']) ) {
                        unset($gl[$key]);

                    } else {
                        $gl[$key]['id'] = 'query_'.$key;
                        $gl[$key]['explain'] = false;
                    }
                 }
             }
             $truncate = $w->truncateGeneralLog();
             include_once 'templates/display_log.tpl.php';
        break;

        case 'truncate_log':
            $truncate = $w->truncateGeneralLog();
            echo 'Log is Empty';
            return;
        break;

        case 'disable_log':
            $truncate = $w->truncateGeneralLog();
            $disable = $w->disableGeneralLog();
            echo 'Query Log is Off';
            return;
        break;

        case 'enable_log':
            $truncate = $w->truncateGeneralLog();
            $enble = $w->setGeneralLog();
            echo 'Query Log is On';
            return;
        break;

    }
?>