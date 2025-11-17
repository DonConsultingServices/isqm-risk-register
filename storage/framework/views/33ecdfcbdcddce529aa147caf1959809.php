<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Features - ISQM Quality Management System</title>
    <style>
        :root {
            --brand-blue: #0f172a;
            --brand-blue-dark: #020617;
            --brand-blue-light: #1e293b;
            --accent-blue: #3b82f6;
            --accent-purple: #8b5cf6;
            --accent-green: #10b981;
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
            background: radial-gradient(circle at 70% 50%, rgba(59, 130, 246, 0.15) 0%, transparent 50%);
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
            margin-bottom: 40px;
            font-weight: 700;
            text-align: center;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 32px;
        }
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 4px solid var(--accent-blue);
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-blue), var(--accent-purple));
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.12);
        }
        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
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
            margin-bottom: 16px;
            color: #1e293b;
            font-weight: 600;
        }
        .feature-card p {
            color: #64748b;
            line-height: 1.8;
            font-size: 1rem;
        }
        .feature-list {
            list-style: none;
            margin-top: 20px;
        }
        .feature-list li {
            padding: 8px 0;
            color: #64748b;
            position: relative;
            padding-left: 24px;
        }
        .feature-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--accent-green);
            font-weight: bold;
        }
        .cta-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 24px;
            padding: 60px 40px;
            text-align: center;
            margin-top: 60px;
        }
        .cta-section h2 {
            color: var(--brand-blue);
            margin-bottom: 20px;
        }
        .cta-section p {
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 32px;
        }
        .btn-primary {
            background: var(--brand-blue);
            color: white;
            padding: 16px 40px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-block;
            transition: background 0.2s, transform 0.1s;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
        }
        .btn-primary:hover {
            background: var(--brand-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.3);
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
            .features-grid { grid-template-columns: 1fr; }
            .cta-section { padding: 40px 20px; }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-content">
            <a href="<?php echo e(route('home')); ?>" class="logo">ISQM</a>
            <div class="nav-links">
                <a href="<?php echo e(route('home')); ?>">Home</a>
                <a href="<?php echo e(route('pages.features')); ?>" class="active">Features</a>
                <a href="<?php echo e(route('pages.about')); ?>">About</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn-nav">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-nav">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Powerful Features</h1>
            <p>Comprehensive tools to manage your ISQM compliance effectively</p>
        </div>
    </section>

    <div class="container">
        <section class="section">
            <h2>Core Features</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h3>ISQM Register</h3>
                    <p>Complete ISQM register management with support for all six areas:</p>
                    <ul class="feature-list">
                        <li>Governance & Leadership</li>
                        <li>Ethical Requirements</li>
                        <li>Acceptance & Continuance</li>
                        <li>Engagement Performance</li>
                        <li>Resources</li>
                        <li>Information & Communication</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚠️</div>
                    <h3>Risk Assessment</h3>
                    <p>Comprehensive risk tracking and assessment tools:</p>
                    <ul class="feature-list">
                        <li>Likelihood assessment</li>
                        <li>Adverse effect analysis</li>
                        <li>Risk applicability evaluation</li>
                        <li>Severe and pervasive risk tracking</li>
                        <li>Risk response planning</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3>Monitoring & Findings</h3>
                    <p>Document and track monitoring activities and findings:</p>
                    <ul class="feature-list">
                        <li>Monitoring activity tracking</li>
                        <li>Findings documentation</li>
                        <li>Root cause analysis</li>
                        <li>Deficiency type classification</li>
                        <li>Remedial action tracking</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Analytics & Reports</h3>
                    <p>Generate comprehensive reports and analytics:</p>
                    <ul class="feature-list">
                        <li>Status-based reporting</li>
                        <li>Risk level analysis</li>
                        <li>Area-wise summaries</li>
                        <li>Excel export functionality</li>
                        <li>Compliance reports</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Client Management</h3>
                    <p>Associate quality requirements with clients:</p>
                    <ul class="feature-list">
                        <li>Client association</li>
                        <li>Ownership tracking</li>
                        <li>Engagement-level requirements</li>
                        <li>Entity-level tracking</li>
                        <li>Client history</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📎</div>
                    <h3>Document Management</h3>
                    <p>Maintain complete audit trail:</p>
                    <ul class="feature-list">
                        <li>Document attachments</li>
                        <li>Version tracking</li>
                        <li>Audit trail maintenance</li>
                        <li>File organization</li>
                        <li>Secure storage</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📥</div>
                    <h3>Excel Import</h3>
                    <p>Seamlessly import existing data:</p>
                    <ul class="feature-list">
                        <li>Bulk import from Excel</li>
                        <li>Automatic field mapping</li>
                        <li>Data validation</li>
                        <li>Error reporting</li>
                        <li>Import history</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔔</div>
                    <h3>Notifications</h3>
                    <p>Stay informed with automatic notifications:</p>
                    <ul class="feature-list">
                        <li>Overdue item alerts</li>
                        <li>Upcoming review reminders</li>
                        <li>Status change notifications</li>
                        <li>Email notifications</li>
                        <li>In-app notifications</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2>Ready to Get Started?</h2>
            <p>Start managing your ISQM compliance effectively today.</p>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="btn-primary">Go to Dashboard</a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn-primary">Sign In Now</a>
            <?php endif; ?>
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
                    <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li><a href="<?php echo e(route('pages.features')); ?>">Features</a></li>
                    <li><a href="<?php echo e(route('pages.about')); ?>">About</a></li>
                    <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Resources</h4>
                <ul>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo e(date('Y')); ?> ISQM Quality Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/pages/features.blade.php ENDPATH**/ ?>