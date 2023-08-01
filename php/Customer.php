<?php

// model class for customer
class Customer
{

    private $customerID;
    private $name;
    private $email;
    private $phoneNumber;
    private $address;

    public function __construct($customerID, $name, $email, $phoneNumber, $address)
    {
        $this->customerID = $customerID;
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
    }

    public function getCustomerID()
    {
        return $this->customerID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAddress()
    {
        return $this->address;
    }
}
