<?php
namespace App\Http\Controllers;

class SoapController extends BaseSoapController
{
    private $service;

    public function BienesServicios(){
        try {
            self::setWsdl('http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl');
            $this->service = InstanceSoapClient::init();

            $countryCode = 'DK';
            $vatNumber = '47458714';

            $params = [
                'countryCode' => request()->input('countryCode') ? request()->input('countryCode') : $countryCode,
                'vatNumber'   => request()->input('vatNumber') ? request()->input('vatNumber') : $vatNumber
            ];
            $response = $this->service->checkVat($params);
            return view ('bienes-servicios-soap', compact('response'));
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function clima(){
        try {
            self::setWsdl('http://www.webservicex.net/globalweather.asmx?WSDL');
            $this->service = InstanceSoapClient::init();

            $cities = $this->service->GetCitiesByCountry(['CountryName' => 'Peru']);
            $ciudades = $this->loadXmlStringAsArray($cities->GetCitiesByCountryResult);
            dd($ciudades['Table'][1]);
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
