<?php

/*
|--------------------------------------------------------------------------
| Plan Features & Limits
|--------------------------------------------------------------------------
|
| This file is the single source of truth for what each plan includes.
|
| - "features"  : Marketing copy shown on pricing page / plan cards.
|                 Update these when messaging changes.
|
| - "limits"    : Enforced by PlanGate service in code.
|                 null = unlimited.
|                 false = feature not available on this plan.
|
| Plans are identified by their slug (matches the `slug` column in DB).
| When adding a new plan: add it to DB via seeder AND add it here.
|
| Prices live in the DB (needed for billing integrations).
| Feature gates live here (code-level decisions, deployed not queried).
|
| Invoicing limits exist in feature but not limits cause we offer unlimitd invoicing
| 
|
*/

return [

    'free' => [

        'features' => [
            'Single User Access',
            'Unlimited invoices',
            '5 Maximum Customers',
            'Email support',
        ],

        'limits' => [
            'users'              => 1,
            'customers'          => 5,
        ],

    ],

    'pro' => [

        'features' => [
            'Single User Access',
            'Unlimited invoices',
            '50 Maximum Customers',
            'Priority email support',
        ],

        'limits' => [
            'users'              => 1,
            'customers'          => 50,
        ],

    ],

    'enterprise' => [

        'features' => [
            'Multi User Access',
            'Unlimited invoices',
            'Unlimited Customers',
            'Dedicated support',
        ],

        'limits' => [
            'users'              => null,
            'customers'          => null,
        ],

    ],

];