<?php

class OrderEntity
{
	public $orderID;
    public $customerID;
	public $orderDate;
	public $totalPrice;
    public $orderStatus;
    
    function __construct($orderID, $customerID, $orderDate, $totalPrice, $orderStatus) {
       
		$this->orderID = $orderID;
 	    $this->customerID = $customerID;
		$this->orderDate = $orderDate;
		$this->totalPrice = $totalPrice;
        $this->orderStatus = $orderStatus;
	
    }

}

class OrderDetailsEntity{
	
	public $orderID;
	public $productID;
	public $quantity;
	public $discount;
	
	function __construct($orderID, $productID, $quantity, $discount){ 
       
		$this->orderID = $orderID;
		$this->productID = $productID;
		$this->quantity = $quantity;
		$this->discount = $discount;
	
    }
	
}



?>
