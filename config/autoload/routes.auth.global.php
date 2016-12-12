<?php
/**
 * Authentication routes: username check, register, login, logout
 */
return [
    'routes' => [
        [
            'name' => 'auth-register-form',
            'path' => '/register',
            'middleware' => Tv\App\Middleware\StaticView::class,
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'auth::register',
                ],
            ],
        ],
        [
            'name' => 'auth-register',
            'path' => '/register',
            'middleware' => [
                Tv\App\Middleware\ValidateCsrf::class,
                Tv\Auth\Middleware\VerifyCaptcha::class,
                Tv\App\Middleware\CqrsPayloadFromPost::class,
                Tv\App\Middleware\ValidateCqrsPayload::class,
                Tv\App\Middleware\GenerateNewUuid::class,
                Tv\Auth\Middleware\HashPasswordInput::class,
                Tv\App\Middleware\DispatchCqrsRequest::class,
                Tv\Auth\Middleware\Authenticate::class,
                Tv\App\Middleware\Redirect::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'defaults' => [
                    'input_validator' => Tv\Auth\Validator\RegisterUser::class,
                    'cqrs_target' => Tv\Auth\Command\RegisterUser::class,
                    'new_uuid_field' => 'userId',
                    'redirect_route' => 'channel/list',
                    'cqrs_ignore_fields' => 'password',
                ],
            ],
        ],
        [
            'name' => 'auth-username-available',
            'path' => '/register/check',
            'middleware' => [
                Tv\App\Middleware\CqrsPayloadFromQuery::class,
                Tv\App\Middleware\DispatchCqrsRequest::class,
                Tv\App\Middleware\ReturnJsonResponse::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'cqrs_target' => Tv\Auth\Query\UsernameAvailable::class
                ],
            ],
        ],
        [
            'name' => 'auth-login-form',
            'path' => '/login',
            'middleware' => Tv\App\Middleware\StaticView::class,
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'auth::login',
                ],
            ],
        ],
        [
            'name' => 'auth-login',
            'path' => '/login',
            'middleware' => [
                Tv\App\Middleware\ValidateCsrf::class,
                Tv\Auth\Middleware\Authenticate::class,
                Tv\App\Middleware\Redirect::class,
            ],
            'options' => [
                'defaults' => [
                    'redirect_route' => 'channel/list',
                ],
            ],
            'allowed_methods' => ['POST'],
        ],
        [
            'name' => 'auth-logout-page',
            'path' => '/logout',
            'middleware' => [
                Tv\Auth\Middleware\AssertIsAuthenticated::class,
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'auth::logout',
                ],
            ],
        ],
        [
            'name' => 'auth-logout',
            'path' => '/logout',
            'middleware' => [
                Tv\Auth\Middleware\AssertIsAuthenticated::class,
                Tv\App\Middleware\ValidateCsrf::class,
                Tv\Auth\Middleware\Deauthenticate::class,
                Tv\App\Middleware\Redirect::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'defaults' => [
                    'redirect_route' => 'channel/list',
                ],
            ],
        ],
        [
            'name' => 'auth-change-password-form',
            'path' => '/change-password',
            'middleware' => [
                Tv\Auth\Middleware\AssertIsAuthenticated::class,
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'auth::change-password',
                ],
            ],
        ],
        [
            'name' => 'auth-change-password',
            'path' => '/change-password',
            'middleware' => [
                Tv\Auth\Middleware\AssertIsAuthenticated::class,
                Tv\App\Middleware\ValidateCsrf::class,
                Tv\App\Middleware\CqrsPayloadFromPost::class,
                Tv\App\Middleware\ValidateCqrsPayload::class,
                Tv\Auth\Middleware\PopulateCurrentUserId::class,
                Tv\Auth\Middleware\HashPasswordInput::class,
                Tv\Auth\Middleware\Authenticate::class,
                Tv\App\Middleware\DispatchCqrsRequest::class,
                Tv\App\Middleware\Redirect::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'defaults' => [
                    'input_validator' => Tv\Auth\Validator\ChangePassword::class,
                    'cqrs_target' => Tv\Auth\Command\ChangePassword::class,
                    'cqrs_ignore_fields' => 'password',
                    'password_field' => 'newPassword',
                    'password_hash_field' => 'newPasswordHash',
                    'redirect_route' => 'channel/list',
                ],
            ],
        ],
    ],
];
