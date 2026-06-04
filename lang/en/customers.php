<?php

return [
    // Field labels (replaces :attribute with friendly name)
    'attributes' => [
        'company_name'       => 'company name',
        'company_reg_number' => 'company registration number',
        'vat_number'         => 'VAT number',
        'first_name'         => 'first name',
        'last_name'          => 'last name',
        'email'              => 'email address',
        'phone'              => 'phone number',
        'street_address'     => 'street address',
        'suburb'             => 'suburb',
        'city'               => 'city',
        'province'           => 'province',
        'postal_code'        => 'postal code',
        'status'             => 'status',
    ],

    // Custom validation messages
    'messages' => [
        'first_name_required' => 'We need the customer\'s first name.',
        'last_name_required'  => 'We need the customer\'s last name.',
        'email_required'      => 'An email address is required for this customer.',
        'email_email'         => 'Please enter a valid email address (e.g., name@example.com).',
        'email_unique'        => 'A customer with this email already exists in your organization.',
        'province_in'         => 'Please select a valid province.',
        'status_in'           => 'Status must be either active or inactive.',
    ],
];