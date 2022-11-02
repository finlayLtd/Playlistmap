<?php

namespace App\Lib;

use \Stripe;

/**
 * Description of StripeController
 *
 * @author Arel Gindos
 */
class StripeController {

    private $stripeClientSecret;

    function getStripeClientSecret() {
        return $this->stripeClientSecret;
    }

    function setStripeClientSecret($stripeClientSecret): void {
        $this->stripeClientSecret = $stripeClientSecret;
    }

    public function __construct() {
        $this->stripeClientSecret = Config('services.stripe.secret');
    }

    public function validateCoupon($couponID) {
        $coupon = Stripe::coupons()->find($couponID);
        return $coupon && $coupon['valid'];
    }

}
