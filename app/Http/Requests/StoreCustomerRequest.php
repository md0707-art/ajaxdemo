<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Set to true for now; implement authorization if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $customerId = $this->route('id'); // get customer ID from route (works for update)

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customerId,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'gender' => 'nullable|in:male,female,other'
        ];
    }


    /**
     * Custom messages (optional)
     */
    public function messages()
    {
        return [
            'name.required' => 'Customer name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid',
            'email.unique' => 'Email already exists',
        ];
    }
}
