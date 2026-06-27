<?php

namespace App\Modules\Settings\Services;

use App\Models\OrganizationBankAccount;
use App\Models\User;

class BankAccountService
{
    public function get(User $user): ?OrganizationBankAccount
    {
        return OrganizationBankAccount::where('organization_id', $user->organization_id)->first();
    }

    public function save(User $user, array $data): OrganizationBankAccount
    {
        return OrganizationBankAccount::updateOrCreate(
            ['organization_id' => $user->organization_id],
            $data,
        );
    }
}