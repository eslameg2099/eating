<?php

namespace App\Support\Payment\Contracts;

interface TransactionTypes
{
    /**
     * The code of purchase amount type.
     *
     * @var int
     */
    const PURCHASE_AMOUNT_TYPE = 1;

    /**
     * The code of delegate profits type.
     *
     * @var int
     */
    const DELEGATE_PROFITS_TYPE = 2;

    /**
     * The code of app profits type.
     *
     * @var int
     */
    const APP_PROFITS_TYPE = 3;

    /**
     * The code of recharge type.
     *
     * @var int
     */
    const RECHARGE_TYPE = 4;

    /**
     * The code of withdrawal type.
     *
     * @var int
     */
    const WITHDRAWAL_TYPE = 5;

    /**
     * The code of tax value type.
     *
     * @var int
     */
    const TAX_VALUE_TYPE = 6;

    /**
     * The code of discount value type.
     *
     * @var int
     */
    const DISCOUNT_VALUE_TYPE = 7;

    /**
     * The code of delegate freeze amount type.
     *
     * @var int
     */
    const DELEGATE_FREEZE_AMOUNT_TYPE = 8;

    /**
     * The code of order total amount type.
     *
     * @var int
     */
    const ORDER_TOTAL_AMOUNT_TYPE = 9;

    /**
     * The code of balance recharge type.
     *
     * @var int
     */
    const BALANCE_RECHARGE = 10;
}