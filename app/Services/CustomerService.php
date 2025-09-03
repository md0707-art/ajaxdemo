<?php
namespace App\Services;
use App\Repositories\CustomerRepository;
use App\Models\Customer;
class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomers()
    {
        return $this->customerRepository->getAllCustomers();
    }

    public function findCustomerById($id)
    {
        return $this->customerRepository->findCustomerById($id);
    }

    public function createCustomer(array $data)
    {
        return $this->customerRepository->createCustomer($data);
    }

    public function updateCustomer($id, array $data)
    {
        return $this->customerRepository->updateCustomer($id, $data);
    }

    public function deleteCustomer($id)
    {
        return $this->customerRepository->deleteCustomer($id);
    }
    public function getCustomerById($id)
    {
        return Customer::find($id);
    }
}