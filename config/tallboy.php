<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Icon sets
    |---------------------------------------------------------------------------
    |
    | This allows configuration of the icon sets used in Tallboy components.
    | Tallboy ships with 'tallboicon' but you can also install 'heroicon'
    | or 'feathericon' blade-icon packages and Tallboy will pick them.
    |
    */
    'icons' => [
        // Force a specific icon set: 'tallboicon', 'heroicon', 'feathericon'
        'set' => null,
        // You can override specific icons here, including using your own custom icons.
        'replace' => [
            # Notification icons
            //'alert' => 'feathericon-alert-triangle',
            //'info' => 'feathericon-info',
            //'error' => 'feathericon-alert-octogon',
            //'help' => 'feathericon-help-circle',
            //'success' => 'feathericon-check-circle',

            # Dropdown and modal icons
            //'dropdown' => 'feathericon-chevron-down',
            //'menu' => 'feathericon-menu',
            //'close' => 'feathericon-x',

            # Filter icons
            //'filter' => 'feathericon-filter',
            //'sort' => 'feathericon-bar-chart',
            //'unsorted' => 'feathericon-bar-chart-2',
            //'next' => 'feathericon-chevrons-right',
            //'previous' => 'feathericon-chevrons-left',
            //'reset' => 'feathericon-rotate-ccw',
            //'refresh' => 'feathericon-refresh-cw',

            # Loading icons
            //'loading' => 'feathericon-loader',
            //'upload' => 'feathericon-upload',
            //'download' => 'feathericon-download',

            # Form icons
            //'edit' => 'feathericon-edit',
            //'delete' => 'feathericon-trash-2',
            //'cancel' => 'feathericon-slash',
            //'save' => 'feathericon-save',
            //'add' => 'feathericon-plus-square',
            //'remove' => 'feathericon-minus-circle',
            //'mask' => 'feathericon-eye-off',
            //'unmask' => 'feathericon-eye',
            //'copy' => 'feathericon-clipboard',

            # Misc icons
            //'dark' => 'feathericon-moon',
            //'light' => 'feathericon-sun',
            //'system' => 'feathericon-monitor',
        ]
    ],
];
