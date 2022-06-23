<?php

namespace Packages\Reserved\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Packages\Reserved\App\Models\Customer;

class UserDocumentsController extends Controller
{
    public function download(Customer $customer, $identifier)
    {
        $this->authorize('view', $customer);

        if(array_key_exists($identifier, $customer->profile_data) && Storage::disk('form_uploads')->exists($customer->profile_data[$identifier]))
        {
            return Storage::disk('form_uploads')->download($customer->profile_data[$identifier]);
        }

        return redirect()->back();
    }
}
