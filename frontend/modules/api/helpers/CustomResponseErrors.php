<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\api\helpers;

use Yii;

class CustomResponseErrors {

    //User errors 
    CONST INVALID_PASSWORD = "Invalid email or password";
    CONST USER_NOT_FOUND = "Invalid user id or access token";
    CONST USER_INVALID_PASSWORD = "Invalid user password";
    CONST USER_WRONG_DEVICE_ID = "Wronge device id please contact administrator to change your device id";
    CONST USER_WRONG_USER_ROLL = "Driver only can login to the app";
    CONST USER_NOT_EXIST_OR_NOT_ACTIVE = "User not exist or not active";
    CONST USER_SUSPENDED = 'your account has been suspended';
    CONST USER_ACTION_NOT_ALLOWED = 'Action not allowed';
    CONST USER_CONTACT_NOT_FOUND = 'Contact record not found';
    CONST USER_INVALID_ACTIVATION_CODE = 'Invalid activation code';
    CONST USER_PHONE_NOT_EXIST= "Phone number not exist";
    // cart errors 
    CONST ITEM_NOT_FOUND_IN_CART = 'Item not found in the cart';
    // Location errors 
    CONST LOCATION_NOT_FOUND = 'City not found';
    // Vouchers errors 
    CONST INVALID_VOUCHER_CODE = 'inserted code not valid';
    // Delivery methods errors 
    CONST DELIVERY_METHOD_INVALID = 'Invalid delivery method';

}
