<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISQM - Quality Management System</title>
            <style>
        :root {
            --brand-blue: #0f172a;
            --brand-blue-dark: #020617;
            --brand-blue-light: #1e293b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1e293b;
        }
        .hero {
            background: linear-gradient(135deg, var(--brand-blue) 0%, var(--brand-blue-dark) 100%);
            color: white;
            padding: 140px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 70% 50%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            opacity: 1;
        }
        .hero-content {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 28px;
            letter-spacing: -0.03em;
            line-height: 1.1;
            color: white;
        }
        .hero p {
            font-size: 1.35rem;
            margin-bottom: 40px;
            opacity: 0.95;
            line-height: 1.8;
            font-weight: 400;
        }
        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-primary {
            background: white;
            color: var(--brand-blue);
            padding: 16px 40px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-block;
            transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
            letter-spacing: 0.3px;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            background: #f8fafc;
        }
        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.8);
            padding: 16px 40px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-block;
            transition: all 0.2s;
            backdrop-filter: blur(10px);
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.15);
            border-color: white;
            transform: translateY(-2px);
        }
        .features {
            padding: 100px 20px;
            max-width: 1200px;
            margin: 0 auto;
            background: #f8fafc;
        }
        .features h2 {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 70px;
            color: #1e293b;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }
        .feature-card {
            padding: 40px;
            background: white;
            border-radius: 16px;
            border-top: 4px solid #3b82f6;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.12);
        }
        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 24px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 12px;
            color: #1e293b;
        }
        .feature-card p {
            color: #64748b;
            line-height: 1.7;
        }
        footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 60px 20px 30px;
            margin-top: 80px;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-section h4 {
            color: white;
            margin-bottom: 16px;
            font-size: 1.1rem;
        }
        .footer-section ul {
            list-style: none;
        }
        .footer-section ul li {
            margin-bottom: 8px;
        }
        .footer-section a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-section a:hover {
            color: white;
        }
        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 30px;
            border-top: 1px solid #1e293b;
            text-align: center;
            color: #64748b;
        }
        nav {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 16px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--brand-blue);
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            gap: 24px;
            align-items: center;
        }
        .nav-links a {
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
            position: relative;
            font-size: 0.95rem;
        }
        .nav-links a:hover {
            color: var(--brand-blue);
        }
        .nav-links a.active {
            color: #3b82f6;
        }
        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            right: 0;
            height: 2px;
            background: #3b82f6;
        }
        .nav-links .btn-nav {
            background: var(--brand-blue);
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            transition: background 0.2s, transform 0.1s;
        }
        .nav-links .btn-nav:hover {
            background: var(--brand-blue-dark);
            transform: translateY(-1px);
            color: white;
        }
        nav {
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .hero p { font-size: 1.1rem; }
            .features-grid { grid-template-columns: 1fr; }
            .nav-content { flex-direction: column; gap: 16px; }
            .nav-links { flex-wrap: wrap; justify-content: center; }
        }
            </style>
    </head>
<body>
    <nav>
        <div class="nav-content">
            <a href="{{ route('home') }}" class="logo">ISQM</a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="active">Home</a>
                <a href="{{ route('pages.features') }}">Features</a>
                <a href="{{ route('pages.about') }}">About</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-nav">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>ISQM Quality Management System</h1>
            <p>Professional quality management for top-tier organizations. Manage your ISQM register with precision, track risks, monitor compliance, and ensure excellence across all engagements.</p>
            <div class="cta-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary">Go to Dashboard</a>
                    <a href="{{ route('pages.features') }}" class="btn-secondary">Learn More</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">Sign In</a>
                    <a href="{{ route('pages.features') }}" class="btn-secondary">View Features</a>
                @endauth
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <h2>Powerful Features</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <h3>ISQM Register</h3>
                <p>Complete ISQM register management with support for all six areas: Governance, Ethical Requirements, Acceptance & Continuance, Engagement Performance, Resources, and Information & Communication.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚠️</div>
                <h3>Risk Assessment</h3>
                <p>Comprehensive risk tracking with likelihood assessment, adverse effect analysis, and risk applicability evaluation. Track severe and pervasive risks systematically.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>Monitoring & Findings</h3>
                <p>Document findings, identify root causes, and track remedial actions. Integrated monitoring activities and deficiency type classification.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Analytics & Reports</h3>
                <p>Generate comprehensive reports, track entries by area, status, and risk level. Export data for analysis and compliance reporting.</p>
            </div>
        </div>
        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('pages.features') }}" class="btn-primary" style="display: inline-block;">View All Features →</a>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>ISQM System</h4>
                <p style="color: #94a3b8; line-height: 1.7;">
                    Professional quality management system designed for accounting firms and professional services organizations to manage ISQM compliance effectively.
                </p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('pages.features') }}">Features</a></li>
                    <li><a href="{{ route('pages.about') }}">About</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Resources</h4>
                <ul>
                    <li><a href="#">{{-- Documentation --}}Documentation</a></li>
                    <li><a href="#">{{-- Support --}}Support</a></li>
                    <li><a href="#">{{-- Contact --}}Contact</a></li>
                </ul>
            </div>
            @auth
            <div class="footer-section">
                <h4>Account</h4>
                <ul>
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('settings.edit') }}">Settings</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                </ul>
            </div>
            @endauth
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} ISQM Quality Management System. All rights reserved.</p>
        </div>
    </footer>
    </body>
</html>
