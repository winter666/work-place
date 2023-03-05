<?php

namespace App\Observers;

use App\Models\WorkspaceImage\Customer;
use Illuminate\Support\Facades\Storage;

class CustomerObserver
{
    public function deleted(Customer $customer)
    {
        if ($customer->profile_image) {
            Storage::disk('public_folder')->delete($customer->profile_image);
        }
    }
}
