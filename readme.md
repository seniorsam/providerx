## Access Information

App is hosted in heroku with the following cards
- Base Url: https://providerx.herokuapp.com/
For example to call the users api
- https://providerx.herokuapp.com/api/v1/users
For example to call the users api with filters
- https://providerx.herokuapp.com/api/v1/users?provider=DataProviderX

## Code quality, scalability

I builded this api using custom services, and i tried to decouble and seperate the concerns to make it easy to add new providers with small changes.

## Ability to add DataProviderZ by small changes

steps in order to add new provider for example "DataProviderZ"

- Create a new class file inside "app\Services\DataProviders" under namespace "App\Services\DataProviders" for example class "DataProviderZ".
- make it extends "DataProvider" the main abstract class for the providers.
- add the provider class name to the $registeredProviders to the UsersController.

### configure the created class "DataProviderZ"

- set the provider $name property.
- create the getProviderAllData() function.
- create getProviderAvailableFilters() where you can create your provider specific filters configuration.
- create any other function you want to manipualte returned user inputs and user it in the fiters configuration.

<b> you can check the already existed "DataProviderX" as a reference. </b>

### More Explanasion for "getProviderAvailableFilters()" function

in this section iam going to take a snippet and try to explain it to make this part clear

<pre>
'balanceMax' => [
    'condition' => '<=',
    'key' => 'balance',
    'inputSetter' => 'setInput'
],
</pre>

- <b>'balanceMax'</b> <br /> represent the filter key which is passed by the user in the query parameter, 
according to the requirement we name it 'balanceMax' but you can change it as you like.
- <b>'condition'</b> <br /> represent the condition that will be used between provider data and the user filter.
- <b>'key' <br /></b> the key in the returned provider data. 
    
- <b>'inputSetter'</b> 
    <br /> according to the requirement you said that you are going to pass filter "statusCode=authorised", <br /> and this can't be  done directly because "authorised" not a direct value in the returned provider data, <br /> because it gets translated in the provider to numbers such that "authorised" means "1" for the provider. <br /> so i had to manipulate this by passing the user input to a function, which i put its name in 'inputSetter' and this function manipulate the user input value <br />
    <b> this key is optional </b>

i hope you understand the app so far and let me know if you have any question