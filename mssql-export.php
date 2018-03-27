 <?php

// This is sample is  for mssql server database
$serverName = "//serverName\instanceName";
$connectionInfo = array( "Database"=>"Dbname", "UID"=>"user", "PWD"=>"pass", 'ReturnDatesAsStrings'=>true);
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    //echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
// your query here
$sql = "SELECT NULL AS LedgerID,
       TP.treatplanid AS treatplanid,
       TP.PATID AS PATID,
       NULL AS 'DOD Date',
       TP.PROPDATE AS 'Proposed Date',
       TP.TH AS TH,
       TP.CODE AS Code,
       TP.FEE AS Fee,
       Ledger.BA AS BA,
       TP.STATUS AS STATUS,
       CAST(CAST(TP.treatplanid AS int) AS VARCHAR)+ '-Open-Tx' AS IDCallType
FROM [Denticon].[dbo].[TREATPLAN]  AS TP
ORDER BY TP.PROPDATE DESC";

// /$params = array(TP.treatplanid);
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


while( $row = sqlsrv_fetch_object($stmt) ) {
      //echo  $row->treatplanid;
	 
    // $data['treatplanid'] = $row->treatplanid;
    // $data['PATID'] = $row->PATID;
    $export[] = $row;
    // echo "))))))))))))))))";
    // echo "<pre>";
    // var_dump($export);
    // echo "</pre>";
}

sqlsrv_free_stmt($stmt);

array_to_csv_download($export);

function array_to_csv_download($array, $filename = "Open TX Records.csv", $delimiter=",") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w');
    $fields = array('LedgerID', 'treatplanid', 'PATID', 'DOD Date', 'Proposed Date', 'TH', 'Code', 'Fee', 'BA', 'STATUS', 'IDCallType'); 
    // loop over the input array
    fputcsv($f, $fields, $delimiter); 
    foreach ($array as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, get_object_vars($line), $delimiter); 
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}



?>