<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Create Customer</h2>

    <div id="alert-success" class="alert alert-success d-none"></div>
    <div id="alert-error" class="alert alert-danger d-none"></div>

    <form id="customerForm">
        @csrf
        <div class="mb-3"><label>Name *</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3"><label>Email *</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3"><label>Phone *</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3"><label>Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>
        <div class="mb-3"><label>City</label>
            <input type="text" name="city" class="form-control">
        </div>
        <div class="mb-3"><label>State</label>
            <input type="text" name="state" class="form-control">
        </div>
        <div class="mb-3"><label>Zip</label>
            <input type="text" name="zip" class="form-control">
        </div>
        <div class="mb-3"><label>Country</label>
            <input type="text" name="country" class="form-control">
        </div>
        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control">
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
$(document).ready(function() {
    $.ajaxSetup({ 
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } 
    });

    $('#customerForm').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('customers.store') }}",
            type: "POST",
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success'){
                    // Redirect to customer list page after successful creation
                    window.location.href = "{{ route('customers.index') }}";
                }
            },
            error: function(xhr) {
                let errorHtml = '';
                if(xhr.status === 422) { // validation errors
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value){
                        errorHtml += value[0] + '<br>';
                    });
                } else {
                    errorHtml = 'Something went wrong! Check console.';
                    console.log('XHR:', xhr);
                }

                $('#alert-error').removeClass('d-none').html(errorHtml);
                $('#alert-success').addClass('d-none');
            }
        });
    });
});
</script>
</body>
</html>
