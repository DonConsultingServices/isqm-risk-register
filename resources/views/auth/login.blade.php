<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - ISQM Quality Management System</title>
    <style>
        :root { 
            --brand-blue: {{ \App\Models\Setting::get('brand_color', '#0f172a') ?? '#0f172a' }};
            --accent-blue: #3b82f6;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 50%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            padding: 40px 32px;
            width: 100%;
            max-width: 420px;
            position: relative;
            overflow: hidden;
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-blue), #8b5cf6);
        }
        .logo {
            text-align: center;
            margin-bottom: 28px;
        }
        .logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--brand-blue), var(--accent-blue));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 28px;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.2);
        }
        .logo h1 {
            font-size: 1.875rem;
            color: var(--brand-blue);
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }
        .logo p {
            color: #64748b;
            font-size: 0.9rem;
        }
        h2 {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 6px;
            font-weight: 700;
            text-align: center;
        }
        .subtitle {
            color: #64748b;
            margin-bottom: 28px;
            font-size: 0.9rem;
            text-align: center;
        }
        form {
            margin-top: 24px;
        }
        label {
            display: block;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
            font-family: inherit;
            background: #f8fafc;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--accent-blue);
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 0.85rem;
        }
        .form-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            margin: 0;
            cursor: pointer;
            color: #475569;
        }
        .form-options input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--accent-blue);
        }
        .form-options a {
            color: var(--accent-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .form-options a:hover {
            color: var(--brand-blue);
            text-decoration: underline;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--brand-blue), var(--accent-blue));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
            letter-spacing: 0.2px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.3);
        }
        .btn:active {
            transform: translateY(0);
        }
        .error {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border-left: 4px solid #ef4444;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .error::before {
            content: '⚠️';
            font-size: 1.2rem;
        }
        .back-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        .back-link a {
            color: var(--accent-blue);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        .back-link a:hover {
            color: var(--brand-blue);
            text-decoration: underline;
        }
        .nav-link {
            text-align: center;
            margin-top: 16px;
        }
        .nav-link a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-link a:hover {
            color: white;
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            body {
                padding: 12px;
            }
            .login-container {
                padding: 32px 24px;
                border-radius: 16px;
                max-width: 100%;
            }
            .logo {
                margin-bottom: 24px;
            }
            .logo-icon {
                width: 48px;
                height: 48px;
                font-size: 24px;
            }
            .logo h1 {
                font-size: 1.625rem;
            }
            h2 {
                font-size: 1.375rem;
            }
            .subtitle {
                font-size: 0.85rem;
                margin-bottom: 24px;
            }
            form {
                margin-top: 20px;
            }
            .form-group {
                margin-bottom: 18px;
            }
            .form-options {
                margin-bottom: 20px;
                font-size: 0.8rem;
            }
            .btn {
                padding: 12px;
                font-size: 0.95rem;
            }
            .back-link {
                margin-top: 20px;
                padding-top: 16px;
            }
        }
        @media (max-height: 800px) {
            body {
                padding: 12px;
                align-items: flex-start;
                padding-top: 20px;
            }
            .login-container {
                margin-top: auto;
                margin-bottom: auto;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="logo">
                <div class="logo-icon">📊</div>
                <h1>ISQM</h1>
                <p>Quality Management System</p>
            </div>
            <h2>Welcome Back</h2>
            <p class="subtitle">Sign in to continue to your dashboard</p>

            @error('email')
                <div class="error">
                    {{ $message }}
                </div>
            @enderror

            <form method="post" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your.email@example.com">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>

                <div class="form-options">
                    <label>
                        <input type="checkbox" name="remember" value="1">
                        Remember me
                    </label>
                    <a href="#">{{-- Forgot password --}}Forgot password?</a>
                </div>

                <button type="submit" class="btn">Sign In</button>
            </form>

            <div class="back-link">
                <a href="{{ route('home') }}">← Back to Home</a>
            </div>
        </div>
        <div class="nav-link">
            <a href="{{ route('pages.about') }}">About</a> • <a href="{{ route('pages.features') }}">Features</a>
        </div>
    </div>
</body>
</html>
