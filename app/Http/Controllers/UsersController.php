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
        // $con = eval('return ((25>1)||(25<1));');
        // return [$con];
        // exit;
        $providerName = $request->provider;
        $userFilters = $request->except('provider');
        /**-------------------------------------
         * if user choose specific provider
         ---------------------------------------*/
        if(!empty($providerName) && in_array($providerName, $this->registeredProviders)){
            $providerClassName = 'App\Services\DataProviders' . '\\' . $request->provider;
            $this->callProvider(new $providerClassName(), $userFilters);
            return $this->results;
        /**-----------------------------------------------------------------------------------------
         * user didn't choose specific provider so we going to work with all registered providers
         -------------------------------------------------------------------------------------------*/
        } else {
            foreach($this->registeredProviders as $value){
                $providerClassName = 'App\Services\DataProviders' . '\\' . $value;
                $this->callProvider(new $providerClassName(), $userFilters);
            }
            return $this->results;
        }

    }

    public function callProvider($provider, $userFilters){
        if(empty($userFilters))
            $this->results[$provider->name] = $provider->getProviderAllData();
        else 
            $this->results[$provider->name] = $provider->getProviderFilteredData($userFilters);
    }
}
