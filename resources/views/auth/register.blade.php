<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - ISQM</title>
    <style>
        :root { --brand-blue: {{ \App\Models\Setting::get('brand_color', '#0f172a') ?? '#0f172a' }}; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            padding: 48px;
            width: 100%;
            max-width: 480px;
        }
        .logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .logo h1 {
            font-size: 2rem;
            color: var(--brand-blue);
            font-weight: 700;
            margin-bottom: 8px;
        }
        .logo p {
            color: #64748b;
            font-size: 0.95rem;
        }
        h2 {
            font-size: 1.75rem;
            color: #1e293b;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .subtitle {
            color: #64748b;
            margin-bottom: 32px;
            font-size: 0.95rem;
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
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        input:focus {
            outline: none;
            border-color: var(--brand-blue);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: var(--brand-blue);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }
        .btn:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }
        .btn:active {
            transform: translateY(0);
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border-left: 4px solid #ef4444;
        }
        .errors {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .errors ul {
            list-style: none;
            padding-left: 0;
        }
        .errors li {
            margin-bottom: 4px;
        }
        .back-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }
        .back-link a {
            color: var(--brand-blue);
            text-decoration: none;
            font-size: 0.9rem;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .login-link {
            text-align: center;
            margin-top: 16px;
            font-size: 0.9rem;
            color: #64748b;
        }
        .login-link a {
            color: var(--brand-blue);
            text-decoration: none;
            font-weight: 500;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>ISQM</h1>
            <p>Quality Management System</p>
        </div>
        <h2>Create Account</h2>
        <p class="subtitle">Sign up to get started with ISQM</p>

        @if($errors->any())
            <div class="errors">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>

        <div class="back-link">
            <a href="{{ route('home') }}">← Back to Home</a>
        </div>
    </div>
</body>
</html>
