<?php


namespace Packages\Orders\App\Constants;


class OrderStatus {
    const PENDING = 0;
    const AWAITING_PAYMENT = 1;
    const AWAITING_FULFILLMENT = 2;
    const AWAITING_SHIPPMENT = 3;
    const PARTIALY_SHIPPED=4;
    const SHIPPED=5;
    const COMPLETED=6;
    const CANCELED=7;
    const REFUNDED=8;
    const DISPUTED=9;
    const RETURNED=10;
    //const MANUAL_VERIFICATION=10;
    //const PARTIALY_REFUNDED=11;


    public static function getDescriptions()
    {
        return [
            self::PENDING => 'order::cms.pending',
            self::AWAITING_PAYMENT => 'order::cms.awaiting_payment',
            self::AWAITING_FULFILLMENT => 'order::cms.awaiting_fulfillment',
            self::AWAITING_SHIPPMENT => 'order::cms.awaiting_shippment',
            self::PARTIALY_SHIPPED=> 'order::cms.partialy_shipped',
            self::SHIPPED => 'order::cms.shipped',
            self::COMPLETED => 'order::cms.completed',
            self::CANCELED => 'order::cms.canceled',
            self::REFUNDED => 'order::cms.refunded',
            self::DISPUTED => 'order::cms.disputed',
            self::RETURNED => 'order::cms.returned',
        ];
    }
}
