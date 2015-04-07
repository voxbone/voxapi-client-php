<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require './vendor/autoload.php';

use APIv3SandboxLib\Controllers\ConfigurationController;
use APIv3SandboxLib\Controllers\InventoryController;

use APIv3SandboxLib\Models\DidConfigurationModel;
  use APIv3SandboxLib\Models\CallerIdModel;
  use APIv3SandboxLib\Models\PeerModel;

use APIv3SandboxLib\Models\ACapacityGroupSaveModel;
  use APIv3SandboxLib\Models\CapacityGroupSaveModel;

use APIv3SandboxLib\Models\FaxUriSaveModel;
  use APIv3SandboxLib\Models\FaxUriModel;

use APIv3SandboxLib\Models\AVoiceUriSaveModel;
  use APIv3SandboxLib\Models\VoiceUriSaveModel;

use APIv3SandboxLib\Models\SmsLinkGroupSaveModel;

use APIv3SandboxLib\Models\SmsLinkSaveModel;
  use APIv3SandboxLib\Models\SmsLinkModel;

use APIv3SandboxLib\Configuration;
use Unirest\Unirest;

/* Configuration Flow:
1. Create capacity group, List Capacity group, Delete capacity Group
2. Create fax URI, List fax URI, Delete fax URI
3. Create voice URI, List voice URI, Delete voice URI
4. Create smsLink Group, List smsLink Group, Delete smsLink Group
5. Create smsLink , List smsLink , Delete smsLink
6. List Voxbone POPs
7. List DIDs (get Did)
8. Apply Configurations
*/

Unirest::auth(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
$controller = new ConfigurationController();
try{
  
  /***** CHANGE THESE BEFORE EACH TEST! ****/
  
    //voice URI
    $voiceuri = 'example@voxbone.com';


    //sms link group name
    $smsLinkGroupName = 'example';

    //smsLink name
    $smsLinkName = "example";


  
  /****************************************/


  //Create Capacity Group
  $maximumCapacity = 10;
  $description = "Create CapacityGroup";
  $capacityGroupId = NULL;
  $capacityGroup = new CapacityGroupSaveModel($maximumCapacity, $description, $capacityGroupId);
  $body = new ACapacityGroupSaveModel($capacityGroup);
  $createCapacity = $controller->updateCapacityGroup($body);
  echo "<br/><br/><br/>";
  echo "<b>Create Capacity Group Response</b><br/>";
  echo "capacityGroupId: ".$createCapacity->capacityGroup->capacityGroupId."<br/>";
  echo "maximumCapacity: ".$createCapacity->capacityGroup->maximumCapacity."<br/>";
  echo "description: ".$createCapacity->capacityGroup->description."<br/>";
  $capacityGroupId = $createCapacity->capacityGroup->capacityGroupId;

  //List Capacity Group
  $listCapacity = $controller->getCapacityGroup($capacityGroupId);
  echo "<br/><br/><br/>";
  echo "<b>List Capacity Group Response</b><br/>";
  echo "capacityGroupId: ".$listCapacity->capacityGroups[0]->capacityGroupId."<br/>";
  echo "maximumCapacity: ".$listCapacity->capacityGroups[0]->maximumCapacity."<br/>";
  echo "amountOfDidsMapped: ".$listCapacity->capacityGroups[0]->amountOfDidsMapped."<br/>";
  echo "description: ".$listCapacity->capacityGroups[0]->description."<br/>";

  //Delete Capacity Group
  $listCapacities = $controller->getCapacityGroups(0,10, NULL, NULL);
  $capacityGroupIdDelete = $listCapacities->capacityGroups[0]->capacityGroupId;
  $deleteCapacity = $controller->deleteCapacityGroup($capacityGroupIdDelete);

  echo "<br/><br/><br/>";
  echo "<b>Delete Capacity Group Response</b><br/>";
  echo "CapacityGroup Deleted: ".$capacityGroupIdDelete."<br/>";
  echo "status: ".$deleteCapacity->status."<br/>";

  //List Capacity Groups  
  $listCapacities = $controller->getCapacityGroups(0,10, NULL, NULL);
  echo "<br/><br/><br/>";
  echo "<b>List Capacity Groups Response</b><br/>";
  echo "capacityGroupId: ".$listCapacities->capacityGroups[0]->capacityGroupId."<br/>";
  echo "maximumCapacity: ".$listCapacities->capacityGroups[0]->maximumCapacity."<br/>";
  echo "amountOfDidsMapped: ".$listCapacities->capacityGroups[0]->amountOfDidsMapped."<br/>";
  echo "description: ".$listCapacities->capacityGroups[0]->description."<br/>";
  $capacityGroupId = $listCapacities->capacityGroups[0]->capacityGroupId;

  //Create Fax URI
  $deliveryMethod = 'SMTP';
  $faxFileFormat = 'Pdf';
  $uri = 'snacar@voxbone.com';
  $faxUri = new FaxUriModel(NULL, $deliveryMethod, $faxFileFormat, $uri, NULL, NULL, NULL, NULL);
  $body = new FaxUriSaveModel($faxUri);
  $createFaxUri = $controller->updateFaxUri($body);
  echo "<br/><br/><br/>";
  echo "<b>Create Fax URI Response</b><br/>";
  echo "faxUriId: ".$createFaxUri->faxUri->faxUriId."<br/>";
  echo "deliveryMethod: ".$createFaxUri->faxUri->deliveryMethod."<br/>";
  echo "faxFileFormat: ".$createFaxUri->faxUri->faxFileFormat."<br/>";
  echo "uri: ".$createFaxUri->faxUri->uri."<br/>";
  echo "csid: ".$createFaxUri->faxUri->csid."<br/>";
  echo "subject: ".$createFaxUri->faxUri->subject."<br/>";
  echo "body: ".$createFaxUri->faxUri->body."<br/>";
  echo "useHtml: ".$createFaxUri->faxUri->useHtml."<br/>";
  $faxUriId = $createFaxUri->faxUri->faxUriId;

  //List Fax URI
  $listFaxUri = $controller->getFaxUri($faxUriId);
  echo "<br/><br/><br/>";
  echo "<b>List Fax URIs Response</b><br/>";
  echo "faxUriId: ".$listFaxUri->faxUris[0]->faxUriId."<br/>";
  echo "deliveryMethod: ".$listFaxUri->faxUris[0]->deliveryMethod."<br/>";
  echo "faxFileFormat: ".$listFaxUri->faxUris[0]->faxFileFormat."<br/>";
  echo "uri: ".$listFaxUri->faxUris[0]->uri."<br/>";
  echo "csid: ".$listFaxUri->faxUris[0]->csid."<br/>";
  echo "subject: ".$listFaxUri->faxUris[0]->subject."<br/>";
  echo "body: ".$listFaxUri->faxUris[0]->body."<br/>";
  echo "useHtml: ".$listFaxUri->faxUris[0]->useHtml."<br/>";

  //Delete fax
  $listFaxUri = $controller->getFaxUris(0,10, NULL, NULL, NULL, NULL);
  $faxUriId = $listFaxUri->faxUris[0]->faxUriId;

  $deleteFaxUri = $controller->deleteFaxUri($faxUriId);
  echo "<br/><br/><br/>";
  echo "<b>Delete Fax URI Response</b><br/>";
  echo "FaxUri Deleted: ".$faxUriId."<br/>";
  echo "status: ".$deleteFaxUri->status."<br/>";

  //List Fax URIs
  $listFaxUri = $controller->getFaxUris(0,10, NULL, NULL, NULL, NULL);
  echo "<br/><br/><br/>";
  echo "<b>List Fax URIs Response</b><br/>";
  echo "faxUriId: ".$listFaxUri->faxUris[0]->faxUriId."<br/>";
  echo "deliveryMethod: ".$listFaxUri->faxUris[0]->deliveryMethod."<br/>";
  echo "faxFileFormat: ".$listFaxUri->faxUris[0]->faxFileFormat."<br/>";
  echo "uri: ".$listFaxUri->faxUris[0]->uri."<br/>";
  echo "csid: ".$listFaxUri->faxUris[0]->csid."<br/>";
  echo "subject: ".$listFaxUri->faxUris[0]->subject."<br/>";
  echo "body: ".$listFaxUri->faxUris[0]->body."<br/>";
  echo "useHtml: ".$listFaxUri->faxUris[0]->useHtml."<br/>";
  $faxUriId = $listFaxUri->faxUris[0]->faxUriId;

  //Create Voice URI
  $voiceUriProtocol = "SIP";
  $description = 'Voice URI Created';
  $voiceUri = new VoiceUriSaveModel(NULL, NULL, $voiceUriProtocol, $voiceuri, $description);
  $body = new AVoiceUriSaveModel($voiceUri);
  $createVoiceUri = $controller->updateVoiceUri($body);
  echo "<br/><br/><br/>";
  echo "<b>Create Voice URI Response</b><br/>";
  echo "voiceUriId: ".$createVoiceUri->voiceUri->voiceUriId."<br/>";
  echo "deliveryMethod: ".$createVoiceUri->voiceUri->backupUriId."<br/>";
  echo "faxFileFormat: ".$createVoiceUri->voiceUri->voiceUriProtocol."<br/>";
  echo "uri: ".$createVoiceUri->voiceUri->uri."<br/>";
  echo "csid: ".$createVoiceUri->voiceUri->description."<br/>";
  $voiceUriId = $createVoiceUri->voiceUri->voiceUriId;

  //List Voice URI
  $listVoiceUri = $controller->getVoiceUri($voiceUriId);
  echo "<br/><br/><br/>";
  echo "<b>List Voice URI Response</b><br/>";
  echo "voiceUriId: ".$listVoiceUri->voiceUris[0]->voiceUriId."<br/>";
  echo "backupUriId: ".$listVoiceUri->voiceUris[0]->backupUriId."<br/>";
  echo "voiceUriProtocol: ".$listVoiceUri->voiceUris[0]->voiceUriProtocol."<br/>";
  echo "uri: ".$listVoiceUri->voiceUris[0]->uri."<br/>";
  echo "description: ".$listVoiceUri->voiceUris[0]->description."<br/>";
  
  //Delete voice URI
  $deleteVoiceUri = $controller->deleteVoiceUri($voiceUriId);
  echo "<br/><br/><br/>";
  echo "<b>Delete Voice URI Response</b><br/>";
  echo "voiceUri deleted: ".$voiceUriId."<br/>";
  echo "status: ".$deleteVoiceUri->status."<br/>";
  

  //List Voice URIs
  $listVoiceUris = $controller->getVoiceUris(0,10, NULL, NULL, NULL, NULL);
  echo "<br/><br/><br/>";
  echo "<b>List Voice URIs Response</b><br/>";
  echo "voiceUriId: ".$listVoiceUris->voiceUris[0]->voiceUriId."<br/>";
  echo "backupUriId: ".$listVoiceUris->voiceUris[0]->backupUriId."<br/>";
  echo "voiceUriProtocol: ".$listVoiceUris->voiceUris[0]->voiceUriProtocol."<br/>";
  echo "uri: ".$listVoiceUris->voiceUris[0]->uri."<br/>";
  echo "description: ".$listVoiceUris->voiceUris[0]->description."<br/>";
  $voiceUriId = $listVoiceUris->voiceUris[0]->voiceUriId;

  //Create SMS Link Groups 
  $body = new SmsLinkGroupSaveModel($smsLinkGroupName);
  $smsLinkGroup = $controller->updateSmsLinkGroup($body);
  echo "<br/><br/><br/>";
  echo "<b>Create SMS Link Group Response</b><br/>";
  echo "id: ".$smsLinkGroup->id."<br/>";
  $smsLinkGroupId = $smsLinkGroup->id;

  //Delete SMS Link Group
  // $smsLinkGroups = $controller->getSmsLinkGroups();
  // $smsLinkGroupDelete = $smsLinkGroups->smsLinkGroups[0]->id;
  // $deleteSmsLinkGroup = $controller->deleteSmsLinkGroup($smsLinkGroupDelete);
  // echo "<br/><br/><br/>";
  // echo "SmsLinkGroup Deleted: ".$smsLinkGroupDelete."<br/>";
  // echo "<b>Delete SMS Link Response</b><br/>";
  // echo "status: ".$deleteSmsLinkGroup->status."<br/>";

  //List smsLinkGroups
  $smsLinkGroups = $controller->getSmsLinkGroups();
  echo "<br/><br/><br/>";
  echo "<b>List SMS Link Groups Response</b><br/>";
  echo "id: ".$smsLinkGroups->smsLinkGroups[0]->id."<br/>";
  echo "name: ".$smsLinkGroups->smsLinkGroups[0]->name."<br/>";
  $groupId = $smsLinkGroups->smsLinkGroups[0]->id;

  //Create SMS Link 
  $type = 'SIP';
  $url = 'sip:foo@bar.com';
  $weight = '10';
  $direction = 'FROM_VOXBONE';
  $smsLink = new SmsLinkModel(NULL, $smsLinkGroupId, $smsLinkName, $type, NULL, NULL, $url, $weight, $direction, NULL, NULL, NULL, NULL);
  $body = new SmsLinkSaveModel($smsLink);
  $newSmsLink = $controller->updateSmsLink($body);
  echo "<br/><br/><br/>";
  echo "<b>Create SMS Link Response</b><br/>";
  echo "smsLinkId: ".$newSmsLink->smsLink."<br/>";
  $smsLinkId = $newSmsLink->smsLink;

  // List smsLink
  $smsLink = $controller->getSmsLink($smsLinkId);
  echo "<br/><br/><br/>";
  echo "<b>List SMS Links Response</b><br/>";
  echo "smsLinkId: ".$smsLink->smsLinks[0]->smsLinkId."<br/>";
  echo "groupId: ".$smsLink->smsLinks[0]->groupId."<br/>";
  echo "type: ".$smsLink->smsLinks[0]->type."<br/>";
  echo "direction: ".$smsLink->smsLinks[0]->direction."<br/>";
  $smsLinkId = $smsLink->smsLinks[0]->smsLinkId;

  //Delete SMS Link
  // $smsLinks = $controller->getSmsLinks(NULL, NULL, NULL, NULL);
  // $smsLinkIdDelete = $smsLinks->smsLinks[0]->smsLinkId;
  // $deleteSmsLink = $controller->deleteSmsLink($smsLinkIdDelete);
  // echo "<br/><br/><br/>";
  // echo "<b>Delete SMS Link Response</b><br/>";
  // echo "smsLink Deleted: ".$smsLinkId."<br/>";
  // echo "status: ".$deleteSmsLink->status."<br/>";


  // List smsLinks
  $smsLinks = $controller->getSmsLinks(NULL, NULL, NULL, NULL);
  echo "<br/><br/><br/>";
  echo "<b>List SMS Links Response</b><br/>";
  echo "smsLinkId: ".$smsLinks->smsLinks[0]->smsLinkId."<br/>";
  echo "groupId: ".$smsLinks->smsLinks[0]->groupId."<br/>";
  echo "type: ".$smsLinks->smsLinks[0]->type."<br/>";
  echo "direction: ".$smsLinks->smsLinks[0]->direction."<br/>";
  $smsLinkId = $smsLinks->smsLinks[0]->smsLinkId;


  // List Voxbone POPs
  $pops = $controller->getPop();
  echo "<br/><br/><br/>";
  echo "<b>List Voxbone POPs Response</b><br/>";
  echo "deliveryId: ".$pops->pops[0]->deliveryId."<br/>";
  echo "name: ".$pops->pops[0]->name."<br/>";
  echo "ips: ".$pops->pops[0]->ips[0]."<br/>";

  //List DIDs
  $inventoryController = new inventoryController();
  $getDidIds = $inventoryController->getDids(1, 0, NULL, NULL, NULL, NULL, NULL);
  echo "<br><br><b>Get DID Response</b><br/>";
  echo "didid: ".$getDidIds->dids[0]->didId."<br/>";
  $didId = $getDidIds->dids[0]->didId;
  echo "<br/><br/>";

  //Apply Configuration
  $didIds = array($didId);
  $body = new DidConfigurationModel($didIds, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
    NULL, NULL, NULL, NULL, NULL, 'true', NULL );
  $applyConfig = $controller->createConfiguration($body);
  echo "<b>Apply Configuration Response</b><br/>";
  $configOption = $applyConfig->messages[0]->configOption;
  echo "configOption: ".(int)$configOption."<br/>";
  echo "numberUpdated: ".$applyConfig->messages[0]->numberUpdated."<br/>";
  
  }catch (APIException $e) {
      echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
      echo 'error code is: ', $e->getResponseCode()," ", $e->getReason(), "<br/><br />\n";
  }

?>