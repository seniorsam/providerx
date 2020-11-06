<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{

    public $results;
    public $registeredProviders = [
        'DataProviderX',
        'DataProviderY'
    ];

    function users(Request $request){
        /**-------------------------------------
         * if user choose specific provider
         ---------------------------------------*/
        if(isset($request->provider) && in_array($request->provider, $this->registeredProviders)){
            $providerClassName = 'App\Services\DataProviders' . '\\' . $request->provider;
            $this->callProvider(new $providerClassName(), $request);
            return $this->results;
        /**-----------------------------------------------------------------------------------------
         * user didn't choose specific provider so we going to work with all registered providers
         -------------------------------------------------------------------------------------------*/
        } else {
            foreach($this->registeredProviders as $value){
                $providerClassName = 'App\Services\DataProviders' . '\\' . $value;
                $this->callProvider(new $providerClassName(), $request);
            }
            return $this->results;
        }

    }

    public function callProvider($provider, $request){
        if(empty($request))
            $this->results[$provider->name] = $provider->getProviderAllData();
        else 
            $this->results[$provider->name] = $provider->getProviderFilteredData($request->all());
    }
}
