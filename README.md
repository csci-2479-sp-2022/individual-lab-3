# Lab Three

## Context
Tests, while they may seem daunting and unapproachable, are a critical piece of the development lifecycle, because they ensure that our app works as we developers expect it to. Every new feature should include tests to verify that the code is doing what it was meant to do.

This lab will give you some experience writing new tests, running tests, and inspecting a code coverage report so you can see what code in the app is and is not covered adequately.

## Standard local setup
1. open an Ubuntu terminal
   1. make sure you're in your home directory, where you've hopefully already created a projects folder: `cd ~/projects`
   2. make sure you have docker desktop running
2. clone this repo: `git clone git@github.com:csci-2479-sp-2022/individual-lab-2.git`
3. go into the project: `cd individual-lab-2`
4. copy the `.env.example` file to `.env`
5. run the following docker command to install our Sail dependencies:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
6. start up the app: `./vendor/bin/sail up -d`
7. create app key: `./vendor/bin/sail artisan key:generate`
8. run database migrations (we aren't using the database for this lab): `./vendor/bin/sail artisan migrate`
9. XDebug helper extension for Firefox/chrome (to avoid editing our Dockerfile):
   - https://github.com/mac-cain13/xdebug-helper-for-chrome
   - https://github.com/BrianGilbert/xdebug-helper-for-firefox

## Running tests
1. Normal: `sail artisan test`
2. Debug (so you can set a breakpoint in a test): `sail debug test`
3. To see a code coverage report in the terminal: `sail composer test:coverage`
   - This was setup as a custom composer script because `sail artisan test --coverage` will not work due to an `XDEBUG_MODE` conflict with our docker container

## Writing tests
The TestCase class has a lot built into it, both from Laravel and PHPUnit. The general formula for writing tests in any framework is Arrange, Act, Assert:
1. Arrange
   - Define any expected data
   - Setup any spies (mocked functions that can track behavior), using:
        ```
        $spy->shouldReceive('expectedMethod')
            ->with($arg)
            ->once() // number of times method should be called
            ->andReturn($expectedValue);
        ```
2. Act
   - Call whatever method should trigger the code under test. In our case it's calling a route, which our test class can do: `$this->get('/pets')`
3. Assert
   - Check that actual values match our expectations:
     - `$this->assertViewHas('key', $value)`
     - `$this->assertStatus(200)`

## Lab Instruction Steps
1. Verify you can run the project on localhost, and get from home -> pet list -> pet details
   - Note that petlist and pet details are served by the same route: `/pets/{id?}`
   - Note the logic in the PetController to handle both scenarios (with ID and without)
2. Verify you can run tests: `sail artisan test`
3. Create a new branch for your work
4. Create a new feature test to test the `PetController` class: `sail artisan make:test PetControllerTest`, and add the following:
   - Create a private static function `getPets()` that will return some mock pet data, e.g.:
        ```
        return [
            Pet::make([
                'id' => 1,
                'name' => 'Fido',
                'age' => 5,
                'type' => Pet::PET_TYPE_DOG,
            ]),
            Pet::make([
                'id' => 2,
                'name' => 'Milo',
                'age' => 3,
                'type' => Pet::PET_TYPE_CAT,
            ]),
        ];
        ```
    - Create private properties `array $pets` and `MockInterface $petServiceSpy`
    - Create a protected setUp function that will set `$pets = self::getPets()` and spy on PetService: `$this->spy(PetService::class)`
5. Create tests for:
   - `getPets` without an ID param returns a list of pets
   - `getPets` with a valid ID param returns a single pet
   - `getPets` with an invalid ID param returns a 404 response
6. Create a new unit test to test the `Pet` model: `sail artisan make:test PetTest`
7. Create a test for verifying that calling `toString()` returns the expected string
   - Arrange: define expected string value, initialize a `$pet` object
   - Act: call `$pet->toString()` to get actual string value
   - Assert expected and actual strings match: `$this->assertEquals($expectedString, $actualString)`
8. Commit your work to your branch and submit a pull request
   - assign Andrew as the reviewer
