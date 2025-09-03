<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Edit Customer</h2>

    <div id="alert-success" class="alert alert-success d-none"></div>
    <div id="alert-error" class="alert alert-danger d-none"></div>

    <form id="customerForm">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" value="{{ $customer->id }}">

    <div class="mb-3"><label>Name *</label>
        <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
    </div>
    <div class="mb-3"><label>Email *</label>
        <input type="email" name="email" class="form-control" value="{{ $customer->email }}" required>
    </div>
    <div class="mb-3"><label>Phone *</label>
        <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}" required>
    </div>
    <div class="mb-3"><label>Address</label>
        <textarea name="address" class="form-control">{{ $customer->address }}</textarea>
    </div>
    <div class="mb-3"><label>City</label>
        <input type="text" name="city" class="form-control" value="{{ $customer->city }}">
    </div>
    <div class="mb-3"><label>State</label>
        <input type="text" name="state" class="form-control" value="{{ $customer->state }}">
    </div>
    <div class="mb-3"><label>Zip</label>
        <input type="text" name="zip" class="form-control" value="{{ $customer->zip }}">
    </div>
    <div class="mb-3"><label>Country</label>
        <input type="text" name="country" class="form-control" value="{{ $customer->country }}">
    </div>
    <div class="mb-3">
        <label>Gender</label>
        <select name="gender" class="form-control">
            <option value="">Select</option>
            <option value="male" {{ $customer->gender=='male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ $customer->gender=='female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ $customer->gender=='other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
</form>

<script>
$(document).ready(function() {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $('#customerForm').submit(function(e) {
        e.preventDefault();

        let customerId = $('input[name="id"]').val();
        let formData = $(this).serialize();

        $.ajax({
            url: '/customers/' + customerId,
            type: 'PUT',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    alert('Customer updated successfully!');
                    // Optional: redirect to index
                    window.location.href = "{{ route('customers.index') }}";
                } else {
                    alert('Something went wrong!');
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if(errors) {
                    let errorHtml = '';
                    $.each(errors, function(key, value){
                        errorHtml += value[0] + '\n';
                    });
                    alert(errorHtml);
                } else {
                    alert('Update failed! Check console.');
                    console.log(xhr);
                }
            }
        });
    });
});
</script>

</div>
</body>
</html>
