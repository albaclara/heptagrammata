<?php

function import_csv_to_array($file,$enclosure = '"')
{

    // Let's get the content of the file and store it in the string
    $csv_string = file_get_contents($file);

    // Let's detect what is the delimiter of the CSV file
    $delimiter = detect_delimiter($csv_string);

    // Get all the lines of the CSV string
    $lines = explode("n", $csv_string);

    // The first line of the CSV file is the headers that we will use as the keys
    $head = str_getcsv(array_shift($lines),$delimiter,$enclosure);

    $array = array();

    // For all the lines within the CSV
    foreach ($lines as $line) {

        // Sometimes CSV files have an empty line at the end, we try not to add it in the array
        if(empty($line)) {
            continue;
        }

        // Get the CSV data of the line
        $csv = str_getcsv($line,$delimiter,$enclosure);

        // Combine the header and the lines data
        $array[] = array_combine( $head, $csv );

    }

    // Returning the array
    return $array;
}

function export_data_to_csv($data,$filename='export',$delimiter = ';',$enclosure = '"') {
    header("Content-disposition: attachment; filename=filename.csv");
    header("Content-Type: text/csv");
    $fp = fopen("php://output", 'w');
    fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
    foreach ($data as $letter) {
        $line = array();
        $line[0] = $letter;
        fputcsv($fp, $line,$delimiter,$enclosure);
    }
    if (fclose($fp)) {
        echo "ok";
    } else {
        echo "ko";
    }
    die();
}
