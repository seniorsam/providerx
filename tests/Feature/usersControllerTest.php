<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class usersControllerTest extends TestCase
{
    public function testGetAllUsers()
    {
        $response = $this->get('/api/v1/users');
        $response->assertStatus(200);
    }

    public function testGetAllProvidersDataWhenPassWrongProviderName()
    {
        $wrongProviderName = 'wrongProviderName';
        $response = $this->get('/api/v1/users?provider='.$wrongProviderName);
        $response->assertStatus(200);
    }

    public function testGetSingleProviderData()
    {
        $correctProviderName = 'DataProviderX';
        $response = $this->get('/api/v1/users?provider='.$correctProviderName);
        $response->assertStatus(200);
    }

    public function testGetFilteredDataFromSingleProvider()
    {
        $correctProviderName = 'DataProviderX';
        $currency = 'AED';
        $balanceMin = '100';
        $response = $this->get('/api/v1/users?provider='.$correctProviderName.'&currency='.$currency.'&balanceMin='.$balanceMin);
        $response->assertStatus(200);
    }

}
