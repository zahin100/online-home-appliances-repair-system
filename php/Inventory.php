<?php

// model class for inventory
class Inventory
{

    private $inventoryID = array();
    private $name = array();
    private $image = array();
    private $price = array();
    private $quantity = array();
    private $totalPrice;


    public function __construct($inventoryID, $name, $image, $price, $quantity)
    {
        $this->inventoryID = $inventoryID;
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getInventoryID()
    {
        return $this->inventoryID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }
}
