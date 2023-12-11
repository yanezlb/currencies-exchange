<?php 
require 'vendor/autoload.php';

/**
 * ExchangeOfVED Class - Retrieves exchange rates for specified currencies from www.bcv.org.ve.
 *
 * Provides methods to fetch exchange rates of various currencies
 * using DOM manipulation from the Banco Central de Venezuela website.
 *
 * @license MIT License
 * @link https://www.example.com
 * @author Luis Yanez
 * @since PHP 8.3
 */

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;


class ExchangeOfVED {
    
    private $isoCurrency;
    private $browser; 
    private $domCrawler;
    private $replaceRegex = "/[^0-9\.]/";
    private const URL = 'https://www.bcv.org.ve';

    
    public function __construct(string $isoCurrency)
    {
        // Initializing the HTTP browser and making a GET request to the specified URL
        $this->browser = new HttpBrowser(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
        $this->domCrawler = $this->browser->request('GET', $this::URL);
        $this->isoCurrency = $isoCurrency;
    }

    public function getVEDExchangeRate() : array 
    {        
        $currencyName = $this->getCurrencyName( $this->isoCurrency );        
        $price = $this->domCrawler->filter("div#{$currencyName}")->first()->text();        
        $price = $this->clearString( $price );

        return [ 'price' => $price, 'date' => $this->getDate() ];
    }
    
    private function getCurrencyName(string $iso) : string 
    {    
        $currencyName = match ($iso)  {
            'USD' => 'dolar',
            'EUR' => 'euro',
            'RUR' => 'rublo',
            'CNY' => 'yuan',
        };

        return $currencyName;
    }
    
    private function clearString(string $priceString) : float 
    {                
        $priceString = str_replace(',', '.', $priceString);
        return (float) preg_replace($this->replaceRegex, '', $priceString);
    }
    
    private function getDate() : string 
    {        
        $dateStr = $this->domCrawler->filter('div.dinpro > span')->first()->attr('content');
        return date('Y-m-d', strtotime($dateStr));
    }
} 