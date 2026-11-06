<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use MongoDB\Client;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|min:3',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    // --- Cek email unik di MongoDB ---
                    $client = new Client(env('MONGODB_URI'));
                    $db = $client->selectDatabase(env('MONGODB_DATABASE'));
                    $collection = $db->selectCollection('users');

                    $exists = $collection->findOne(['email' => $value]);

                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                }
            ]
        ];
    }
}
