<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getAllCustomers()
    {
        return $this->customer->all();
    }

    public function findCustomerById($id)
    {
        return $this->customer->find($id);
    }

    public function createCustomer(array $data)
    {
        return $this->customer->create($data);
    }

    public function updateCustomer($id, array $data)
    {
        $customer = $this->customer->find($id);
        if ($customer) {
            return $customer->update($data);
        }
        return false;
    }

    public function deleteCustomer($id)
    {
        $customer = $this->customer->find($id);
        if ($customer) {
            return $customer->delete();
        }
        return false;
    }
}
