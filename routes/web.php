<?php
Route::get('soap', 'SoapController@soap');

Route::get('/ejemplo01', function () {
    try {
        $opts = array(
            'http' => array(
                'user_agent' => 'PHPSoapClient'
            )
        );
        $context = stream_context_create($opts);

        $wsdlUrl = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';
        $soapClientOptions = array(
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_NONE
        );

        $client = new SoapClient($wsdlUrl, $soapClientOptions);

        $checkVatParameters = array(
            'countryCode' => 'DK',
            'vatNumber' => '47458714'
        );

        $result = $client->checkVat($checkVatParameters);
        print_r($result);
    }
    catch(\Exception $e) {
        echo $e->getMessage();
    }

});

Route::get('/ejemplo02', function () {
    $opts = array(
        'ssl' => array('ciphers'=>'RC4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
    );
    $params = array ('encoding' => 'UTF-8', 'verifypeer' => false, 'verifyhost' => false, 'soap_version' => SOAP_1_2, 'trace' => 1, 'exceptions' => 1, "connection_timeout" => 180, 'stream_context' => stream_context_create($opts) );
    $url = "http://www.webservicex.net/globalweather.asmx?WSDL";

    try{
        $client = new SoapClient($url,$params );
        dd($client);
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }

});

Route::get('/ejemplo03', function () {
    try {
        $opts = array(
            'http' => array(
                'user_agent' => 'PHPSoapClient'
            )
        );
        $context = stream_context_create($opts);

        $wsdlUrl = 'http://www.webservicex.com/CurrencyConvertor.asmx?wsdl';
        $soapClientOptions = array(
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_NONE
        );

        $client = new SoapClient($wsdlUrl, $soapClientOptions);
        $checkVatParameters = array(
            'FromCurrency' => 'USD',
            'ToCurrency' => 'EUR',
            'ConversionRateResult' => 22
        );
        //dd($client->__soapCall('ConversionRate', $checkVatParameters));
        dd($client->ConversionRate($checkVatParameters));
    }
    catch(\Exception $e) {
        echo $e->getMessage();
    }
});

Route::get('/ejemplo04', function () {
    //http://docs.guzzlephp.org/en/5.3/
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'http://www.webservicex.com/CurrencyConvertor.asmx?wsdl');
    dd($res->getBody());
    echo $res->getStatusCode();
    echo $res->getHeader('content-type');
    echo $res->getBody();


    $factory = new \Meng\AsyncSoap\Guzzle\Factory();
    $client = $factory->create(new \GuzzleHttp\Client(), 'http://www.mysoapserver.com?WSDL');

    $client->call(
        'MySoapFunction',
        ['arg1', 'arg2', 'arg3'],
        [
            new SoapHeader($this->config['namespace'], 'username', 'someone'),
            new SoapHeader($this->config['namespace'], 'password', 'somthing'),
        ]
    );
});