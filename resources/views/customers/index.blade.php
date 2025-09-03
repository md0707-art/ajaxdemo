<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Customers</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-success mb-3">Add Customer</a>

    <div id="alert-success" class="alert alert-success d-none"></div>
    <div id="alert-error" class="alert alert-danger d-none"></div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th>
                <th>City</th><th>State</th><th>Country</th>
                <th>Gender</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr id="customer-{{ $customer->id }}">
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->city }}</td>
                <td>{{ $customer->state }}</td>
                <td>{{ $customer->country }}</td>
                <td>{{ ucfirst($customer->gender) }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-customer" data-id="{{ $customer->id }}">Delete</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No customers found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
$(document).on('click', '.delete-customer', function() {
    if(!confirm('Are you sure?')) return;
    let customerId = $(this).data('id');

    $.ajax({
    url: '/customers/' + customerId,
    type: 'DELETE',
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, // ← Add this
    success: function(response) {
        if(response.status === 'success') {
            $('#alert-success').removeClass('d-none').text(response.message);
            $('#customer-' + customerId).remove();
        } else {
            $('#alert-error').removeClass('d-none').text(response.message);
        }
    },
    error: function(xhr) {
        console.log('XHR:', xhr);
        $('#alert-error').removeClass('d-none').text('Something went wrong.');
    }
});

});
</script>
</body>
</html>
