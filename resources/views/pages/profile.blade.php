@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<style>
/* Villa Diana - Profile (INLINE) */
.vd-card { border-radius: 14px; }
.vd-card-header {
    background: linear-gradient(90deg, rgba(254,161,22,0.18), rgba(15,23,43,0.02));
    border-bottom: 1px solid rgba(15,23,43,0.08);
    padding: 16px 18px;
}
.vd-icon-circle{
    width: 42px; height: 42px; border-radius: 12px;
    display: inline-flex; align-items: center; justify-content: center;
    background: rgba(254,161,22,0.18);
    color: #FEA116;
    font-size: 16px;
}
.vd-icon-circle.vd-danger{
    background: rgba(220,53,69,0.12);
    color: #dc3545;
}
.vd-btn-primary{
    background: #FEA116; border-color: #FEA116; color: #0F172B;
    font-weight: 700; padding: 10px 16px; border-radius: 10px;
    transition: 0.2s ease;
}
.vd-btn-primary:hover{ filter: brightness(0.95); transform: translateY(-1px); }
.vd-eye{ border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
.vd-form .form-control{ border-radius: 10px; padding: 10px 12px; }
.vd-form .input-group .form-control{
    border-top-left-radius: 10px; border-bottom-left-radius: 10px;
}
.vd-danger-zone{
    background: rgba(220,53,69,0.06);
    border: 1px solid rgba(220,53,69,0.18);
    border-radius: 12px;
    padding: 16px;
}

/* Update Profile redesign extras */
.vd-help { font-size: 12px; color: #6B7280; }
.vd-input-icon {
    min-width: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-top-left-radius: 10px !important;
    border-bottom-left-radius: 10px !important;
}
.vd-section-badge{
    font-size: 12px;
    padding: 6px 10px;
    border-radius: 999px;
    background: rgba(254,161,22,0.14);
    color: #0F172B;
    border: 1px solid rgba(254,161,22,0.22);
}
.vd-soft{
    background: rgba(15,23,43,0.02);
    border: 1px solid rgba(15,23,43,0.08);
    border-radius: 12px;
    padding: 12px 14px;
}
.vd-password-rules{
    margin-top: 8px;
    padding: .7rem .85rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: #f8fafc;
}
.vd-password-rule{
    display: flex;
    align-items: center;
    gap: .5rem;
    color: #64748b;
    font-size: .86rem;
    line-height: 1.3;
}
.vd-password-rule + .vd-password-rule{
    margin-top: .3rem;
}
.vd-password-rule i{
    color: #94a3b8;
    font-size: .6rem;
    transition: color .15s ease;
}
.vd-password-rule.is-met{
    color: #166534;
    font-weight: 600;
}
.vd-password-rule.is-met i{
    color: #16a34a;
}
</style>

<div class="row justify-content-center mt-5">
    <div class="col-12 col-sm-8 col-md-7 col-lg-6">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- =======================
            UPDATE PROFILE (REDESIGNED)
        ====================== --}}
        <div class="card shadow-sm border-0 mb-4 vd-card">
            <div class="card-header vd-card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="vd-icon-circle">
                        <i class="fa fa-user"></i>
                    </span>
                    <div>
                        <h5 class="mb-0">Profile Information</h5>
                        <small class="text-muted">Keep your details accurate for bookings and notifications</small>
                    </div>
                </div>

                <span class="vd-section-badge">
                    <i class="fa fa-check-circle me-1"></i> Account
                </span>
            </div>

            <div class="card-body p-4">
                <div class="vd-soft mb-3">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fa fa-info-circle text-muted mt-1"></i>
                        <div>
                            <div class="fw-semibold" style="color:#0F172B;">Quick Tip</div>
                            <div class="vd-help mb-0">Your phone number helps us contact you about your reservation updates.</div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="vd-form">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light vd-input-icon">
                                    <i class="fa fa-id-card text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter your full name"
                                    autocomplete="name"
                                >
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light vd-input-icon">
                                    <i class="fa fa-phone text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="09xxxxxxxxxx"
                                    autocomplete="tel"
                                >
                            </div>
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="vd-help mt-1">Example: 0917xxxxxxx</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light vd-input-icon">
                                    <i class="fa fa-map-marker-alt text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    name="address"
                                    value="{{ old('address', $user->address) }}"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Enter your complete address"
                                    autocomplete="street-address"
                                >
                            </div>
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light vd-input-icon">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                                <input
                                    type="email"
                                    readonly
                                    value="{{ $user->email }}"
                                    class="form-control bg-light"
                                >
                            </div>
                            <div class="vd-help mt-1">Email cannot be changed. Contact support if you need help.</div>
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-2 justify-content-end mt-2">
                            <button type="reset" class="btn btn-light border">
                                <i class="fa fa-undo me-1"></i> Clear
                            </button>

                            <button type="submit" class="btn vd-btn-primary">
                                <i class="fa fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- =======================
            SECURITY SETTINGS (UNCHANGED)
        ====================== --}}
        <div class="card shadow-sm border-0 mt-4 vd-card">
            <div class="card-header vd-card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="vd-icon-circle">
                        <i class="fa fa-shield-alt"></i>
                    </span>
                    <div>
                        <h5 class="mb-0">Security Settings</h5>
                        <small class="text-muted">Update your password to keep your account secure</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('profile.reset-password') }}" class="vd-form">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Current Password</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    placeholder="Enter your current password"
                                    id="current_password"
                                    required
                                >
                                <button class="btn btn-outline-secondary vd-eye" type="button" data-toggle-target="#current_password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">New Password</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror"
                                    placeholder="Enter a new password"
                                    id="new_password"
                                    required
                                >
                                <button class="btn btn-outline-secondary vd-eye" type="button" data-toggle-target="#new_password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror

                            <div class="vd-password-rules" id="profilePasswordRules" aria-live="polite">
                                <div class="vd-password-rule" data-rule="uppercase"><i class="fa-solid fa-circle"></i>One uppercase letter</div>
                                <div class="vd-password-rule" data-rule="special"><i class="fa-solid fa-circle"></i>One special character</div>
                                <div class="vd-password-rule" data-rule="number"><i class="fa-solid fa-circle"></i>One number</div>
                                <div class="vd-password-rule" data-rule="length"><i class="fa-solid fa-circle"></i>At least 8 characters</div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="new_password_confirmation"
                                    class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                    placeholder="Re-type your new password"
                                    id="confirm_password"
                                    required
                                >
                                <button class="btn btn-outline-secondary vd-eye" type="button" data-toggle-target="#confirm_password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            @error('new_password_confirmation')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-2 justify-content-end mt-2">
                            <button type="reset" class="btn btn-light border">
                                <i class="fa fa-undo me-1"></i> Clear
                            </button>

                            <button type="submit" class="btn vd-btn-primary">
                                <i class="fa fa-key me-1"></i> Update Password
                            </button>
                        </div>
                    </div>
                </form>

                <hr class="my-4">

                <div class="vd-danger-zone">
                    <div class="d-flex align-items-start gap-3">
                        <span class="vd-icon-circle vd-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                        </span>

                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold text-danger">Danger Zone</h6>
                            <p class="mb-0 text-muted">
                                Deleting your account is permanent and cannot be undone.
                            </p>
                        </div>

                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="fa fa-trash me-1"></i> Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">
                            <i class="fa fa-trash me-2"></i> Confirm Delete
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-2">Are you sure you want to delete your account?</p>
                        <div class="alert alert-warning mb-0">
                            <strong>Warning:</strong> This action is permanent.
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>

                        <form method="POST" action="{{ route('user.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Yes, Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-toggle-target]');
    if (!btn) return;

    const target = document.querySelector(btn.getAttribute('data-toggle-target'));
    if (!target) return;

    target.type = (target.type === 'password') ? 'text' : 'password';

    const icon = btn.querySelector('i');
    if (icon) {
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
});

const profileNewPasswordInput = document.getElementById('new_password');
const profilePasswordRules = document.getElementById('profilePasswordRules');

if (profileNewPasswordInput && profilePasswordRules) {
    const ruleEls = {
        uppercase: profilePasswordRules.querySelector('[data-rule="uppercase"]'),
        special: profilePasswordRules.querySelector('[data-rule="special"]'),
        number: profilePasswordRules.querySelector('[data-rule="number"]'),
        length: profilePasswordRules.querySelector('[data-rule="length"]')
    };

    const updatePasswordRules = function (value) {
        const checks = {
            uppercase: /[A-Z]/.test(value),
            special: /[@$!%*?&#]/.test(value),
            number: /\d/.test(value),
            length: value.length >= 8
        };

        Object.keys(ruleEls).forEach(function (key) {
            const el = ruleEls[key];
            if (!el) return;
            el.classList.toggle('is-met', checks[key]);
        });
    };

    profileNewPasswordInput.addEventListener('input', function () {
        updatePasswordRules(this.value || '');
    });

    updatePasswordRules(profileNewPasswordInput.value || '');
}
</script>

@include('sections.newsletter')
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
