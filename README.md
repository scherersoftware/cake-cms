# cake-cms

Block-based Content Management System for CakePHP 3

## Installation

Load the plugin in your `config/bootstrap.php`

    Plugin::load('Cms', ['bootstrap' => true, 'routes' => true]);

Add the Dispatcher Filter for CMS Widget assets to the corresponding section in your `config/bootstrap.php`

    DispatcherFactory::add('Cms.WidgetAsset');

Add tables via Migrations Plugin

    bin/cake migrations migrate --plugin Cms

Add configuration to your `config/app.php`

    'Cms' => [
        'Administration' => [
            'layout' => 'Admin.default', // Layout to use for the CMS admin area
            'helpers' => [
                'CkTools.Menu' // Helpers to load in the CMS admin area
            ]
        ]
    ]

Configure a route for the frontend rendering of CMS pages (use this example and adapt to your requirements)

    $routes->connect('/:slug', Configure::read('Cms.Frontend.renderAction'), ['routeClass' => 'Cms.SlugRoute']);

