<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require './vendor/autoload.php';

use APIv3SandboxLib\Controllers\RegulationController;
use APIv3SandboxLib\Controllers\InventoryController;

use APIv3SandboxLib\Models\AddressModel;
use APIv3SandboxLib\Models\DidIdListModel;

use APIv3SandboxLib\Configuration;
use Unirest\Unirest;


/* Regulation Flow:
  listZipCodes -> createRegulationAddress -> uploadProofOfAddress -> Is Address Valid ->requestAddressVerification 
  -> linkAddress -> Unlink Address -> listRegulationAddress-> Delete Address 

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

Unirest::auth(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
$controller = new RegulationController();
$inventoryController = new InventoryController();

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
   echo "<br/><br/>";
   echo '<b>Create Regulation Address</b><br/>';
    $customerReference = 'address #123';
    $didType = 'GEOGRAPHIC';
    $extraFields = array( "Municipality Code"=>"1235", "Street Code"=>"1234");
    $countryCodeA3 = 'DNK';
    $streetName = 'Eglinton Ave';
    $destinationCountryCodeA3 = 'DNK';
    $firstName = 'FIRST';
    $lastName = 'LAST';
    $salutation = 'MR';
    $zipCode = '52062';
    $city = 'Copenhagen';
    $buildingNumber = '150';

   $body = new AddressModel($salutation, NULL, NULL, $firstName, $lastName, 
    $countryCodeA3, $city, $zipCode, $streetName, $buildingNumber, NULL, $customerReference, 
    $extraFields, $didType, $destinationCountryCodeA3);

   $newAddress = $controller->address($body);
   echo "addressId: ".$newAddress->addressId."<br/>";
   $newAddressId = $newAddress->addressId;

   echo "<br/><br/>";
   echo '<b>Upload Proof of Address</b><br/>';
   $uploadProofOfAddress = $controller->addressProof($newAddressId, "pof.jpg");
   echo 'Upload status: '.$uploadProofOfAddress->status."<br/>";

  //List Created Regulation Address
  $listAddress = $controller->getAddress($newAddressId);
  echo "<br/><br/>";
  echo "<b>List Created Regulation Address</b><br/>";
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

  //Is Address Valid
  $didType = 'GEOGRAPHIC';
  $destinationCountryCodeA3 = 'DNK';
  $addressValid = $controller->getAddressValidation($newAddressId, $didType, $destinationCountryCodeA3);
  echo "<br/><br/>";
  echo "<b>Is Address Valid</b><br/>";
  $isValid = $addressValid->isValid;
  echo "isValid: ".(int)$isValid."<br/>";
  echo "code: ".$addressValid->reasons[0]->code."<br/>";
  echo "message: ".$addressValid->reasons[0]->message."<br/>";

  //Request verification
  $verification = $controller->addressVerification($newAddressId);
  echo "<br/><br/>";
  echo "<b>Request verification</b><br/>";
  echo "status: ".$verification->status."<br/>";
  echo "<br/><br/>";

  //List Regulation Addresses Request
  $listAddresses = $controller->getAddresses(0, 10, NULL, NULL, NULL, 'DNK', NULL, NULL, NULL, NULL, 'VERIFIED', NULL, NULL);
  echo "<br/>";
  echo "<b>List Regulation Addresses</b><br/>";
  echo "addressId: ".$listAddresses->regulationAddresses[0]->addressId."<br/>";
  $verifiedAddress = $listAddresses->regulationAddresses[0]->addressId;
  $linked = $listAddresses->regulationAddresses[0]->linked;
  echo "linked: ".(int)$linked."<br/>";
  echo "status: ".$listAddresses->regulationAddresses[0]->status."<br/>";
  echo "companyName: ".$listAddresses->regulationAddresses[0]->companyName."<br/>";
  echo "companyDescription: ".$listAddresses->regulationAddresses[0]->companyDescription."<br/>";
  echo "firstName: ".$listAddresses->regulationAddresses[0]->firstName."<br/>";
  echo "lastName: ".$listAddresses->regulationAddresses[0]->lastName."<br/>";
  echo "countryCodeA3: ".$listAddresses->regulationAddresses[0]->countryCodeA3."<br/>";
  echo "city: ".$listAddresses->regulationAddresses[0]->city."<br/>";
  echo "zipCode: ".$listAddresses->regulationAddresses[0]->zipCode."<br/>";
  echo "streetName: ".$listAddresses->regulationAddresses[0]->streetName."<br/>";
  echo "buildingNumber: ".$listAddresses->regulationAddresses[0]->buildingNumber."<br/>";
  echo "buildingLetter: ".$listAddresses->regulationAddresses[0]->buildingLetter."<br/>";
  echo "customerReference: ".$listAddresses->regulationAddresses[0]->customerReference."<br/>";
  echo "extraFields: ".$listAddresses->regulationAddresses[0]->extraFields."<br/>";
  echo "rejectionReasons: ".$listAddresses->regulationAddresses[0]->rejectionReasons[0]."<br/>";
  echo "<br/><br/>";

  //Link Address
  echo "<b>Link Address</b><br/>";
  $getDidId = $inventoryController->getDids(1, 0, NULL, NULL, NULL, NULL, NULL, 'DNK');
  $didId = $getDidId->dids[0]->didId;
  $didIds = array($didId);
  $body = new DidIdListModel($didIds);
  $linkAddress = $controller->addressLink($verifiedAddress, $body);
  echo "didId: ".$didId."<br/>";
  echo "status: ".$verification->status."<br/>";
  echo "<br/><br/><br/>";

  //Unlink Address
  echo "<b>Unink Address</b><br/>";
  $getDidId = $inventoryController->getDids(1, 0, NULL, NULL, NULL, NULL, NULL, 'DNK');
  $didId = $getDidId->dids[0]->didId;
  $didIds = array($didId); 
  $body = array('didIds'=>$didIds);
  $unlinkAddress = $controller->addressUnlink($body);
  echo "didId: ".$didId."<br/>";
  echo "status: ".$unlinkAddress->status."<br/>";
  echo "<br/><br/><br/>";

  //Delete Address
  $listAddressesDelete = $controller->getAddresses(0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
  $deleteAddressId = $listAddressesDelete->regulationAddresses[0]->addressId;
  echo "<b>Delete Address</b><br/>";
  
  $deleteAddress = $controller->deleteAddress($deleteAddressId);
  echo "deleteAddressId: ".$deleteAddressId."<br/>";
  echo "status: ".$deleteAddress->status."<br/>";
  echo "<br/><br/><br/>";

  }catch (APIException $e) {
      echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
      echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
  }

?>
