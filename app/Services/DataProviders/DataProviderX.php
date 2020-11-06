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
                'key' => 'parentAmount',
                'inputSetter' => 'setInput'
            ],
            'balanceMin' => [
                'condition' => '>=',
                'key' => 'parentAmount',
                'inputSetter' => 'setInput'
            ],
            'currency'=> [
                'condition' => '==',
                'key' => 'Currency',
                'inputSetter' => 'setInput'
            ],
            'statusCode' => [
                'condition' => '==',
                'key' => 'statusCode',
                'inputSetter' => 'setStatusInput'
            ]
        ];

    }

    /**--------------------------------------------------------
     * manipulate status value in this provider data
     ----------------------------------------------------------*/
    function setStatusInput($inputValue){
        $statuses = [
            'authorised' => 1,
            'decline' => 2,
            'refunded' => 3
        ];
        return (isset($statuses[$inputValue])) ? $statuses[$inputValue] : 0;
    }

}