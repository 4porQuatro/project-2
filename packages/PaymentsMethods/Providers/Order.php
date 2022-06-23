<?php


namespace Packages\PaymentsMethods\Providers;


class Order {

    private $description;
    private $order_id;
    private $order_date;
    private $total;
    public $order_uuid;


    public function getData()
    {
        return
            [
                "transaction_key" => $this->getOrderId(),
                "descriptive" => $this->getDescription(),
                "capture_date" => $this->getOrderDate(),
        ];
    }
    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id): void
    {
        $this->order_id = $order_id;
    }

    /**
     * @param mixed $order_date
     */
    public function setOrderDate($order_date): void
    {
        $this->order_date = $order_date;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return strval($this->order_id);
    }

    /**
     * @return mixed
     */
    public function getOrderDate()
    {
        return $this->order_date;
    }

    /**
     * @return mixed
     */
    public function total()
    {
        return floatval($this->total);
    }

    public function setOrderUuid($order_uuid)
    {
        $this->order_uuid = $order_uuid;
    }
}

