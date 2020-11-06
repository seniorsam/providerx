<?php 
namespace App\Services\DataProviders;

class DataProviderY extends DataProvider {

    public $name = 'DataProviderY';

    /**--------------------------------------------------------
     * this function used to return all data without filters
     ----------------------------------------------------------*/
    function getProviderAllData(){
        $this->sourceFile = public_path() . '/'.$this->name.'.json';
        return Parent::getProviderAllData()->users;
    }

    /**--------------------------------------------------------
     * set provider filters available configurations
     ----------------------------------------------------------*/
    function getProviderAvailableFilters(){
        return [
            'balanceMax' => [
                'condition' => '<=',
                'key' => 'balance',
                'inputSetter' => 'setInput'
            ],
            'balanceMin' => [
                'condition' => '>=',
                'key' => 'balance',
                'inputSetter' => 'setInput'
            ],
            'currency'=> [
                'condition' => '=',
                'key' => 'currency',
                'inputSetter' => 'setInput'
            ],
            'statusCode' => [
                'condition' => '=',
                'key' => 'status',
                'inputSetter' => 'setStatusInput'
            ]
        ];

    }

    /**--------------------------------------------------------
     * manipulate status value in this provider data
     ----------------------------------------------------------*/
    function setStatusInput($inputValue){
        $statuses = [
            'authorised' => 100,
            'decline' => 200,
            'refunded' => 300
        ];
        return (isset($statuses[$inputValue])) ? $statuses[$inputValue] : 0;
    }

}