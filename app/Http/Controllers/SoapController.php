<?php

namespace App\Http\Controllers;
use App\Http\Controllers\InstanceSoapClient;

class SoapController extends BaseSoapController
{
    public function soap(){
        try {
            self::setWsdl('http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl');
            $service = InstanceSoapClient::init();
            $countryCode = 'DK';
            $vatNumber = '47458714';


            $params = [
                'countryCode' => request()->input('countryCode') ? request()->input('countryCode') : $countryCode,
                'vatNumber'   => request()->input('vatNumber') ? request()->input('vatNumber') : $vatNumber
            ];
            $response = $service->checkVat($params);
            return view ('soap', compact('response'));
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
