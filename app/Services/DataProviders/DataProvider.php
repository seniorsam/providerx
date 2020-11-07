<?php
namespace App\Services\DataProviders;

abstract class DataProvider{

    protected $sourceFile;

    protected function getProviderAllData(){
        return json_decode( file_get_contents( $this->sourceFile ) );
    }

    public function getUserRequiredFilters($userFilters){
        $op = [];
        $providerAvailableFilters = $this->getProviderAvailableFilters();
        foreach($userFilters as $key => $value){
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

    public function getProviderFilteredData($userFilters){
        $userRequiredfilters = $this->getUserRequiredFilters($userFilters);
        $collection = collect($this->getProviderAllData());
        $filtersLine = $this->buildFiltersLine($userRequiredfilters);
        $filtered = $collection->filter(function ($value, $key) use ($filtersLine) {
            return eval($filtersLine);
        });
        return $filtered;
    }

    public function buildFiltersLine($userFilters){
        $filtersLine = '';
        foreach($userFilters as $filterKey => $filterValue){
            $filtersLine .= 'strtolower($value->' . $filterValue['key'] . ') ';
            $filtersLine .= $filterValue['condition'] . ' ';
            $filtersLine .= 'strtolower("' . $filterValue['userInput'] . '") && ';
            
        }
        return rtrim('return ' . $filtersLine, ' && ') . ';';
    }

    abstract function getProviderAvailableFilters();
    

}