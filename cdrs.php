<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('./APIv3SandboxLib.php');


/* CDRs Flow:

/* Operations used:
    Request file creation
    List files
    Download File
*/

$controller = new CdrsController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
try{

//Request File Creation
$fileCreation = $controller->createCdrsFileRequest('2014', '12');
echo "<br/><br/><br/>";
echo "<b>Request File Creation Request content</b><br/>";
echo "<br/>";
echo "status: ".$fileCreation->status."<br/>";

//List Files
$files = $controller->getCdrsFiles();

echo "<br/><br/><br/>";
echo "<b>List Files Request content</b><br/>";
echo "fileNames: ".$files->fileNames[0]."<br/>";
echo "fileNames: ".$files->fileNames[1]."<br/>";
echo "fileNames: ".$files->fileNames[2]."<br/>";
echo "fileNames: ".$files->fileNames[3]."<br/>";
$fileName = $files->fileNames[0];

//Download Files
$downloadFiles = $controller->getCdrsFiles($fileName);
var_dump($downloadFiles);
echo "<br/><br/><br/>";
echo "<b>Download Files Request content</b><br/>";
echo "fileName: ".$downloadFiles->fileName."<br/>";

}catch (APIException $e) {
      echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
      echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
}

?>
