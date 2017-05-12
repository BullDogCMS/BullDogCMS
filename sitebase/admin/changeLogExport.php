<?php
//Make sure user is logged in or else cannot do the export
session_start();
if(!isset($_SESSION['user']))

    if(!$_SESSION["username"])
    {
        //Do not show protected data, redirect to login...
        header('Location: login.php');
    }

include "../includes/db.php";

// Redirect output to a client’s web browser (Excel2007)
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ChangeLogExport.csv"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

//Excel Export code:  http://stackoverflow.com/questions/15699301/export-mysql-data-to-excel-in-php
//$sep = "\t";
$sep = ",";

$sql="SELECT * FROM changeLog";
$resultt = mysqli_query($connection, $sql);
while ($property = mysqli_fetch_field($resultt)) {
    //echo $property->name."\t";
    echo $property->name.",";
}

print("\n");

while($row = mysqli_fetch_row($resultt))
{
    $schema_insert = "";
    for($j=0; $j< mysqli_num_fields($resultt);$j++)
    {
        if(!isset($row[$j]))
            $schema_insert .= "NULL".$sep;
        elseif ($row[$j] != "")
            $schema_insert .= "$row[$j]".$sep;
        else
            $schema_insert .= "".$sep;
    }
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    //$schema_insert .= "\t";
    $schema_insert .= ",";
    print(trim($schema_insert));
    print "\n";
}

/*

$filename = date('m-d-y') . "changelog.csv";

header("Content-type: text/csv");
header("Content-Disposition: attachment; $filename.csv");
header("Pragma: no-cache");
header("Expires: 0");

//get all changelog values.
$changelog = "SELECT * FROM changeLog";
$changelogQuery = mysqli_query($connection, $changelog);


$f = fopen('php://temp/', 'wt');
$first = true;
while($row = mysqli_fetch_assoc($changelogQuery)) {
    if ($first) {
        fputcsv($f, array_keys($row));
        $first = false;
    }
    fputcsv($f, $row);
}

//close db connection after transaction.
mysqli_close($connection);
rewind($f);

echo $filename;
fpassthru($f);
exit;
*/
?>