<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require './vendor/autoload.php';

use APIv3SandboxLib\Controllers\CdrsController;
use APIv3SandboxLib\Configuration;
use Unirest\Unirest;

/* CDRs Flow:

/* Operations used:
    Request file creation
    List files
    Download File
*/

Unirest::auth(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
$controller = new CdrsController();
try{
//Request File Creation
$fileCreation = $controller->createCdrsFileRequest('2015', '03');
echo "<br/><br/><br/>";
echo "<b>Request File Creation Request content</b><br/>";
echo "<br/>";
echo "status: ".$fileCreation->status."<br/>";
echo Configuration::$BasicAuthUserName;

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
echo "<br/><br/><br/>";
echo "<b>Download Files Request content</b><br/>";
echo "fileName: ".$downloadFiles->fileNames[0]."<br/>";

}catch (APIException $e) {
      echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
      echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
}

?>
