<?php

test('the codebase does not reference env variables outside of config files.')
    ->expect('env')
    ->not->toBeUsed();

test('the codebase does not contain any debugging code.')
    ->expect([
        'dd',
        'dump',
        'var_dump',
        'die',
        'sleep',
        'usleep',
        'exit',
        'eval',
    ])
    ->not->toBeUsed();

test('basic php code quality checks')
    ->preset()
    ->php();

test('basic security checks')
    ->preset()
    ->security();

test('models must extend eloquent model')
    ->expect('App\Models')
    ->toBeClasses()
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->ignoring([
        'App\Models\Scopes',
        'App\Models\States',
    ]);

test('http layer must not leak outside its namespace')
    ->expect('App\Http')
    ->toOnlyBeUsedIn('App\Http')
    ->ignoring([
        'App\Http\Resources\PaginationResource',
        'App\Http\Middleware\InitializeTenancyByRequestHeader',
        'App\Enums\Contract\ContractTypeEnum',
    ]);

test('api controllers must be invokable')
    ->expect('App\Http\Controllers\Api')
    ->toBeInvokable()
    ->ignoring('App\Http\Controllers\Api\ApiBaseController');

test('api controllers must extend api base controller')
    ->expect('App\Http\Controllers\Api')
    ->toBeClasses()
    ->toExtend('App\Http\Controllers\Api\ApiBaseController');

test('controllers must have controller suffix')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller');

test('requests must have request suffix')
    ->expect('App\Http\Requests')
    ->toHaveSuffix('Request');

test('requests must extend form request')
    ->expect('App\Http\Requests')
    ->toBeClasses()
    ->toExtend('Illuminate\Foundation\Http\FormRequest');

test('requests must implement data transfer object interface')
    ->expect('App\Http\Requests')
    ->toBeClasses()
    ->toImplement('App\Contracts\Requests\HasDataTransferObjectInterface');

test('requests must have authorize, rules, toDto methods')
    ->expect('App\Http\Requests')
    ->toBeClasses()
    ->toHaveMethods(['authorize', 'rules', 'toDto']);

test('resources must have resource suffix')
    ->expect('App\Http\Resources')
    ->toHaveSuffix('Resource');

test('resources must extend json resource')
    ->expect('App\Http\Resources')
    ->toBeClasses()
    ->toExtend('Illuminate\Http\Resources\Json\JsonResource');

test('resources must have toArray method')
    ->expect('App\Http\Resources')
    ->toBeClasses()
    ->toHaveMethod('toArray');

test('dtos must be readonly')
    ->expect('App\DataTransferObjects')
    ->toBeClasses()
    ->toBeReadonly();

test('dtos must have dto suffix')
    ->expect('App\DataTransferObjects')
    ->toHaveSuffix('Dto');

test('traits must be actual traits')
    ->expect('App\Traits')
    ->toBeTraits();

test('enums must be actual enums')
    ->expect('App\Enums')
    ->toBeEnums();

test('enums must have enum suffix')
    ->expect('App\Enums')
    ->toHaveSuffix('Enum');

test('contracts must be actual contracts')
    ->expect('App\Contracts')
    ->toBeInterfaces();

test('contracts must have interface suffix')
    ->expect('App\Contracts')
    ->toHaveSuffix('Interface');

test('exceptions must implement custom exception interface')
    ->expect('App\Exceptions')
    ->toBeClasses()
    ->toImplement('App\Contracts\Exceptions\CustomExceptionInterface');

test('exceptions must have exception suffix')
    ->expect('App\Exceptions')
    ->toHaveSuffix('Exception');

test('actions must have handle method')
    ->expect('App\Actions')
    ->toBeClasses()
    ->toHaveMethod('handle');

test('actions must have action suffix')
    ->expect('App\Actions')
    ->toHaveSuffix('Action');

test('services must not depend on models directly')
    ->expect('App\Services')
    ->toBeClasses()
    ->not->toContain('App\Models');

test('notifications must have notification suffix')
    ->expect('App\Notifications')
    ->toHaveSuffix('Notification');

test('notifications must have via, viaConnections, viaQueues methods')
    ->expect('App\Notifications')
    ->toHaveMethods(['via', 'viaConnections', 'viaQueues']);

test('notification channels must have channel suffix')
    ->expect('App\Channels')
    ->toHaveSuffix('Channel');

test('notification channels must have send method')
    ->expect('App\Channels')
    ->toHaveMethod('send');

test('providers must have provider suffix')
    ->expect('App\Providers')
    ->toHaveSuffix('Provider');

test('listeners must have listener suffix')
    ->expect('App\Listeners')
    ->toHaveSuffix('Listener');

test('listeners must have handle method')
    ->expect('App\Listeners')
    ->toHaveMethod('handle');

test('commands must have handle method')
    ->expect('App\Console\Commands')
    ->toHaveMethod('handle');

test('commands must have command suffix')
    ->expect('App\Commands')
    ->toHaveSuffix('Command');

test('jobs must have handle method')
    ->expect('App\Jobs')
    ->toHaveMethod('handle');

test('scopes must have scope suffix')
    ->expect('App\Models\Scopes')
    ->toHaveSuffix('Scope');

test('scopes must have apply method')
    ->expect('App\Models\Scopes')
    ->toHaveMethod('apply');

test('states must have state suffix')
    ->expect('App\Models\States')
    ->toHaveSuffix('State');

test('helpers must have helper suffix')
    ->expect('App\Support\Helpers')
    ->toHaveSuffix('Helper');

test('rules must implement validation rule')
    ->expect('App\Rules')
    ->toBeClasses()
    ->toImplement('Illuminate\Contracts\Validation\ValidationRule');

test('rules must have validate method')
    ->expect('App\Rules')
    ->toHaveMethod('validate');
