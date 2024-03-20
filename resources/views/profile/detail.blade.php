@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Informasi Pengguna</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $user->email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Peran</label>
                            <input type="text" name="role" id="role" class="form-control"
                                value="{{ $user->is_admin ? 'Admin' : 'Anggota' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Ubah Kata Sandi</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('edit_profile') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi Baru</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Ubah Detail Profil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
