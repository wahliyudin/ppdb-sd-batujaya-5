@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Profile</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" required name="name" class="form-control"
                                value="{{ auth()->user()->name }}">
                            <span class="text-danger text-sm" id="name-error"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" required name="email" class="form-control"
                                value="{{ auth()->user()->email }}">
                            <span class="text-danger text-sm" id="email-error"></span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary float-right" id="btn-profile-update">simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Password</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="password" required name="password" class="form-control" placeholder="password">
                            <span class="text-danger text-sm" id="password-error"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" required name="new_password" class="form-control"
                                placeholder="new password">
                            <span class="text-danger text-sm" id="new_password-error"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" required name="password_confirmation" class="form-control"
                                placeholder="confirm password">
                            <span class="text-danger text-sm" id="password_confirmation-error"></span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary float-right" id="btn-password-update">simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inc.toastr')
@push('script')
    <script>
        var ajaxError = function(jqXHR, xhr, textStatus, errorThrow, exception) {
            if (jqXHR.status === 0) {
                toastr.error('Not connect.\n Verify Network.', 'Error!');
                resetBtn()
            } else if (jqXHR.status == 400) {
                toastr.warning(jqXHR['responseJSON'].message, 'Peringatan!');
                resetBtn()
            } else if (jqXHR.status == 404) {
                toastr.error('Requested page not found. [404]', 'Error!');
                resetBtn()
            } else if (jqXHR.status == 500) {
                toastr.error('Internal Server Error [500].' + jqXHR['responseJSON'].message, 'Error!');
                resetBtn()
            } else if (exception === 'parsererror') {
                toastr.error('Requested JSON parse failed.', 'Error!');
                resetBtn()
            } else if (exception === 'timeout') {
                toastr.error('Time out error.', 'Error!');
                resetBtn()
            } else if (exception === 'abort') {
                toastr.error('Ajax request aborted.', 'Error!');

            } else {
                if (typeof jqXHR.responseJSON.errors !== 'undefined') {
                    $('#name-error').text(check(jqXHR.responseJSON.errors.name));
                    $('#email-error').text(check(jqXHR.responseJSON.errors.email));
                    $('#password-error').text(check(jqXHR.responseJSON.errors.password));
                    $('#new_password-error').text(check(jqXHR.responseJSON.errors.new_password));
                    $('#password_confirmation-error').text(check(jqXHR.responseJSON.errors.password_confirmation));
                } else {
                    toastr.error('Uncaught Error.\n' + jqXHR.responseText, 'Error!');
                }
                resetBtn()
            }
        };

        function check(field) {
            return typeof field !== 'undefined' ? field : null;
        }

        function resetBtn() {
            $("#btn-profile-update").html('simpan');
            $("#btn-profile-update").attr("disabled", false);
            $("#btn-password-update").html('simpan');
            $("#btn-password-update").attr("disabled", false);
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('click', '#btn-profile-update', function(event) {
            var id = '{{ auth()->user()->id }}';
            var name = $("input[name='name']").val();
            var email = $("input[name='email']").val();
            $("#btn-profile-update").html('Please Wait...');
            $("#btn-profile-update").attr("disabled", true);

            // ajax
            $.ajax({
                type: "PUT",
                url: "{{ route('api.profiles.update-profile') }}",
                data: {
                    id: id,
                    name: name,
                    email: email
                },
                dataType: 'json',
                success: function(res) {
                    toastr.success(res.message, 'Berhasil!');
                    resetBtn()
                    location.reload();
                },
                error: ajaxError,
            });
        });

        $('body').on('click', '#btn-password-update', function(event) {
            var id = '{{ auth()->user()->id }}';
            var password = $("input[name='password']").val();
            var new_password = $("input[name='new_password']").val();
            var password_confirmation = $("input[name='password_confirmation']").val();
            $("#btn-password-update").html('Please Wait...');
            $("#btn-password-update").attr("disabled", true);

            // ajax
            $.ajax({
                type: "PUT",
                url: "{{ route('api.profiles.update-password') }}",
                data: {
                    id: id,
                    password: password,
                    new_password: new_password,
                    password_confirmation: password_confirmation,
                },
                dataType: 'json',
                success: function(res) {
                    $("input[name='password']").val('');
                    $("input[name='new_password']").val('');
                    $("input[name='password_confirmation']").val('');
                    location.reload();
                    toastr.success(res.message, 'Berhasil!');
                    resetBtn()
                },
                error: ajaxError,
            });
        });
    </script>
@endpush
