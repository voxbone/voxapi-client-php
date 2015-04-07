<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require './vendor/autoload.php';

use APIv3SandboxLib\Controllers\InventoryController;
use APIv3SandboxLib\Controllers\OrderingController;

use APIv3SandboxLib\Models\CartCreateModel;
use APIv3SandboxLib\Models\CartItemModel;
  use APIv3SandboxLib\Models\DidCartItemModel;
  use APIv3SandboxLib\Models\CapacityCartItemModel;
  use APIv3SandboxLib\Models\CreditPackageCartItemModel;

use APIv3SandboxLib\Models\QuantityModel;
use APIv3SandboxLib\Models\DidIdListModel;

use APIv3SandboxLib\Configuration;
use Unirest\Unirest;

// Ordering Flow 1: Account Balance -> createCart -> AddToCart -> get Order product ID -> RemoveFromCart -> listCart -> CheckoutCart -> cancelDids -> listOrder 
// Ordering Flow 2: createCart -> deleteCart
/* Operations used:
    Account balance
    Create cart x2
    Delete Cart
    Add to cart
    Get cart
    Remove from cart
    Checkout cart
    ListDids (inventory)
    Cancel dids
    List orders
    List Carts
*/
Unirest::auth(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);
$controller = new OrderingController();
$inventoryController = new InventoryController();

try{
  $accountBal = $controller->getAccountBalance();
  echo "<br/><br/><br/>";
  echo "<b>accountBal Response</b><br/>";
  $balance = $accountBal->accountBalance->balance;
  echo "balance: ".$accountBal->accountBalance->balance."<br/>";
  echo "threshold: ".$accountBal->accountBalance->threshold."<br/>";
  echo "currency: ".$accountBal->accountBalance->currency."<br/>";
  echo "active: ".$accountBal->accountBalance->active."<br/>";

  //If account balance high enough -> create cart
  if ($balance > 100) 
  {
    //Create Cart
    $customerReference = "Cart #1";
    $description = "Full Cart Checkout";
    $body = new CartCreateModel($customerReference, $description);
    $createCart = $controller->updateCart($body);
    echo "<br/><br/>";
    echo "<b>createCart Response</b><br/>";
    echo "cartIdentifier: ".$createCart->cart->cartIdentifier."<br/>";
    echo "customerReference: ".$createCart->cart->customerReference."<br/>";
    echo "description: ".$createCart->cart->description."<br/>";
    echo "dateAdded: ".$createCart->cart->dateAdded."<br/>";
    echo "orderProducts: ".$createCart->cart->orderProducts[0]."<br/>";
    $cartIdentifier = $createCart->cart->cartIdentifier;

    //Create Cart to be deleted
    $customerReference2 = "Cart #2";
    $description2 = "Will be Deleted";
    $body = new CartCreateModel($customerReference2, $description2);
    $createCart2 = $controller->updateCart($body);
    echo "<br/><br/>";
    echo "<b>createCart (to be deleted) Response</b><br/>";
    echo "cartIdentifier: ".$createCart2->cart->cartIdentifier."<br/>";
    echo "customerReference: ".$createCart2->cart->customerReference."<br/>";
    echo "description: ".$createCart2->cart->description."<br/>";
    echo "dateAdded: ".$createCart2->cart->dateAdded."<br/>";
    echo "orderProducts: ".$createCart2->cart->orderProducts[0]."<br/>";
    $cartIdentifier2 = $createCart2->cart->cartIdentifier;

    //Delete Cart #2
    $deleteCart = $controller->deleteCart($cartIdentifier2);
    echo "<br/><br/>";
    echo "<b>Delete Cart #2 Response</b><br/>";
    echo "status: ".$deleteCart->status."<br/>";
    echo $cartIdentifier2." has been deleted.";
  
    //Use cartIdentifier to add to cart
    $didGroups = $inventoryController->getDidgroups("DNK",0,1,NULL,NULL,NULL,NULL,NULL,NULL);
    $didGroupId = $didGroups->didGroups[0]->didGroupId;
    echo $didGroupId;
    $quantity = 5;
    $didCartItem = new DidCartItemModel($didGroupId, $quantity);
    $body = new CartItemModel($didCartItem, NULL, NULL);
    $addtoCart = $controller->createCartProduct($cartIdentifier, $body);
    echo "<br/><br/>";
    echo "<b>addtoCart Response</b><br/>";
    echo "status: ".$addtoCart->status."<br/>";
    echo "<br/><br/>";

    //Get orderProductId for removeCart
    $listCart = $controller->getCartDetails($cartIdentifier);
    echo "<b>Get orderProductId (listCart) Response</b><br/>";
    echo "orderProductId: ".$listCart->carts[0]->orderProducts[0]->orderProductId."<br/>";
    echo "orderQuantity: ".$listCart->carts[0]->orderProducts[0]->quantity."<br/>";
    echo "<br/><br/><br/>";
    $orderProductId = $listCart->carts[0]->orderProducts[0]->orderProductId;
    $orderQuantity = $listCart->carts[0]->orderProducts[0]->quantity;

    //Remove From Cart
    function removeFromTheCart($cartIdentifier, $orderProductId) {
      $controller = new OrderingController();
      $removequantity = 1;
      $body = new QuantityModel($removequantity);
      $removeFromCart = $controller->createCartProductRemove($cartIdentifier, $orderProductId, $body);
      echo "<b>removeFromCart Response</b><br/>";
      echo "status: ".$removeFromCart->status."<br/>";
      echo 'removed one item';
      echo "<br/><br/><br/>";
    };
      removeFromTheCart($cartIdentifier, $orderProductId);

      //List Cart
      $listTheCart = $controller->getCartDetails($cartIdentifier);
      echo "<b>Get orderProductId (listCart) Response</b><br/>";
      echo "orderProductId: ".$listTheCart->carts[0]->orderProducts[0]->orderProductId."<br/>";
      echo "orderQuantity: ".$listTheCart->carts[0]->orderProducts[0]->quantity."<br/>";
      echo "<br/><br/>";

      //Checkout Cart
      $cartCheckout = $controller->getCartCheckout($cartIdentifier);
      echo "<b>CheckoutCart Response</b><br/>";
      echo "orderReference: ".$cartCheckout->productCheckoutList[0]->orderReference."<br/>";
      echo "status: ".$cartCheckout->status."<br/>";
      echo "<br/><br/>";
      $orderReference = $cartCheckout->productCheckoutList[0]->orderReference;

      //Cancel DIDs
      //First listDidIds
      $getDidIds = $inventoryController->getDids(1, 0, NULL, NULL, NULL, NULL, $orderReference);
      echo "<b>Get DID Ordered Response</b><br/>";
      echo "didid: ".$getDidIds->dids[0]->didId."<br/>";
      $didId = $getDidIds->dids[0]->didId;
      echo "<br/><br/>";
      $didIds = array($didId);
      $body = new DidIdListModel($didIds);
      $cancelDids = $controller->createCancel($body);
      echo "<b>Get Cancel Response</b><br/>";
      echo "numberCancelled: ".$cancelDids->numberCancelled."<br/>";
      echo "<br/><br/>";

    function listTheOrder($orderReference) {
      //List Order
      $controller = new OrderingController();
      $listOrder = $controller->getOrders(0, 1, $orderReference, NULL, NULL, NULL, NULL, NULL, NULL);
      echo "<b>List Order Response</b><br/>";
      echo "orderId: ".$listOrder->orders[0]->orderId."<br/>";
      echo "reference: ".$listOrder->orders[0]->reference."<br/>";
      echo "dateAdded: ".$listOrder->orders[0]->dateAdded."<br/>";
      echo "dateCanceled: ".$listOrder->orders[0]->dateCanceled."<br/>";
      echo "status: ".$listOrder->orders[0]->status."<br/>";

      echo "<br/><br/><br/>";
    };
    listTheOrder($orderReference);

    //List Carts
      $listCarts = $controller->getCarts(0,2);
      echo "<b>Get List Carts Response: Cart 1</b><br/>";
      echo "cartIdentifier: ".$listCarts->carts[0]->cartIdentifier."<br/>";
      echo "customerReference: ".$listCarts->carts[0]->customerReference."<br/>";
      echo "description: ".$listCarts->carts[0]->description."<br/>";
      echo "dateAdded: ".$listCarts->carts[0]->dateAdded."<br/>";
      echo "orderProductId: ".$listCarts->carts[0]->orderProducts[0]->orderProductId."<br/>";
      echo "productType: ".$listCarts->carts[0]->orderProducts[0]->productType."<br/>";
      echo "productDescription: ".$listCarts->carts[0]->orderProducts[0]->productDescription."<br/>";
      echo "quantity: ".$listCarts->carts[0]->orderProducts[0]->quantity."<br/>";
      echo "didgroupId: ".$listCarts->carts[0]->orderProducts[0]->didgroupId."<br/>";
      echo "<br/><br/>";
      echo "<b>Get List Carts Response: Cart 2</b><br/>";
      echo "cartIdentifier: ".$listCarts->carts[1]->cartIdentifier."<br/>";
      echo "customerReference: ".$listCarts->carts[1]->customerReference."<br/>";
      echo "description: ".$listCarts->carts[1]->description."<br/>";
      echo "dateAdded: ".$listCarts->carts[1]->dateAdded."<br/>";
      echo "orderProductId: ".$listCarts->carts[1]->orderProducts[0]->orderProductId."<br/>";
      echo "productType: ".$listCarts->carts[1]->orderProducts[0]->productType."<br/>";
      echo "productDescription: ".$listCarts->carts[1]->orderProducts[0]->productDescription."<br/>";
      echo "quantity: ".$listCarts->carts[1]->orderProducts[0]->quantity."<br/>";
      echo "didgroupId: ".$listCarts->carts[1]->orderProducts[0]->didgroupId."<br/>";
      echo "<br/><br/>";
  }else
  {
    echo "Not enough funds to create cart...";
  }
  

}catch (APIException $e) {
    echo 'Caught exception: ',  $e->getMessage(), "<br/><br />\n";
    echo 'error code is: ', $e->getResponseCode()," ", $e->getReason();
}

?>
