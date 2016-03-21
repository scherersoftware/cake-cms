# cake-cms

[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)

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

## Using Page Attributes

It is possible to define arbitrary page attributes to save additional data for a CMS page without having to modify the CMS schema. Data will be saved as JSON in the `cms_pages.page_attributes` field.

The CMS will look in the `Pages.attributes` path of your CMS configuration. Configuration looks like this:

    'Pages' => [
        'attributes' => [
            'public' => [
                'type' => 'boolean',
                'label' => 'Publicly Available',
                'default' => true
            ],
            'keywords' => [
                'type' => 'text',
                'label' => 'Keywords',
                'default' => ''
            ]
        ]
    ]

Based on this configuration, input fields will be rendered in a separate "Attributes" tab in the edit screen. Attributes can later be fetched using eiher `CmsPage::getAttributes()` or `CmsPage::getAttribute($attribute)`.

Example:

        $this->loadComponent('Cms.Cms', [
            'permissionsCallback' => function (CmsPage $page) use ($controller) {
                return $page->getAttribute('public');
            }
        ]);
