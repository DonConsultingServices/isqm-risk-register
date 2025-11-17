<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - ISQM Quality Management System</title>
    <style>
        :root {
            --brand-blue: #0f172a;
            --brand-blue-dark: #020617;
            --brand-blue-light: #1e293b;
            --accent-blue: #3b82f6;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.7;
            color: #1e293b;
            background: #f8fafc;
        }
        nav {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--brand-blue);
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }
        .nav-links a {
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
            position: relative;
        }
        .nav-links a:hover {
            color: var(--brand-blue);
        }
        .nav-links a.active {
            color: var(--accent-blue);
        }
        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent-blue);
        }
        .btn-nav {
            background: var(--brand-blue);
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-nav:hover {
            background: var(--brand-blue-dark);
            transform: translateY(-1px);
            color: white;
        }
        .hero-section {
            background: linear-gradient(135deg, var(--brand-blue) 0%, var(--brand-blue-dark) 100%);
            color: white;
            padding: 100px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
        }
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
        }
        .hero-section p {
            font-size: 1.25rem;
            opacity: 0.95;
            line-height: 1.8;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px;
        }
        .section {
            margin-bottom: 80px;
        }
        .section h2 {
            font-size: 2.5rem;
            color: #1e293b;
            margin-bottom: 24px;
            font-weight: 700;
        }
        .section h3 {
            font-size: 1.75rem;
            color: #1e293b;
            margin-bottom: 16px;
            margin-top: 32px;
            font-weight: 600;
        }
        .section p {
            color: #64748b;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 16px;
        }
        .card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            margin-bottom: 32px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .card h3 {
            color: var(--brand-blue);
            margin-top: 0;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 32px;
            margin-top: 40px;
        }
        .feature-item {
            padding: 24px;
            background: white;
            border-radius: 12px;
            border-left: 4px solid var(--accent-blue);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .feature-item h4 {
            color: #1e293b;
            margin-bottom: 12px;
            font-size: 1.25rem;
        }
        .feature-item p {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        .btn-primary {
            background: var(--brand-blue);
            color: white;
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-primary:hover {
            background: var(--brand-blue-dark);
            transform: translateY(-2px);
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
        @media (max-width: 768px) {
            .hero-section h1 { font-size: 2.5rem; }
            .hero-section p { font-size: 1.1rem; }
            .nav-content { flex-direction: column; gap: 16px; }
            .nav-links { flex-wrap: wrap; justify-content: center; gap: 16px; }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-content">
            <a href="{{ route('home') }}" class="logo">ISQM</a>
            <div class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('pages.features') }}">Features</a>
                <a href="{{ route('pages.about') }}" class="active">About</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-nav">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-content">
            <h1>About ISQM</h1>
            <p>Professional quality management system designed for accounting firms and professional services organizations</p>
        </div>
    </section>

    <div class="container">
        <section class="section">
            <div class="card">
                <h2>Our Mission</h2>
                <p>ISQM Quality Management System is designed to help accounting firms and professional services organizations manage their International Standard on Quality Management (ISQM) compliance effectively. Our platform provides a comprehensive solution for tracking quality objectives, assessing risks, monitoring activities, and ensuring compliance across all six ISQM areas.</p>
            </div>
        </section>

        <section class="section">
            <h2>What is ISQM?</h2>
            <div class="card">
                <p>ISQM (International Standard on Quality Management) is a comprehensive framework that requires firms to establish and maintain a system of quality management for their audits or reviews of financial statements, or other assurance or related services engagements.</p>
                <p>The standard is built around eight quality objectives that firms must achieve through their system of quality management. These objectives cover:</p>
                <div class="grid" style="margin-top: 32px;">
                    <div class="feature-item">
                        <h4>Governance & Leadership</h4>
                        <p>Establishing a culture of quality and ensuring leadership commitment to quality management.</p>
                    </div>
                    <div class="feature-item">
                        <h4>Ethical Requirements</h4>
                        <p>Maintaining independence and ethical standards throughout all engagements.</p>
                    </div>
                    <div class="feature-item">
                        <h4>Acceptance & Continuance</h4>
                        <p>Making appropriate judgments about client relationships and engagements.</p>
                    </div>
                    <div class="feature-item">
                        <h4>Engagement Performance</h4>
                        <p>Ensuring engagements are performed in accordance with professional standards.</p>
                    </div>
                    <div class="feature-item">
                        <h4>Resources</h4>
                        <p>Obtaining, developing, using, and maintaining resources necessary for quality engagements.</p>
                    </div>
                    <div class="feature-item">
                        <h4>Information & Communication</h4>
                        <p>Ensuring relevant and reliable information flows throughout the organization.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <h2>Why Choose Our System?</h2>
            <div class="grid">
                <div class="feature-item">
                    <h4>Comprehensive Coverage</h4>
                    <p>Our system covers all six ISQM areas, ensuring complete compliance management.</p>
                </div>
                <div class="feature-item">
                    <h4>Risk-Based Approach</h4>
                    <p>Identify and assess quality risks systematically, with built-in tools for risk evaluation.</p>
                </div>
                <div class="feature-item">
                    <h4>Automated Monitoring</h4>
                    <p>Track monitoring activities, findings, and remedial actions with automated notifications.</p>
                </div>
                <div class="feature-item">
                    <h4>Client Management</h4>
                    <p>Associate quality requirements with clients and track engagement-level compliance.</p>
                </div>
                <div class="feature-item">
                    <h4>Reporting & Analytics</h4>
                    <p>Generate comprehensive reports and export data for analysis and compliance documentation.</p>
                </div>
                <div class="feature-item">
                    <h4>User-Friendly Interface</h4>
                    <p>Intuitive design makes it easy for teams to adopt and use the system effectively.</p>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card" style="text-align: center; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);">
                <h2 style="color: var(--brand-blue);">Get Started Today</h2>
                <p style="font-size: 1.1rem; margin-bottom: 32px;">Start managing your ISQM compliance effectively with our comprehensive quality management system.</p>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">Sign In</a>
                @endauth
            </div>
        </section>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>ISQM System</h4>
                <p style="color: #94a3b8; line-height: 1.7;">
                    Professional quality management system for ISQM compliance.
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
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} ISQM Quality Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
