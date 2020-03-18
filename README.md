# Tillo API Client Library for PHP #
The Tillo API Client Library enables you to work with Tillo API v2.

### Requirements ##
* [PHP 7.2.0 or higher](http://www.php.net/)

### API Documentation ##
https://tillo.tech/

# Installation ##

The preferred method is via [composer](https://getcomposer.org). Follow the
[installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have
composer installed.

Once composer is installed, execute the following command in your project root to install this library:

```sh
composer require tilloops/tillo:dev-master
```

Finally, be sure to include the autoloader:

```php
require_once '/path/to/your-project/vendor/autoload.php';
```

## Examples ##
See the [`examples/`](examples) directory for examples of the key client features.


### Basic Example ###

**Console Command / Terminal**
```bash
php examples/console/IssueCode.php --apiKey=xxxxxxx --apiSecret=xxxxxxx --apiBase=xxxxxxx --brand=xxxxxxx --amount=xx.xx
```
*Response*
```bash
Success to issue the code

Request signature: 1a287fa9b034f428b4e892a6801803b613bc0f4e9468ced55a3f603e1ee37c10

Card created successfully

Brand            : amazon
Amount           : 42.00 GBP
Code             : FAA3-9YDQ8E-SMBF

Expiration       : 04/04/2029 22:59
```

**Files / Browser**
```php
// include your composer dependencies
require_once 'vendor/autoload.php';

$apiKey = "YOUR_API_KEY";
$apiSecret = "YOUR_API_SECRET";
$apiBase = "YOUR_API_BASE_URL";

$client = new RewardCloud($apiKey, $apiSecret, $apiBase);

$digitalCodeParams = [
   'client_request_id'=> '[[CLIENT_REQUEST_ID]]',
   'brand'=> '[[brand_slug]]',
   'face_value'=> [
       'amount'=> 6.00,
       'currency'=> 'GBP'
   ],
   'delivery_method'=> 'code',
   'fulfilment_by'=> 'partner',
   'fulfilment_parameters'=> [
       'to_name'=> 'Receiver',
       'to_email'=> 'john@reward.cloud',
       'from_name'=> 'Reward Cloud',
       'from_email'=> 'noreply@reward.cloud',
       'subject'=> 'Here is your gift card!'
   ],
   'personalisation'=> [
       'to_name'=> 'Recipient',
       'from_name'=> 'Sender',
       'message'=> 'Here is your gift',
       'template'=> 'standard'
   ],
   'sector'=> 'cash-out'
];

$digitalCode = $client->digitalCode->issue($digitalCodeParams);

```
*Response*
```php
$digitalCode
[
  'status'=> 'success',
  'code'=> '000',
  'message'=> 'Human-readable message',
  'data'=> [
    'url'=> 'http://revealyourgift.com/blah/blah',
    'expiry'=> '2018-05-01',
    'serial_number'=> 'Optional serial number',
    'security_code'=> 'Optional security code',
    'barcode'=> [
      'type'=> 'CODE128',
      'string'=> 'ABS1234567',
      'url'=> 'https://revealyourgift.com/barcode?code=ABS1234567'
    ],
    'float_balance'=> [
      'currency'=> 'GBP',
      'amount'=> 20763.3
    ],
    'face_value'=> [
      'amount'=> 129.5,
      'currency'=> 'GBP'
    ],
    'reference'=> 'Reward Cloud unique reference'
  ]
]
*/
```

### Available Methods ###

- [Digital Gift Cards](#digital-gift-cards)
- [Physical Gift Cards](#physical-gift-cards)
- [Brand Information](#brand-information)
- [Brand Templates](#brand-templates)



## Digital Gift Cards 
Check [Tillo API Docs](https://api.tillo.tech/) for more
information about the parameters


| Method              | Description                                             | Syntax                                       |
|---------------------|---------------------------------------------------------|----------------------------------------------|
|Issue Digital Code   | Issue a new digital gift card                           | `$client->digitalCode->issue($params)`       |
|Cancel Digital Code  | Cancel an issued digital gift card                      | `$client->digitalCode->cancel($params)`      |
|Reverse Digital Code | Reverse a digital gift card                             | `$client->digitalCode->reverse($params)`     |
|Cash Out Digital Code| Cash out a digital gift card                            | `$client->digitalCode->cashOut($params)`     |
|Check Stock          | Brands are able to to top up the stock when running low.| `$client->digitalCode->checkStock($params)`  |
|Balance Check        | Check the balance of a gift code                        | `$client->digitalCode->checkBalance($params)`|


## Physical Gift Cards 
Check [Tillo API Docs](https://api.tillo.tech/) for more
information about the parameters


| Method                         | Description                                                               | Syntax                                       |
|--------------------------------|---------------------------------------------------------------------------|---------------------------------|
|Activate Physical Card          |Activate a physical gift card using the gift card number or serial number. | `$client->physicalCard->activate($params)`        |
|Cancel Activate Physical Card   |Cancel an activated physical gift card using the gift card number or serial number.| `$client->physicalCard->cancel($params)`       |
|Top-up Physical Card            |Top up a physical gift card using the gift card number or serial number.   | `$client->physicalCard->topUp($params)`      |
|Cancel Top-up on a Physical Card|Cancel a top-up on a physical gift card using the gift card number or serial number. |`$client->physicalCard->topUpCancel($params)`      |
|Cash Out Physical Card          |Cash out a physical gift card                                              | `$client->physicalCard->cashOut($params)`   |
|Order Physical Card             |Order a physical gift card                                                 | `$client->physicalCard->order($params)` |
|Physical Card Order Status      |Check the status of a physical gift card order                             | `$client->physicalCard->orderStatus($params)` |
|Fulfil Physical Card Order      |Fulfilment houses can fulfil a physical gift card order                    | `$client->physicalCard->fulfil($params)` |
|Balance Check Physical          |Check the balance of a physical gift card                                  | `$client->physicalCard->balance($params)` |


## Brand Information
These calls are provided to allow your system to retrieve information about the brands you have set up on your account.  
They can be integrated in to your system to reduce the need to visit our hubs on a regular basis, and automatically
update brand information in your own platform.  
  
Check [Tillo API Docs](https://api.tillo.tech/) for more
information about the parameters.


| Method      | Description                                                 | Syntax                                 |
|-------------|-------------------------------------------------------------|----------------------------------------|
|List Brands  | Provides a list of brands and basic information about them. | `$client->brand->list($params)`        |
|Check Floats | Request your current Monies on Account and Credit balances. | `$client->brand->checkFloat($params)`  |



## Brand Templates
  Check [Tillo API Docs](https://api.tillo.tech/) for more
information about the parameters.


| Method        | Description                                                | Syntax                                |
|---------------|------------------------------------------------------------|---------------------------------------|
|List Templates |Fetch a list of templates, variations and current versions. |`$client->template->list($params)`     |
|Get Template   | Fetch a specific template for a brand.                     |`$client->template->request($params)`  |
