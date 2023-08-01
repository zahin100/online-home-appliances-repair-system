<?php

// model class for staff
class Staff
{

    private $staffID;
    private $name;
    private $phoneNumber;


    public function __construct($staffID, $name, $phoneNumber)
    {
        $this->staffID = $staffID;
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
    }

    public function getStaffID()
    {
        return $this->staffID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
}
