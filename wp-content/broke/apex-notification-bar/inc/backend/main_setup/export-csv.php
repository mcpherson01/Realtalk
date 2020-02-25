<?php
global $wpdb;
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
	header("Content-type: application/force-download"); 
	header('Content-Disposition: inline; filename="subscribers'.date('YmdHis').'.csv"');  
	$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix . "apexnb_subscriber");
	echo "Email, Date\r\n";
    if (count($results))  {
		foreach($results as $row) {
		$datee = $row->date;
		echo $row->email.", ".$datee."\r\n";
		}
	}else{
		$Error = $wpdb->print_error();
        die("The following error was found: $Error");
	}

// Process report request
// if (!$results ) {
// $Error = $wpdb->print_error();
// die("The following error was found: $Error");
// } else {
// // Prepare our csv download

// // Set header row values
// $csv_fields=array();
// $csv_fields[] = 'Email';
// $csv_fields[] = 'Date';
// $output_handle = @fopen( 'php://output', 'w' );
 
// 	header("Content-type: application/force-download"); 
// 	header('Content-Disposition: inline; filename="subscribers_'.date('YmdHis').'.csv"');  
// // Insert header row
// fputcsv( $output_handle, $csv_fields );

// // Parse results to csv format
// foreach($results as $row) {
// 	$leadArray = (array) $row; // Cast the Object to an array
// 	// Add row to file
// 	fputcsv( $output_handle, $leadArray );
// 	}
 
// // Close output file stream
// fclose( $output_handle ); 

// die();
// }