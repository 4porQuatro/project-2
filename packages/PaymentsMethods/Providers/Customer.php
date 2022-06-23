<?php


namespace Packages\PaymentsMethods\Providers;


use Exception;

class Customer {

    public $nif;
    public $email;
    public $key;
    public $phone_indicative;
    public $phone;
    public $name;

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


    public function getData()
    {
        return [
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "key" => $this->getKey(),
            "phone_indicative" => $this->getPhoneIndicative() ?? '',
            "phone" => $this->getPhone() ?? '',
            "fiscal_number" => $this->getNif(),
        ];

    }

    /**
     * @return mixed
     */
    public function getNif()
    {
        if(empty($this->nif)){
            throw new Exception('You must implement the setter setNif() on your customer class');
        };
        return $this->nif;
    }


    /**
     * @return mixed
     * @throws Exception
     */
    public function getName()
    {
        if(empty($this->name)){
            throw new Exception('You must implement the setter setName() on your customer class');
        };
        return $this->name;
    }


    /**
     * @return mixed
     * @throws Exception
     */
    public function getEmail()
    {
        if(empty($this->email)){
            throw new Exception('You must implement the setter setEmail() on your customer class');
        };
        return $this->email;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getKey()
    {
        if(empty($this->key)){
            throw new Exception('You must implement the setter setKey() on your customer class');
        };
        return strval($this->key);
    }

    /**
     * @return mixed
     */
    public function getPhoneIndicative()
    {
        return $this->phone_indicative;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }


    /**
     * @param mixed $nif
     */
    public function setNif($nif): void
    {
        $this->nif = $nif;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key): void
    {
        $this->key = $key;
    }

    /**
     * @param mixed $phone_indicative
     */
    public function setPhoneIndicative($phone_indicative): void
    {
        $this->phone_indicative = $phone_indicative;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }





}
