<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require './vendor/autoload.php';

use APIv3SandboxLib\Controllers\InventoryController;
use APIv3SandboxLib\Configuration;
use Unirest\Unirest;

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
Unirest::auth(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
$controller = new InventoryController();
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

$countryCodeA3 ='DNK';

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
$didGroups = $controller->getDidgroups("DNK",0,1,NULL,NULL,NULL,NULL,NULL,NULL);
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

//List Zone
$zone = $controller->getZones();
echo "<br/><br/><br/>";
echo "<b>List Zone content</b><br/>";
echo "Zone: ".$zone->zone[0]."<br/>";
echo "Zone: ".$zone->zone[1]."<br/>";
echo "Zone: ".$zone->zone[2]."<br/>";
echo "Zone: ".$zone->zone[3]."<br/>";

//List Trunk
$trunk = $controller->getTrunks();
echo "<br/><br/><br/>";
echo "<b>List Trunk content</b><br/>";
echo "trunk: ".$trunk->trunks[0]."<br/>";
echo "trunk: ".$trunk->trunks[1]."<br/>";
echo "trunk: ".$trunk->trunks[2]."<br/>";
echo "trunk: ".$trunk->trunks[3]."<br/>";

  }catch (APIException $e) {
      echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
      echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
  }

?>
