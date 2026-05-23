<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CYDC - Christian Youth Development Center</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        .nav-links a:hover {
            opacity: 0.8;
        }
        
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        
        .btn-outline {
            color: white;
            border-color: white;
        }
        
        .btn-outline:hover {
            background: white;
            color: #2563eb;
        }
        
        .btn-solid {
            background: white;
            color: #2563eb;
        }
        
        .btn-solid:hover {
            background: #f8fafc;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 120px 0 80px;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .cta-button {
            display: inline-block;
            background: white;
            color: #2563eb;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: transform 0.3s;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
        }
        
        /* Ministry Mission Section */
        .ministry-mission {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }
        
        .mission-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .mission-header {
            text-align: left;
        }
        
        .mission-header h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1e293b;
            line-height: 1.2;
        }
        
        .mission-header .subtitle {
            font-size: 1.2rem;
            color: #2563eb;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .mission-header .description {
            font-size: 1.1rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .mission-cta {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .mission-cta:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }
        
        .mission-text {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .mission-text p {
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            color: #4a5568;
            text-align: justify;
        }
        
        .mission-text p:last-child {
            margin-bottom: 0;
        }
        
        .mission-image {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300"><rect width="400" height="300" fill="%23e2e8f0"/><text x="200" y="150" text-anchor="middle" fill="%232563eb" font-size="16" font-family="Arial">Ministry Image</text></svg>') center/cover;
            height: 400px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        /* Services Section */
        .services {
            padding: 80px 0;
            background: #f8fafc;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 3rem;
            color: #1e293b;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .service-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
        }
        
        .service-card h3 {
            color: #2563eb;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        /* About Section */
        .about {
            padding: 80px 0;
        }
        
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .about-text h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #1e293b;
        }
        
        .about-text p {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: #64748b;
        }
        
        .about-image {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            height: 400px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        /* Contact Section */
        .contact {
            padding: 80px 0;
            background: #f8fafc;
        }
        
        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }
        
        .contact-info h3 {
            color: #2563eb;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .contact-item {
            margin-bottom: 1.5rem;
        }
        
        .contact-item strong {
            color: #1e293b;
        }
        
        /* Footer */
        .footer {
            background: #1e293b;
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            color: #2563eb;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .footer-section h4 {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        
        .footer-section p {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.5rem;
        }
        
        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: #2563eb;
        }
        
        .contact-details .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            color: #94a3b8;
        }
        
        .contact-details .contact-item i {
            margin-right: 0.75rem;
            color: #2563eb;
            width: 16px;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #2563eb;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .social-link:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }
        
        .footer-bottom {
            border-top: 1px solid #334155;
            padding-top: 1.5rem;
        }
        
        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .footer-bottom-links {
            display: flex;
            gap: 1.5rem;
        }
        
        .footer-bottom-links a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .footer-bottom-links a:hover {
            color: #2563eb;
        }
        text-align: center;
        padding: 2rem 0;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .nav-links {
            display: none;
        }
        
        .hero h1 {
            font-size: 2rem;
        }
        
        .mission-content,
        .about-content,
        .contact-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .mission-header h2 {
            font-size: 2.2rem;
        }
        
        .mission-header .description {
            margin-bottom: 1.5rem;
        }
        
        .mission-text h2 {
            font-size: 2rem;
        }
        
        .auth-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="container">
            <div class="logo">CYDC</div>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#mission">Mission</a>
                <a href="#about">About</a>
                <a href="#services">Services</a>
                <a href="#contact">Contact</a>
            </div>
            <div class="auth-buttons">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-solid">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-solid">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <h1>Cydc Activities Database</h1>
            <p>Empowering young minds through faith, education, and community service</p>
            <a href="#mission" class="cta-button">Learn More</a>
        </div>
    </section>

    <!-- Ministry Mission Statement Section -->
    <section id="mission" class="ministry-mission">
        <div class="container">
            <div class="mission-content">
                <div class="mission-header">
                    <h2>Ministry Mission Statement</h2>
                    <div class="subtitle">Releasing Children from Poverty in Jesus' Name</div>
                    <div class="description">
                        Our mission is rooted in love and compassion, dedicated to transforming the lives of children in poverty through faith-based programs and community support.
                    </div>
                    <a href="#services" class="mission-cta">Learn About Our Programs</a>
                </div>
                <div class="mission-text">
                    <p>Inspiring children from poverty in Jesus' name is a mission about love. We love God and we demonstrate our love and care for children by helping them reach the fullest of their potential.</p>
                    <p>Compassion means "suffering with" and is consistent empathy with an active response. Because we are compassionate, we will not rest while children live in poverty. We offer our programs to the poorest of the poor so the children in our care can experience the fullness of life that Jesus Christ came to bring.</p>
                    <p>We provide hope and support without imposing any religious obligation or requirement upon them, ensuring every child feels valued and loved.</p>
                </div>
            </div>
        </div>
    </section>


  

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>CYDC</h3>
                    <p>Compassion in Jesus' name - Releasing children from poverty through our comprehensive programs and community initiatives.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        
                        
                        <li><a href="{{ route('register') }}">Register</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>P O BOX 3064, Arusha</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>0763 385 679 (Enock Kawira)</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@cydcactivitiesdb.or.tz</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom text-center">
                <div class="footer-bottom-content">
                    <p>&copy; 2025 CYDC. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Smooth Scrolling Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
