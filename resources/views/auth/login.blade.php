@extends('layouts.app')

@section('title', 'Auth')
@section('hideNavbar')


@section('content')
    <div class="auth-screen-modern">

        <div class="auth-container-modern">

            {{-- Logo --}}
            <div class="auth-logo-section">
                <div class="logo-wrapper-auth">
                    <i class="fa-brands fa-instagram auth-logo-icon"></i>
                </div>
                <h1 class="auth-brand-name">Instagram</h1>
                <p class="auth-tagline">Share moments with friends</p>
            </div>

            {{-- RADIO TOGGLES (CSS CONTROL) --}}
            <input type="radio" name="authToggle" id="loginToggle" checked hidden>
            <input type="radio" name="authToggle" id="registerToggle" hidden>

            {{-- SLIDING BOX --}}
            <div class="auth-box-modern">

                {{-- LOGIN --}}
                <div class="auth-form-container login-form">
                    <div class="form-header-auth">
                        <h2 class="form-title-auth">Welcome Back</h2>
                        <p class="form-subtitle-auth">Sign in to continue</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="modern-auth-form">
                        @csrf

                        <div class="input-group-modern">
                            <div class="input-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </div>
                            <input type="email" name="email" required class="modern-input" placeholder="Email">
                        </div>

                        <div class="input-group-modern">
                            <div class="input-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>
                            <input type="password" name="password" required class="modern-input" placeholder="Password">
                        </div>

                        <button class="btn-auth-modern btn-primary-auth">
                            <span>Sign In</span>
                        </button>

                        <div class="form-switch-modern">
                            <span>Don't have an account?</span>
                            <label for="registerToggle" class="switch-link-modern">Sign Up</label>
                        </div>
                    </form>
                </div>

                {{-- REGISTER --}}
                <div class="auth-form-container register-form">
                    <div class="form-header-auth">
                        <h2 class="form-title-auth">Create Account</h2>
                        <p class="form-subtitle-auth">Join our community today</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="modern-auth-form">
                        @csrf

                        <div class="input-group-modern">
                            <div class="input-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="7" r="4" />
                                    <path d="M5.5 21c1-4 5-7 10-7s9 3 10 7" />
                                </svg>
                            </div>
                            <input type="text" name="name" required class="modern-input" placeholder="Name">
                        </div>

                        <div class="input-group-modern">
                            <div class="input-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </div>
                            <input type="email" name="email" required class="modern-input" placeholder="Email">
                        </div>

                        <div class="input-group-modern">
                            <div class="input-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>
                            <input type="password" name="password" required class="modern-input" placeholder="Password">
                        </div>

                        <div class="input-group-modern">
                            <div class="input-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" required class="modern-input"
                                placeholder="Confirm Password">
                        </div>

                        <button class="btn-auth-modern btn-primary-auth">
                            <span>Create Account</span>
                        </button>

                        <div class="form-switch-modern">
                            <span>Already have an account?</span>
                            <label for="loginToggle" class="switch-link-modern">Sign In</label>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@endsection
<style>
/* SLIDE CONTROL */
.auth-box-modern {
    display: flex;
    width: 200%;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Default = Login */
#loginToggle:checked~.auth-box-modern {
    transform: translateX(0);
}

/* Register */
#registerToggle:checked~.auth-box-modern {
    transform: translateX(-50%);
}

/* CLICK FIX (MOST IMPORTANT) */
.login-form,
.register-form {
    pointer-events: none;
}

#loginToggle:checked~.auth-box-modern .login-form {
    pointer-events: auto;
}

#registerToggle:checked~.auth-box-modern .register-form {
    pointer-events: auto;
}

.auth-screen-modern::before {
    pointer-events: none;
}

.auth-screen-modern {
    min-height: 100vh;
    background: linear-gradient(135deg, #0a0a0a 0%, #1a0a1a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    position: relative;
    overflow: hidden;
}

.auth-screen-modern::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
    animation: rotate 30s linear infinite;
    pointer-events: none;
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

.auth-container-modern {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 450px;
    margin: 0 auto;
    overflow: hidden;
    animation: fadeInUp 0.6s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Logo Section */
.auth-logo-section {
    text-align: center;
    margin-bottom: 40px;
    animation: fadeIn 0.8s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

.logo-wrapper-auth {
    display: inline-block;
    margin-bottom: 16px;
}

.auth-logo-icon {
    font-size: 72px;
    background: radial-gradient(circle at 30% 30%, #ffdc80, transparent 45%),
        radial-gradient(circle at 70% 30%, #fcaf45, transparent 40%),
        radial-gradient(circle at 30% 70%, #f77737, transparent 40%),
        radial-gradient(circle at 70% 70%, #833ab4, transparent 45%),
        linear-gradient(135deg, #f56040, #833ab4);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    filter: drop-shadow(0 8px 24px rgba(131, 58, 180, 0.5));
    animation: glow 3s ease-in-out infinite;
}

@keyframes glow {

    0%,
    100% {
        filter: drop-shadow(0 8px 24px rgba(131, 58, 180, 0.5));
    }

    50% {
        filter: drop-shadow(0 8px 32px rgba(131, 58, 180, 0.8));
    }
}

.auth-brand-name {
    font-family: 'Great Vibes', cursive;
    font-size: 42px;
    color: #fff;
    margin: 0 0 8px 0;
    text-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
}

.auth-tagline {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.9rem;
    margin: 0;
}

.auth-box-modern {
    display: flex;
    width: 200%;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
}

.auth-form-container {
    width: 50%;
    background: rgba(15, 15, 15, 0.8);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    box-sizing: border-box;
}


.form-header-auth {
    text-align: center;
    margin-bottom: 32px;
}

.form-title-auth {
    color: #fff;
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.form-subtitle-auth {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.9rem;
    margin: 0;
}

/* Form */
.modern-auth-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Input Group */
.input-group-modern {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
    pointer-events: none;
}

.input-icon svg {
    stroke: rgba(255, 255, 255, 0.4);
    stroke-width: 2;
    transition: stroke 0.3s ease;
}

.modern-input {
    width: 100%;
    height: 56px;
    padding: 16px 16px 16px 50px;
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.95rem;
    transition: all 0.3s ease;
    outline: none;
}


.modern-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
    opacity: 1;
}


.modern-input:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(102, 126, 234, 0.6);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.modern-input:focus+.modern-label,
.modern-input:not(:placeholder-shown)+.modern-label {
    opacity: 0;
}

.modern-input:focus~.input-icon svg {
    stroke: #667eea;
}

.modern-label {
    position: absolute;
    left: 50px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, 0.4);
    font-size: 0.95rem;
    pointer-events: none;
    transition: all 0.3s ease;
    opacity: 0;
}

.input-error {
    border-color: rgba(239, 68, 68, 0.6) !important;
}

.input-error:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
}

/* Error Message */
.error-message-modern {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #ef4444;
    font-size: 0.85rem;
    margin-top: -12px;
    padding: 8px 12px;
    background: rgba(239, 68, 68, 0.1);
    border-radius: 8px;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.error-message-modern svg {
    stroke: #ef4444;
    stroke-width: 2;
    flex-shrink: 0;
}

/* Forgot Link */
.forgot-link-wrapper {
    text-align: right;
    margin-top: -8px;
}

.forgot-link-modern {
    color: rgba(102, 126, 234, 0.9);
    font-size: 0.85rem;
    text-decoration: none;
    transition: color 0.2s ease;
}

.forgot-link-modern:hover {
    color: #667eea;
    text-decoration: underline;
}

/* Button */
.btn-auth-modern {
    height: 56px;
    border: none;
    border-radius: 14px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-auth-modern::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.btn-auth-modern:hover::before {
    width: 300px;
    height: 300px;
}

.btn-auth-modern span,
.btn-auth-modern svg {
    position: relative;
    z-index: 1;
}

.btn-primary-auth {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
}

.btn-primary-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(102, 126, 234, 0.6);
}

.btn-primary-auth:active {
    transform: translateY(0);
}

.btn-primary-auth svg {
    stroke: white;
    stroke-width: 2;
}

/* Form Switch */
.form-switch-modern {
    text-align: center;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.9rem;
    margin-top: 8px;
}

.switch-link-modern {
    color: #667eea;
    font-weight: 600;
    text-decoration: none;
    margin-left: 6px;
    transition: color 0.2s ease;
}

.switch-link-modern:hover {
    color: #7c8ef5;
    text-decoration: underline;
}

/* Footer */
.auth-footer-modern {
    text-align: center;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-text-auth {
    color: rgba(255, 255, 255, 0.4);
    font-size: 0.85rem;
    margin: 0;
}

/* Autofill Styles */
.modern-input:-webkit-autofill,
.modern-input:-webkit-autofill:hover,
.modern-input:-webkit-autofill:focus {
    -webkit-text-fill-color: #fff !important;
    -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.05) inset !important;
    box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.05) inset !important;
    border: 2px solid rgba(255, 255, 255, 0.1) !important;
}

/* Responsive */
@media (max-width: 576px) {
    .auth-screen-modern {
        padding: 20px;
    }

    .auth-form-container {
        padding: 30px 24px;
    }

    .form-title-auth {
        font-size: 1.5rem;
    }

    .auth-brand-name {
        font-size: 36px;
    }

    .auth-logo-icon {
        font-size: 60px;
    }

    .modern-input {
        height: 52px;
    }

    .btn-auth-modern {
        height: 52px;
    }
}
</style>
