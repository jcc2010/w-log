<?php
/**
 * w-log Class
 *
 * @package w-log
 * @copyright (C) 2010 John Cox
 *
 * @subpackage API
 */

class wLog
{

    function __construct($dbuser, $dbpass, $dbhost)
    {
        $this->dbconn = mysql_connect($dbhost, $dbuser, $dbpass);
        if (!$this->dbconn) {
            return false;
        }
    }

    public function setGeneralLog()
    {
        $query = "SET GLOBAL general_log = 'ON';";
        if (!mysql_query($query)) return false;
        $query = "SET GLOBAL log_output = 'TABLE';";
        if (!mysql_query($query)) return false;
        return true;
    }

    public function disableGeneralLog()
    {
        $query = "SET GLOBAL general_log = 'OFF';";
        if (!mysql_query($query)) return false;
        return true;
    }

    public function truncateGeneralLog()
    {
        $query = "TRUNCATE mysql.general_log";
        if (!mysql_query($query)) return false;
    }

    public function getGeneralLog()
    {
        $log = array();
        $query = 'SELECT * FROM mysql.general_log';
        if ($result = mysql_query($query)){
            while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $log[] = array('event_time'     => $row['event_time'],
                               'thread_id'      => $row['thread_id'],
                               'command_type'   => $row['command_type'],
                               'query'          => $row['argument']);
            }
            mysql_free_result($result);

            return $log;
        } else {
            return false;
        }
    }

    public function explainQuery($db, $incoming_query)
    {
        mysql_select_db($db);

        if ($result = mysql_query("EXPLAIN $incoming_query")){
            while ($row = mysql_fetch_assoc($result)){
                $log[] = array('select_type'    => $row['select_type'],
                               'table'          => $row['table'],
                               'type'           => $row['type'],
                               'possible_keys'  => $row['possible_keys'],
                               'key'            => $row['key'],
                               'key_len'        => $row['key_len'],
                               'ref'            => $row['ref'],
                               'rows'           => $row['rows'],
                               'extra'          => $row['Extra']);
            }
            mysql_free_result($result);
            return $log;
        } else {
            return false;
        }
    }

}
