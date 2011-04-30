 <?php
 if($gl){
    echo "<h2>$count_selects SELECTs on page</h2>";
    echo "<h2>$count_full Full Table Scans</h2>";
    foreach ($gl as $g){
    echo "<p><strong>Query:</strong> {$g['query']}</p>";
    echo "<p><strong>Event Time:</strong> {$g['event_time']}</p>";

    if ( (isset($g['explain'])) AND ($g['explain']) ){
        echo '<table>'
            .'<caption><a href="http://dev.mysql.com/doc/refman/5.0/en/using-explain.html" title="documentation for EXPLAIN">Query Execution Plan</a></caption>'
            .'<thead>'
            .'<tr class="rounded">'
            .'<th>Select Type</th>'
            .'<th>Table</th>'
            .'<th>Type</th>'
            .'<th>Possible Keys</th>'
            .'<th>Key Used</th>'
            .'<th>Key Size</th>'
            .'<th>Ref</th>'
            .'<th>Rows</th>'
            .'<th>Extra</th>'
            .'</tr>'
            .'</thead>'
            .'<tbody>';
            foreach ($g['explain'] as $explain) {
                echo '<tr>'
                    ."<td>{$explain['select_type']}</td>"
                    ."<td>{$explain['table']}</td>"
                    ."<td>{$explain['type']}</td>";
                    if ( $explain['type'] == 'ALL' ){
                        $explain_type_bad = true;
                    } else {
                        if (!isset($explain_type_bad)){
                            $explain_type_bad = false;
                        }
                    }
                echo "<td>{$explain['possible_keys']}</td>"
                    ."<td>{$explain['key']}</td>"
                    ."<td>{$explain['key_len']}</td>"
                    ."<td>{$explain['ref']}</td>"
                    ."<td>{$explain['rows']}</td>"
                    ."<td>{$explain['extra']}</td>"
                    .'</tr>';
            }
        echo '</tbody>'
        .'</table>';
        if ($explain_type_bad){
            echo "<p><strong>Tip:</strong> This query has a type of INDEX or ALL meaning that it is reading the entire index, or the entire table in order to get a result, which is rather bad.  Check your indexes on this table against any JOIN value reference or WHERE reference";
            $explain_type_bad = false;
        }
    } else {
        echo '<p><strong>EXPLAIN for SELECT Type Queries Only</strong></p>';
    }

    echo '<hr>';

    }
} else {
  echo 'General Log is Empty!';
  $empty_log = true;
}
?>