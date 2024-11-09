# Advent of code

# Install
```bash
$ composer install
```

# Running
### Preparing puzzle
_Creates solution-class, loads puzzle input_
```bash
$ make prepare DAY=1.1 [YEAR=2023]
```

### Debugging solution
_Runs tests and solution itself with debug enabled_
```bash
$ make test DAY=1.1 [YEAR=2023]
```

### Testing solution
_Runs tests for the solution, also print the result. Same as previous, but without debug_
```bash
$ make test DAY=1.1 [YEAR=2023]
```

### Sending solution
_Sends result to the adventofcode server_
```bash
$ make send DAY=1.1 [YEAR=2023]
```

### Creating tests
To make tests for the solution you should make any amount of test*** methods, they will be launched and checked on `make test` command.
```php
    public function testExample(): void
    {
        if ($this->solve('test_input') !== 'test_output') {
            throw new RuntimeException('Test failed');
        } 
    }
```