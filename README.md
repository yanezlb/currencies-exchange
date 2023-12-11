# ExchangeOfVED - LATAM Exchange Rates

ExchangeOfVED is a PHP class designed to retrieve exchange rates for specified currencies from Banco Central de Venezuela for several LATAM countries.

## Features

- Fetches exchange rates from www.bcv.org.ve for specific currencies.
- Provides the latest exchange rate and date.

## Installation

Install via Composer:

```bash
composer require your-vendor/exchange-of-ved 
```

## How to use

```php
/* 
Create an instance of the ExchangeOfVED class by specifying the ISO currency code for the currency you want to retrieve the  
exchange rate for: 
*/

$exchange = new ExchangeOfVED('USD');
$exchangeRateData = $exchange->getVEDExchangeRate();

$exchangeRate = $exchangeRateData['price'];
$exchangeDate = $exchangeRateData['date'];
```

## Important

Ensure PHP version 8.3 or higher is used.
Supported currencies include USD, EUR, RUR, and CNY. Modify the ISO currency code when instantiating the class for different currencies.
Handle exceptions and errors regarding network issues or changes in the website's HTML structure that might affect data retrieval.

