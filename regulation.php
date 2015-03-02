<?php

// ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('./APIv3SandboxLib.php');


/* Regulation Flow:
  listZipCodes -> createRegulationAddress -> uploadProofOfAddress -> requestAddressVerification 
  -> linkAddress -> Is Address Valid -> Unlink Address -> listRegulationAddress-> Delete Address 
  -> listAddresses

/* Operations used:
    listZipCodes
    createRegulationAddress
    uploadProofOfAddress
    requestAddressVerification
    linkAddress
    Is Address Valid
    Unlink Address 
    listRegulationAddress x2
    Delete Address
*/

$controller = new RegulationController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
try{
  //Get Zip Code DEU
  $zipCodes = $controller->getZipcode('DEU', 0,1, NULL);
  echo "<br/><br/><br/>";
  echo "<b>ZipCodes Response</b><br/>";
  echo "cityZipCodes: ".$zipCodes->cityZipCodes[0]->cityName."<br/>";
  echo "zipCode: ".$zipCodes->cityZipCodes[0]->zipCode."<br/>";
  $zipCode = $zipCodes->cityZipCodes[0]->zipCode;
  $zipCode = NULL;

 //Create Regulation Address
 $salutation = 'MR';
 $companyName = null;
 $companyDescription = null;
 $firstName = 'FIRST';
 $lastName = 'FIRST';
 $countryCodeA3 = 'FRA';
 $city = 'Paris';
 $zipCode = "70018";
 $streetName = 'Regulation Street';
 $buildingNumber = '3';
 $buildingLetter = 'F';
 $customerReference = "regulation address";
 $extraFields = null ;
 $didType = "GEOGRAPHIC";
 $destinationCountryCodeA3 = "FRA";

 $address = new AddressModel($salutation, $companyName, $companyDescription, $firstName, $lastName, $countryCodeA3, $city,
  $zipCode, $streetName, $buildingNumber, $buildingLetter, $customerReference, $extraFields, $didType, $destinationCountryCodeA3);

$address = $address->to_json();  
$regulationAddress = $controller->address($address, NULL);
echo "<b>Response var dump</b><br/><br />\n", var_dump($regulationAddress);


  //List Regulation Addresses Request
  $listAddress = $controller->getAddresses(0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
  echo "<br/><br/>";
  echo "<b>List Regulation Addresses</b><br/>";
  echo "addressId: ".$listAddress->regulationAddresses[0]->addressId."<br/>";
  $linked = $listAddress->regulationAddresses[0]->linked;
  echo "linked: ".(int)$linked."<br/>";
  echo "status: ".$listAddress->regulationAddresses[0]->status."<br/>";
  echo "companyName: ".$listAddress->regulationAddresses[0]->companyName."<br/>";
  echo "companyDescription: ".$listAddress->regulationAddresses[0]->companyDescription."<br/>";
  echo "firstName: ".$listAddress->regulationAddresses[0]->firstName."<br/>";
  echo "lastName: ".$listAddress->regulationAddresses[0]->lastName."<br/>";
  echo "countryCodeA3: ".$listAddress->regulationAddresses[0]->countryCodeA3."<br/>";
  echo "city: ".$listAddress->regulationAddresses[0]->city."<br/>";
  echo "zipCode: ".$listAddress->regulationAddresses[0]->zipCode."<br/>";
  echo "streetName: ".$listAddress->regulationAddresses[0]->streetName."<br/>";
  echo "buildingNumber: ".$listAddress->regulationAddresses[0]->buildingNumber."<br/>";
  echo "buildingLetter: ".$listAddress->regulationAddresses[0]->buildingLetter."<br/>";
  echo "customerReference: ".$listAddress->regulationAddresses[0]->customerReference."<br/>";
  echo "extraFields: ".$listAddress->regulationAddresses[0]->extraFields."<br/>";
  echo "rejectionReasons: ".$listAddress->regulationAddresses[0]->rejectionReasons[0]."<br/>";
  echo "<br/><br/>";
  $addressId = $listAddress->regulationAddresses[1]->addressId;

  //Is Address Valid
  $didType = 'GEOGRAPHIC';
  $destinationCountryCodeA3 = 'FRA';
  $addressValid = $controller->getAddressValidation($addressId, $didType, $destinationCountryCodeA3);
  echo "<b>Is Address Valid</b><br/>";
  $isValid = $addressValid->isValid;
  echo "isValid: ".(int)$isValid."<br/>";
  echo "code: ".$addressValid->reasons[0]->code."<br/>";
  echo "message: ".$addressValid->reasons[0]->message."<br/>";

  //Request verification

  $verification = $controller->addressVerification($addressId);
  echo "<b>controller regulationAddresses var dump</b><br/>", var_dump($verification);
  echo "<br/><br/><br/>";
  echo "<b>List Regulation Addresses</b><br/>";
  echo "addressId: ".$listAddress->regulationAddresses[0]->addressId."<br/>";
  echo "linked: ".$listAddress->regulationAddresses[0]->linked."<br/>";
  echo "status: ".$listAddress->regulationAddresses[0]->status."<br/>";
  echo "companyName: ".$listAddress->regulationAddresses[0]->companyName."<br/>";
  echo "companyDescription: ".$listAddress->regulationAddresses[0]->companyDescription."<br/>";
  echo "firstName: ".$listAddress->regulationAddresses[0]->firstName."<br/>";
  echo "lastName: ".$listAddress->regulationAddresses[0]->lastName."<br/>";
  echo "countryCodeA3: ".$listAddress->regulationAddresses[0]->countryCodeA3."<br/>";
  echo "city: ".$listAddress->regulationAddresses[0]->city."<br/>";
  echo "zipCode: ".$listAddress->regulationAddresses[0]->zipCode."<br/>";
  echo "streetName: ".$listAddress->regulationAddresses[0]->streetName."<br/>";
  echo "buildingNumber: ".$listAddress->regulationAddresses[0]->buildingNumber."<br/>";
  echo "buildingLetter: ".$listAddress->regulationAddresses[0]->buildingLetter."<br/>";
  echo "customerReference: ".$listAddress->regulationAddresses[0]->customerReference."<br/>";
  echo "extraFields: ".$listAddress->regulationAddresses[0]->extraFields."<br/>";
  echo "rejectionReasons: ".$listAddress->regulationAddresses[0]->rejectionReasons[0]."<br/>";
  echo "<br/><br/><br/>";

  //Link Address
    // $didId = "6888806";
    // $didIds = array($didId);
    // $body = new DidIdListModel($didIds);
    // $body = $body->to_json();  
    // $linkAddress = $controller->addressLink($addressId, $body);


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
