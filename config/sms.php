<?php
return [
  // SMS Gateway API Data
  'url'      => env('SMS_GATEWAY_URL'),
  'username' => env('SMS_GATEWAY_USERNAME'),
  'password' => env('SMS_GATEWAY_PASSWORD'),

  // GreenWeb Gateaway API Data
  'gw_url'    => env('GREEN_WEB_URL'),
  'gw_token'  => env('GREEN_WEB_API_TOKEN'),
];