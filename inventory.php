<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('./APIv3SandboxLib.php');


/* Inventory Flow:

/* Operations used:
    List Countries
    List Country
    List Restrictions
    List State
    List Credit Package
    List DID
    List DID Group
    List Feature    
    List Trunk
    List Zone
*/

$controller = new InventoryController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
try{

//List Countries
$listCountries = $controller->getCountries(0,1);

echo "<br/><br/><br/>";
echo "<b>List Countries Request content</b><br/>";
echo "<br/>";
echo "countryCodeA3: ".$listCountries->countries[0]->countryCodeA3."<br/>";
echo "countryName: ".$listCountries->countries[0]->countryName."<br/>";
echo "phoneCode: ".$listCountries->countries[0]->phoneCode."<br/>";
echo "hasStates: ".$listCountries->countries[0]->hasStates."<br/>";
echo "hasRegulationRequirement: ".$listCountries->countries[0]->hasRegulationRequirement."<br/>";

$countryCodeA3 ='BEL';

//List Country
$listCountry = $controller->getCountry($countryCodeA3);
echo "<br/><br/><br/>";
echo "<b>List Country Request content</b><br/>";
echo "<br/>";
echo "countryCodeA3: ".$listCountry->countries[0]->countryCodeA3."<br/>";
echo "countryName: ".$listCountry->countries[0]->countryName."<br/>";
echo "phoneCode: ".$listCountry->countries[0]->phoneCode."<br/>";
echo "hasStates: ".$listCountry->countries[0]->hasStates."<br/>";
echo "hasRegulationRequirement: ".$listCountry->countries[0]->hasRegulationRequirement."<br/>";

//List Restrictions
$listRestrictions = $controller->getRestrictions($countryCodeA3);
echo "<br/><br/><br/>";
echo "<b>List Restrictions Request content</b><br/>";
echo "<br/>";
echo "countryCodeA3: ".$listRestrictions->restrictions[0]->countryCodeA3."<br/>";
echo "restrictionType: ".$listRestrictions->restrictions[0]->restrictionType."<br/>";
echo "restrictionMessage: ".$listRestrictions->restrictions[0]->restrictionMessage."<br/>";


//List DID
$listDid = $controller->getDids(1,0);
echo "<br/><br/><br/>";
echo "<b>List DIDs Request content</b><br/>";
echo "<br/>";
echo "didId: ".$listDid->dids[0]->didId."<br/>";
echo "e164: ".$listDid->dids[0]->e164."<br/>";
echo "type: ".$listDid->dids[0]->type."<br/>";
echo "countryCodeA3: ".$listDid->dids[0]->countryCodeA3."<br/>";
echo "cityName: ".$listDid->dids[0]->cityName."<br/>";
echo "areaCode: ".$listDid->dids[0]->areaCode."<br/>";
echo "voiceUriId: ".$listDid->dids[0]->voiceUriId."<br/>";
echo "faxUriId: ".$listDid->dids[0]->faxUriId."<br/>";
echo "smsLinkGroupId: ".$listDid->dids[0]->smsLinkGroupId."<br/>";
echo "orderReference: ".$listDid->dids[0]->orderReference."<br/>";
echo "channels: ".$listDid->dids[0]->channels."<br/>";
echo "delivery: ".$listDid->dids[0]->delivery."<br/>";
echo "trunkId: ".$listDid->dids[0]->trunkId."<br/>";
echo "capacityGroupId: ".$listDid->dids[0]->capacityGroupId."<br/>";
echo "didGroupId: ".$listDid->dids[0]->didGroupId."<br/>";
echo "regulationAddressId: ".$listDid->dids[0]->regulationAddressId."<br/>";
echo "srvLookup: ".$listDid->dids[0]->srvLookup."<br/>";
echo "cliFormat: ".$listDid->dids[0]->callerId->cliFormat."<br/>";
echo "cliValue: ".$listDid->dids[0]->callerId->cliValue."<br/>";
echo "cliPrivacy: ".$listDid->dids[0]->cliPrivacy."<br/>";
echo "t38Enabled: ".$listDid->dids[0]->otherOptions->t38Enabled."<br/>";
echo "dtmf: ".$listDid->dids[0]->otherOptions->dtmf."<br/>";
echo "dtmfInbandMute: ".$listDid->dids[0]->otherOptions->dtmfInbandMute."<br/>";
echo "codecs: ".$listDid->dids[0]->otherOptions->codecs[0]."<br/>";
echo "ringback: ".$listDid->dids[0]->ringback."<br/>";
echo "dnisEnabled: ".$listDid->dids[0]->dnisEnabled."<br/>";
echo "blockOrdinary: ".$listDid->dids[0]->blockOrdinary."<br/>";
echo "blockCellular: ".$listDid->dids[0]->blockCellular."<br/>";
echo "blockPayphone: ".$listDid->dids[0]->blockPayphone."<br/>";
echo "smsOutbound: ".$listDid->dids[0]->smsOutbound."<br/>";
echo "webRtc: ".$listDid->dids[0]->webRtc."<br/>";

//Get DIDGroup
$didGroups = $controller->getDidgroups("USA",0,1,NULL,NULL,NULL,NULL,NULL,NULL);
echo "<br/><br/><br/>";
echo "<b>List DID Group content</b><br/>";
echo "didGroupId: ".$didGroups->didGroups[0]->didGroupId."<br/>";
echo "countryCodeA3: ".$didGroups->didGroups[0]->countryCodeA3."<br/>";
echo "stateId: ".$didGroups->didGroups[0]->stateId."<br/>";
echo "didType: ".$didGroups->didGroups[0]->didType."<br/>";
echo "cityName: ".$didGroups->didGroups[0]->cityName."<br/>";
echo "areaCode: ".$didGroups->didGroups[0]->areaCode."<br/>";
echo "rateCenter: ".$didGroups->didGroups[0]->rateCenter."<br/>";
echo "stock: ".$didGroups->didGroups[0]->stock."<br/>";
echo "setup100: ".$didGroups->didGroups[0]->setup100."<br/>";
echo "monthly100: ".$didGroups->didGroups[0]->monthly100."<br/>";
echo "available: ".$didGroups->didGroups[0]->available."<br/>";
echo "regulationRequirement: ".$didGroups->didGroups[0]->regulationRequirement."<br/>";
echo "featureId: ".$didGroups->didGroups[0]->features[0]->featureId."<br/>";
echo "name: ".$didGroups->didGroups[0]->features[0]->name."<br/>";
echo "description: ".$didGroups->didGroups[0]->features[0]->description."<br/>";

//List State
$listState = $controller->getStates("USA");
echo "<br/><br/><br/>";
echo "<b>List State Request content</b><br/>";
echo "stateId: ".$listState->states[0]->stateId."<br/>";
echo "stateName: ".$listState->states[0]->stateName."<br/>";
echo "stateCode: ".$listState->states[0]->stateCode."<br/>";
echo "countryCodeA3: ".$listState->states[0]->countryCodeA3."<br/>";

//List Credit Package
$creditPackage = $controller->getCreditPackages();
echo "<br/><br/><br/>";
echo "<b>List Credit Package content</b><br/>";
echo "creditPackageId: ".$creditPackage->creditPackages[0]->creditPackageId."<br/>";
echo "name: ".$creditPackage->creditPackages[0]->name."<br/>";
echo "price100: ".$creditPackage->creditPackages[0]->price100."<br/>";

//List Feature    
$feature = $controller->getFeatures();
echo "<br/><br/><br/>";
echo "<b>List Feature content</b><br/>";
echo "featureId: ".$feature->features[0]->featureId."<br/>";
echo "name: ".$feature->features[0]->name."<br/>";
echo "description: ".$feature->features[0]->description."<br/>";

//List Trunk
$trunk = $controller->getTrunks();
echo "<br/><br/><br/>";
echo "<b>List Trunk content</b><br/>";
echo "trunk: ".$trunk->trunks[0]."<br/>";
echo "trunk: ".$trunk->trunks[1]."<br/>";
echo "trunk: ".$trunk->trunks[2]."<br/>";
echo "trunk: ".$trunk->trunks[3]."<br/>";

//List Zone
$zone = $controller->getZones();
echo "<br/><br/><br/>";
echo "<b>List Zone content</b><br/>";
echo "Zone: ".$zone->zone[0]."<br/>";
echo "Zone: ".$zone->zone[1]."<br/>";
echo "Zone: ".$zone->zone[2]."<br/>";
echo "Zone: ".$zone->zone[3]."<br/>";

  }catch (APIException $e) {
      echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
      echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
  }
//Structure of the addToCart Request
// $controller = new OrderingController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);

// try{
  // $didGroupId = 8826;
  // $quantity = 10;
  // $didCartItem = new DidCartItemModel($didGroupId, $quantity);
  // $body = new CartItemModel($didCartItem, NULL, NULL);
  // $addtoCart = $controller->createCartProduct($cartIdentifier, $body);
  // echo "<b>updateCart Request var dump</b><br/><br />\n", var_dump($response);
  // echo "<br/><br/><br/>";
  // echo "<b>addtoCart Response</b><br/>";
  // echo "cartIdentifier: ".$addtoCart->cart->cartIdentifier."<br/>";
  // echo "customerReference: ".$addtoCart->cart->customerReference."<br/>";
  // echo "description: ".$addtoCart->cart->description."<br/>";
  // echo "dateAdded: ".$addtoCart->cart->dateAdded."<br/>";
  // echo "orderProducts: ".$addtoCart->cart->orderProducts[0]."<br/>";
  // echo "<br/><br/><br/>";

// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of AddToCart Request
// $controller = new OrderingController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $response = $controller->addToCart("11206", "8826", NULL, NULL, 1);
//   echo "<b>Response var dump</b><br/><br />\n", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "status: ".$response->status."<br/>";
// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of Remove From Cart Request
// $controller = new OrderingController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $response = $controller->removeFromCart("12345", "54321", 1);
//   echo "<b>removeFromCart Response var dump</b><br/><br />\n", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "status: ".$response->messages->status."<br/>";
// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }


// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/>";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of applyConfiguration Request
// $controller = new ConfigurationController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $didIds = array("12345", "54321", "22222", "1111");

//   $response = $controller->applyConfiguration($didIds, NULL, NULL, NULL, NULL, 
//         NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,
//         NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 
//         NULL,NULL, NULL, NULL);

//   echo "<b>applyConfiguration Response var dump</b><br/><br />\n", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "configOption: ".$response->messages->configOption."<br/>";
//   echo "numberUpdated: ".$response->messages->numberUpdated."<br/>";
//   echo "<br/><br/><br/>";

// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

//Structure of updateCapacityGroup Request
// $controller = new ConfigurationController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// $body = new CapacityGroupSave(10, 'this is a sample description', NULL);
// try{
//   $response = $controller->updateCapacityGroup($body);
//   echo "<b>saveCapacityGroup Response var dump</b><br/><br />\n", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "capacityGroupId: ".$response->capacityGroup->capacityGroupId."<br/>";
//   echo "maximumCapacity: ".$response->capacityGroup->maximumCapacity."<br/>";
//   echo "description: ".$response->capacityGroup->description."<br/>";
//   echo "amountOfDidsMapped: ".$response->capacityGroup->amountOfDidsMapped."<br/>";
//   echo "<br/><br/><br/>";

// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of saveFaxUri Request
// $controller = new ConfigurationController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $response = $controller->saveFaxUri(NULL, 'SMTP', 'Pdf', 'example@voxbone.com', NULL, 'Sample subject line', 'Sample body', NULL);
//   echo "<b>saveFaxUri Response var dump</b><br/><br />\n", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "faxUriId: ".$response->faxUri->faxUriId."<br/>";
//   echo "deliveryMethod: ".$response->faxUri->deliveryMethod."<br/>";
//   echo "faxFileFormat: ".$response->faxUri->faxFileFormat."<br/>";
//   echo "uri: ".$response->faxUri->uri."<br/>";
//   echo "csid: ".$response->faxUri->csid."<br/>";
//   echo "subject: ".$response->faxUri->subject."<br/>";
//   echo "body: ".$response->faxUri->body."<br/>";
//   echo "useHtml: ".$response->faxUri->useHtml."<br/>";
//   echo "<br/><br/><br/>";

// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of saveVoiceUri Request
// $controller = new ConfigurationController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $response = $controller->saveVoiceUri(NULL, NULL, 'SIP', 'example@voxbone.com', NULL);
//   echo "<b>saveFaxUri Response var dump</b><br/><br />\n", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "voiceUriId: ".$response->voiceUri->voiceUriId."<br/>";
//   echo "backupUriId: ".$response->voiceUri->backupUriId."<br/>";
//   echo "voiceUriProtocol: ".$response->voiceUri->voiceUriProtocol."<br/>";
//   echo "uri: ".$response->voiceUri->uri."<br/>";
//   echo "description: ".$response->voiceUri->description."<br/>";
//   echo "<br/><br/><br/>";

// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of saveSmsLink Request
// $controller = new ConfigurationController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $response = $controller->saveSmsLink(NULL, "1234", "Example", "SMTP", NULL, NULL, "foo@bar.com", 1, "FROM_VOXBONE", NULL, NULL, NULL, NULL);
//   echo "<b>saveSmsLink Response var dump</b><br/><br />\n", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "smsLinkId: ".$response->smsLink->smsLinkId."<br/>";
//   echo "<br/><br/><br/>";

// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of saveSmsLinkGroup Request
// $controller = new ConfigurationController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $response = $controller->saveSmsLinkGroup("name");
//   echo "<b>removeFromCart Response var dump</b><br/><br />\n", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "id: ".$response->id."<br/>";
// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of the List Regulation Addresses Request
// $controller = new RegulationController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $response = $controller->listRegulationAddress(0, 10);
//   echo "<b>controller regulationAddresses var dump</b><br/>", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "addressId: ".$response->regulationAddresses[0]->addressId."<br/>";
//   echo "linked: ".$response->regulationAddresses[0]->linked."<br/>";
//   echo "status: ".$response->regulationAddresses[0]->status."<br/>";
//   echo "companyName: ".$response->regulationAddresses[0]->companyName."<br/>";
//   echo "companyDescription: ".$response->regulationAddresses[0]->companyDescription."<br/>";
//   echo "firstName: ".$response->regulationAddresses[0]->firstName."<br/>";
//   echo "lastName: ".$response->regulationAddresses[0]->lastName."<br/>";
//   echo "countryCodeA3: ".$response->regulationAddresses[0]->countryCodeA3."<br/>";
//   echo "city: ".$response->regulationAddresses[0]->city."<br/>";
//   echo "zipCode: ".$response->regulationAddresses[0]->zipCode."<br/>";
//   echo "streetName: ".$response->regulationAddresses[0]->streetName."<br/>";
//   echo "buildingNumber: ".$response->regulationAddresses[0]->buildingNumber."<br/>";
//   echo "buildingLetter: ".$response->regulationAddresses[0]->buildingLetter."<br/>";
//   echo "customerReference: ".$response->regulationAddresses[0]->customerReference."<br/>";
//   echo "extraFields: ".$response->regulationAddresses[0]->extraFields."<br/>";
//   echo "<br/><br/><br/>";

// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/>";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of the Link Regulation Addresses Request
// $controller = new RegulationController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $didIds = (array('3495978', '6829888', '6829889'));
//   $response = $controller->linkRegulationAddress('116763', $didIds);
//   echo "<b>controller linkRegulationAddresses var dump</b><br/>", var_dump($response);
//   echo "<br/><br/><br/>";
//   echo "<b>content</b><br/>";
//   echo "status: ".$response->status."<br/>";
//   echo "<br/><br/><br/>";

// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/>";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }

// //Structure of the List CDR Files Request
// $controller = new CDRsController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
// try{
//   $response = $controller->listExistingFiles();
//   echo "<b>controller fileNames var dump</b><br/>", var_dump($response);

//   echo "<br/><br/><br/>";

// }catch (APIException $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "<br/>";
//     echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
// }
?>
