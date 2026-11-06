<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use MongoDB\Client;
use MongoDB\BSON\ObjectId;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'sometimes|required|string|min:3',
            'email' => [
                'sometimes',
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    // --- Cek email unik pada pengguna lain ---
                    $id = $this->route('id');

                    $client = new Client(env('MONGODB_URI'));
                    $db = $client->selectDatabase(env('MONGODB_DATABASE'));
                    $collection = $db->selectCollection('users');

                    $exists = $collection->findOne([
                        'email' => $value,
                        '_id'   => ['$ne' => new ObjectId($id)]
                    ]);

                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                }
            ]
        ];
    }
}
