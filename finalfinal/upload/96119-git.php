 	<html>
	<head>
	<title>PHP Reading from a file</title>
	</head>
	<body>
	<h1>Output</h1>
	<?php
	// start of php code,
	// whats the file's name?
	$file_name = "test.txt";
	// open the file, the 'r' property means read file
	$file_handler = fopen($file_name, 'r');
	// you can change this to 'w' for write and 'a' for append
	// now that we have opened the file lets actually read it!
	
	// to read it line byt line
	$line_number = 0;
	$reading_file_line_by_line = "";
	while(!feof($file_handler)){ // basically while we havent reached the end of the file
	$line = fgets($file_handler);
	if($line_number == 0){ // if this is the first line do something. could match a string
	$line1 = $line;
	}
	$reading_file_line_by_line .= $line; // concatinate the string
	$line_number++; // increase the line count
	}
	fclose($file_handler); // close the file, * THIS IS IMPORTANT DONT FORGET TO DO THIS*
	// we have to re-open due to the file handler reading the end of the file
	$file_handler = fopen($file_name, 'r');
	// say we wanted to read the first five bytes (this is the same as the first five chars)
	$first_five_bytes = fread($file_handler, 5); // fread takes in the file handler and the amount to read
	fclose($file_handler); // once again we should close the file handler once we have all the data we need
	$file_handler = fopen($file_name, 'r'); // reopening for our next example
	// say we wanted to read the whole file, we can use the filesize property
	$whole_file = fread($file_handler, filesize($file_name)); // notice freads second parameter is a function which caluclates the size of the file.
	// we should always close the file handler, so we dont leak memory!
	fclose($file_handler);
	
	// lets do some string replacement
	$added_brs = str_replace("\n", "<br />", $whole_file);
	// this searches for \ns then replaces them with brs in the string $whole_file
	
	// lets print out our results
	print "First five bytes of the file:<b> $first_five_bytes </b> <br />\n";
	print "First line from file:<b> $line1 </b><br />\n";
	print "Proof we read file line by line:<b> $reading_file_line_by_line </b><br />\n";
	print "The whole file:<b> $whole_file </b><br />\n";
	print "The whole file with brs:<b> $added_brs </b></br>\n";
	
	// end of php
	?>
	</body>
	</html>