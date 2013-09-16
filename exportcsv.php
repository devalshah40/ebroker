<?php
//Get the result of the query as a CSV stream.
//http://www.bin-co.com/php/scripts/csv_import_export/

function CSVExport($query) {
    $sql_csv = mysql_query($query) or die("Error: " . mysql_error()); //Replace this line with what is appropriate for your DB abstraction layer
    
    header("Content-type:text/octect-stream");
    header("Content-Disposition:attachment;filename=data.csv");
    while($row = mysql_fetch_row($sql_csv)) {
        print '"' . stripslashes(implode('","',$row)) . "\"\n";
    }
    exit;
}

CSVExport("SELECT name,username,email,url FROM User WHERE status=1");


 
 $host = '127.0.0.1'; // <--  db address
 $user = 'user'; // <-- db user name
 $pass = 'password'; // <-- password
 $db = 'db_name'; // db's name
 $table = 'table_name'; // table you want to export
 $file = 'file_name'; // csv name.
 
$link = mysql_connect($host, $user, $pass) or die("Can not connect." . mysql_error());
 mysql_select_db($db) or die("Can not connect.");
 
$result = mysql_query("SHOW COLUMNS FROM ".$table."");
 $i = 0;
 
if (mysql_num_rows($result) > 0) {
while ($row = mysql_fetch_assoc($result)) {
$csv_output .= $row['Field'].";";
$i++;}
}
$csv_output .= "\n";
 $values = mysql_query("SELECT * FROM ".$table."");
 
while ($rowr = mysql_fetch_row($values)) {
for ($j=0;$j<$i;$j++) {
$csv_output .= $rowr[$j]."; ";
}
$csv_output .= "\n";
}
 
$filename = $file."_".date("d-m-Y_H-i",time());
 
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
 
print $csv_output;
 
exit;
 
 
 
 
 
 // output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Column 1', 'Column 2', 'Column 3'));

// fetch the data
mysql_connect('localhost', 'username', 'password');
mysql_select_db('database');
$rows = mysql_query('SELECT field1,field2,field3 FROM table');

// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
?>