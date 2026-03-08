@extends('admin.layouts.app')
@section('title', 'Admin Profile')

@section('content')
@php
    $avatarUrl = !empty($user->avatar) ? asset('storage/' . $user->avatar) : asset('img/default-avatar.jpg');
@endphp

<div class="py-3 vd-page">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="vd-card">
                <div class="vd-card-header">
                    <strong>Profile Information</strong>
                </div>
                <div class="vd-card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Profile Picture</label>
                            <div class="d-flex align-items-center gap-3">
                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="Admin Avatar"
                                    style="width:76px;height:76px;border-radius:14px;object-fit:cover;border:1px solid rgba(148,163,184,.35);"
                                >
                                <input
                                    type="file"
                                    name="avatar"
                                    class="form-control vd-input @error('avatar') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp,image/*"
                                >
                            </div>
                            @error('avatar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control vd-input @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control vd-input @error('phone') is-invalid @enderror">
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control vd-input @error('address') is-invalid @enderror">
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn vd-btn vd-btn-primary" type="submit">Save Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="vd-card">
                <div class="vd-card-header">
                    <strong>Change Password</strong>
                </div>
                <div class="vd-card-body">
                    <form method="POST" action="{{ route('admin.profile.password') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control vd-input @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control vd-input @error('new_password') is-invalid @enderror" required>
                            @error('new_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control vd-input" required>
                        </div>

                        <div class="small text-muted mb-3">
                            Password must be at least 8 characters with uppercase, number, and special character.
                        </div>

                        <button class="btn vd-btn vd-btn-primary" type="submit">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
