<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Your Mental Health Companion</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-bg {
            background-color: #F0F7F4; /* A soft, calming mint green */
        }
        .feature-icon {
            width: 64px;
            height: 64px;
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    <!-- Header Section -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="text-2xl font-bold text-teal-600">MindWell</a>
            
            <!-- Navigation Links for larger screens -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#features" class="text-gray-600 hover:text-teal-600 transition duration-300">Features</a>
                <a href="#testimonials" class="text-gray-600 hover:text-teal-600 transition duration-300">Testimonials</a>
                <a href="#about" class="text-gray-600 hover:text-teal-600 transition duration-300">About</a>
            </div>

            <!-- Login and Sign Up Buttons -->
            <div class="flex items-center space-x-4">
                <a href="login.php" class="text-gray-600 hover:text-teal-700 font-medium transition duration-300">Login</a>
                <a href="signup.php" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition duration-300 shadow">Sign Up</a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero-bg">
            <div class="container mx-auto px-6 py-20 md:py-32 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-800 leading-tight mb-4">Your Safe Space for Mental Wellness</h1>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-8">Find support, connect with professionals, and discover resources to help you on your journey to a healthier mind.</p>
                <a href="signup.php" class="bg-teal-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-teal-700 transition duration-300 shadow-lg">Get Started for Free</a>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-4">Everything You Need to Thrive</h2>
                <p class="text-gray-600 text-center max-w-2xl mx-auto mb-12">Our platform is designed with your well-being in mind, offering a comprehensive set of tools and support systems.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                    <!-- Feature 1: Professional Help -->
                    <div class="text-center p-6 bg-gray-50 rounded-lg shadow-sm">
                        <div class="flex justify-center mb-4">
                            <!-- SVG Icon -->
                            <svg class="feature-icon text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Connect with Professionals</h3>
                        <p class="text-gray-600">Securely message and have video calls with licensed therapists and counselors from the comfort of your home.</p>
                    </div>
                    <!-- Feature 2: Community Support -->
                    <div class="text-center p-6 bg-gray-50 rounded-lg shadow-sm">
                        <div class="flex justify-center mb-4">
                             <!-- SVG Icon -->
                            <svg class="feature-icon text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962a3.75 3.75 0 015.968 0 3.75 3.75 0 01-5.968 0zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Community Support</h3>
                        <p class="text-gray-600">Join anonymous support groups and forums to share your experiences and connect with others who understand.</p>
                    </div>
                    <!-- Feature 3: Resources -->
                    <div class="text-center p-6 bg-gray-50 rounded-lg shadow-sm">
                        <div class="flex justify-center mb-4">
                             <!-- SVG Icon -->
                            <svg class="feature-icon text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.185 0 4.236.64 6 1.742m6-16.242a8.967 8.967 0 01-6 2.292c-1.052 0-2.062-.18-3-.512v14.25A8.987 8.987 0 0018 18c-2.185 0-4.236-.64-6-1.742m6-16.242v16.242" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Guided Resources</h3>
                        <p class="text-gray-600">Access a library of guided meditations, journaling prompts, mood trackers, and educational articles.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Testimonials Section -->
        <section id="testimonials" class="py-20 hero-bg">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-12">What Our Users Say</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-600 mb-4">"MindWell has been a game-changer for me. The community is so supportive, and I've finally found a therapist who really gets me."</p>
                        <p class="font-semibold text-teal-700">- Labiba.</p>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-600 mb-4">"I love the daily mood tracker and journaling prompts. It's helped me become so much more self-aware. Highly recommend this app."</p>
                        <p class="font-semibold text-teal-700">- Nusrat.</p>
                    </div>
                    <!-- Testimonial 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-600 mb-4">"As someone with a busy schedule, the ability to connect with a counselor online has been incredibly convenient and effective."</p>
                        <p class="font-semibold text-teal-700">- Moon.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer id="about" class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <!-- About MindWell -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">MindWell</h4>
                    <p class="text-gray-400">Our mission is to make mental health support accessible, affordable, and stigma-free for everyone, everywhere.</p>
                </div>
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul>
                        <li><a href="#features" class="hover:text-teal-400 transition duration-300">Features</a></li>
                        <li><a href="signup.php" class="hover:text-teal-400 transition duration-300">Sign Up</a></li>
                        <li><a href="login.php" class="hover:text-teal-400 transition duration-300">Login</a></li>
                    </ul>
                </div>
                <!-- Legal -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Legal</h4>
                    <ul>
                        <li><a href="#" class="hover:text-teal-400 transition duration-300">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition duration-300">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-500">
                <p>&copy; <?php echo date("Y"); ?> MindWell. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
