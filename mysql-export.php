<?php


// This is sample is  for mysql server database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "location";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Create connection 2
$conn2 = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$query= $conn->query(" SELECT * FROM library.history "
					);

$query2 = $conn2->query(" SELECT * FROM location.offices ");


// $res = array($query);
// $res2 = array($query2);

// $final = array_merge($res,$res2);
//   	echo "<pre>";
// 	print_r($final);
// 	 echo "</pre>";


while ($result = $query->fetch_assoc()){
   $res[$result['id']] = $result;
  
 //  	echo "<pre>";
	// print_r($res);
	//  echo "</pre>";
  }

while ($result = $query2->fetch_assoc()){
   $res2[$result['id']] = $result;
  
 //  	echo "<pre>";
	// print_r($result);
	//  echo "</pre>";
  }
   
 	echo "<pre>";
	print_r($res);
	// print_r($r2);
	 echo "</pre>";
	 exit;

	 foreach($res as $key => $r)
	 {
	 	foreach($res2 as $key2 => $r2)
	 	{
	 		foreach($r2 as $rkey => $r3)
	 		{
	 			if($key == $key2)
		 		{
		 			
	 				$res[$key][$rkey] = $r3;
	 			// 		echo "<pre>";
					// // print_r($res);
					// //  echo "</pre>";
	
		 		// 	exit;
		 		}
	 		}
	 		
	 	}
	 }

 // 	echo "<pre>";
	// // print_r($r);
	// print_r($res);
	// // print_r($rkey);
	// print_r($r3);
	// print_r($key);
	// print_r($key2);
	// // print_r($res);
	//  echo "</pre>";
	//  exit;


// while ($result2 = $query2->fetch_assoc()){
//    $allProvider[] = $result2;
  
//   	echo "<pre>";
// 	print_r($result2);
// 	 echo "</pre>";
//   }



// $res1 = array($query);

// $res2 = array($query2);

// // $arr1 = mysqli_fetch_array($query);
// // $arr2 = mysqli_fetch_array($query2);

// $q = array_merge($res1, $res2);
// echo "<pre>";
// print_r($q);
// echo "</pre>";

//  $query = array_merge($res1, $res2);
// echo "<pre>";
// print_r($query);
// echo "</pre>";



// foreach ($query as $q) {
// 	echo "<pre>";
// 	print_r($query);
// 	echo "</pre>";
// }

// if($query->num_rows > 0) {
//     $delimiter = ",";
//     $filename = "members_" . date('Y-m-d') . ".csv"; 
    
//     //create a file pointer
//     $f = fopen('php://memory', 'w');
    
//     //set column headers
//     $fields = array('id', 'name', 'author', 'published', 'address');
//     fputcsv($f, $fields, $delimiter);
    
//     //output each row of the data, format line as csv and write to file pointer
//     while($row = $res3){
//         $lineData = array($row['id'], $row['name'], $row['author'], $row['published']);

//         fputcsv($f, $lineData, $delimiter);
//     }


    // $fields2 = array('id', 'name', 'address');
    // fputcsv($f, $fields2, $delimiter);

    
    
    // //output each row of the data, format line as csv and write to file pointer
    // while($row = $query2->fetch_assoc()){
    //     $lineData = array($row['id'], $row['name'], $row['address']);

    //     fputcsv($f, $lineData, $delimiter);
    // }







    
    //move back to beginning of file
//     fseek($f, 0);
    
//     //set headers to download file rather than displayed
//     header('Content-Type: text/csv');
//     header('Content-Disposition: attachment; filename="' . $filename . '";');
    
//     //output all remaining data on a file pointer
//     fpassthru($f);
// }
// exit;



function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w'); 
    // loop over the input array

    $fields = array('id', 'name', 'author', 'published', 'address', 'test');
    fputcsv($f, $fields, $delimiter);
    foreach ($array as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter); 
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

//array_to_csv_download($res);

?>
