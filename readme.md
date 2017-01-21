# Emoji Calculator

**Emoji Calculator** is a tiny project for the purpose of demonstration of some basic PHP skills working with**Laravel 5.3** and **Bootstrap v3.3.6**. 

## How to set up and run it

We have firstly to clone the project locally: `git clone https://github.com/thitami/EmojiCalculator.git`

As soon as it the clone process is finished, please run `composer install` so to install the project and all its dependencies.

In our terminal we start a new server `php artisan serve`, which uses PHP's built-in server and by default listens to port `:8000`.

Then, we visit `localhost:8000` in a browser and we are ready to use it!

## Approach

When we hit `localhost:8000` the following actions take place:

1. The `Route::get('/','CalculatorController@homepage')` route is matched in `web.php`
2. The `CalculatorService` is called to load the Operand symbols supplied in the `.env` file.
3. If the user has filled in (by mistake, or not so...) the same symbol for a different operation, then the defaults are loaded as defined in `config/calculator.php` file, and rendered in the view.
          We are using a basic layout, which is stored under `resources/views/calculator/home.blade.php`.
4. The user fills in numeric values in the Operand 1 and Operand 2 fields and hits the "=" button, where we post the form 
matching the route: `Route::post('/calculate',['as' => 'calculator.getResult', 'uses' => 'CalculatorController@getResult']);`
5. The user can also select a different value from the dropdown menu and the result will be automatically calculated on the server side and displayed in the results field.           

## Update Emojis
The emojis used by the calculator can be configured in the `.env` file: 

```
 CALCULATOR_ADD_OPERAND = '&#128125;'
 CALCULATOR_SUBTRACT_OPERAND = '&#128128;'
 CALCULATOR_DIVIDE_OPERAND = '&#128123;'
 CALCULATOR_MULTIPLY_OPERAND = '&#128561;'
 ```
 
Please consider that if we set the same symbol for a different operation then the following defaults
 will be loaded:
            
         'add' => '&#128125;',
         'subtract' => '&#128128;',
         'multiply' => '&#128123;',
         'divide' => '&#128561;',

## Tests
This project has a unit test coverage. PHPUnit tests can be found in `tests/CalculationTest.php` and get simply executed
with the command `phpunit` from the base directory.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
