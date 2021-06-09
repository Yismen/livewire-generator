# Dainsys Livewire Generator   
A livewire CRUD Generator for tailwind and bootstrap 4!

## Installation
* Install with `composer` by runining the command `composer require dainsys/livewire-generator --dev`

### Ussage
* Run artisan command `php artisan make:livewire-crud`. This command accepts two optional parameters: the componenet file name and the model to be associated to the crud.
* If the optional parameters are not passed, the command will ask for them.
* If you are using bootstrap and jquery as your front end, run the command with the `--preset=bootstrap` option.
* If your models live in a different folder than `App\Models` you can pass that directory route with the option `--models-dir=App`.
* Use the `--force` option to override any existing file.
