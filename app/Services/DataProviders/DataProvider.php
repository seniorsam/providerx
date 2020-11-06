<?php
namespace App\Services\DataProviders;

abstract class DataProvider{

    protected $sourceFile;

    protected function getProviderAllData(){
        return json_decode( file_get_contents( $this->sourceFile ) );
    }

    public function getUserRequiredFilters($userRequest){
        $op = [];
        $providerAvailableFilters = $this->getProviderAvailableFilters();
        foreach($userRequest as $key => $value){
            if(isset($providerAvailableFilters[$key])){
                $op[$key] = $providerAvailableFilters[$key];
                if(isset($providerAvailableFilters[$key]['inputSetter'])){
                    $op[$key]['userInput'] = $this->{$providerAvailableFilters[$key]['inputSetter']}($value);
                } else {
                    $op[$key]['userInput'] = $value;
                }
            }
        }

        return $op;
    }

    public function getProviderFilteredData($userRequest){
        $userRequiredfilters = $this->getUserRequiredFilters($userRequest);
        $collection = collect($this->getProviderAllData());
        foreach($userRequiredfilters as $filterKey => $filterValue){
            $collection = $collection->where($filterValue['key'], $filterValue['condition'], $filterValue['userInput']);
        }
        return $collection;
    }

    abstract function getProviderAvailableFilters();
    

}