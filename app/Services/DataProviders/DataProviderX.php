<?php 
namespace App\Services\DataProviders;

class DataProviderX extends DataProvider {

    public $name = 'DataProviderX';

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
                'key' => 'parentAmount'
            ],
            'balanceMin' => [
                'condition' => '>=',
                'key' => 'parentAmount'
            ],
            'currency'=> [
                'condition' => '==',
                'key' => 'Currency'
            ],
            'statusCode' => [
                'condition' => '==',
                'key' => 'statusCode',
                'inputSetter' => 'setStatusInput'
            ]
        ];

    }

    /**--------------------------------------------------------------------------------------------------------------------
     * use this function name as the inputSetter in "getProviderAvailableFilters" function to manipulate the status value
     * it simply take the user input value and manipulate it
     ----------------------------------------------------------------------------------------------------------------------*/
    function setStatusInput($inputValue){
        $statuses = [
            'authorised' => 1,
            'decline' => 2,
            'refunded' => 3
        ];
        return (isset($statuses[$inputValue])) ? $statuses[$inputValue] : 0;
    }

}