<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StandaloneCoders - Telecaller SaaS Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-sm shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">SC</span>
                    </div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">StandaloneCoders</h1>
                </div>
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-medium">Get Started</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 text-white py-20 overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400/30 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-400/30 rounded-full blur-3xl animate-float" style="animation-delay: -3s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in-up">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    Complete <span class="text-yellow-300">Telecaller</span><br>
                    SaaS Platform
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto">
                    4-Level RBAC Dashboard with Mobile API Integration, Advanced Analytics, and Multi-tenant Architecture
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transform hover:scale-105 transition-all duration-200 shadow-xl">
                        🚀 Start Free Trial
                    </a>
                    <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-all duration-200">
                        📖 Learn More
                    </a>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="text-3xl font-bold text-yellow-300">10K+</div>
                    <div class="text-blue-100">Active Users</div>
                </div>
                <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="text-3xl font-bold text-yellow-300">500+</div>
                    <div class="text-blue-100">Companies</div>
                </div>
                <div class="animate-fade-in-up" style="animation-delay: 0.6s;">
                    <div class="text-3xl font-bold text-yellow-300">1M+</div>
                    <div class="text-blue-100">Calls Logged</div>
                </div>
                <div class="animate-fade-in-up" style="animation-delay: 0.8s;">
                    <div class="text-3xl font-bold text-yellow-300">99.9%</div>
                    <div class="text-blue-100">Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Everything you need to manage your telecalling operations with enterprise-grade security and scalability</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group bg-gradient-to-br from-blue-50 to-indigo-100 p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition-transform duration-300">🏢</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">4-Level RBAC System</h3>
                    <p class="text-gray-600 mb-4">Super Admin → Admin → Manager → Agent hierarchy with granular permissions and role-based access control</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Multi-tenant architecture</li>
                        <li>• Company-based isolation</li>
                        <li>• Granular permissions</li>
                    </ul>
                </div>
                
                <div class="group bg-gradient-to-br from-purple-50 to-pink-100 p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition-transform duration-300">📱</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Mobile API Integration</h3>
                    <p class="text-gray-600 mb-4">Complete REST API for Android/iOS apps with device management and real-time synchronization</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Device binding & control</li>
                        <li>• Real-time sync</li>
                        <li>• JWT authentication</li>
                    </ul>
                </div>
                
                <div class="group bg-gradient-to-br from-green-50 to-emerald-100 p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition-transform duration-300">📊</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Advanced Analytics</h3>
                    <p class="text-gray-600 mb-4">Role-based dashboards with comprehensive reporting, insights, and performance metrics</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Real-time dashboards</li>
                        <li>• Custom reports</li>
                        <li>• Performance tracking</li>
                    </ul>
                </div>
                
                <div class="group bg-gradient-to-br from-yellow-50 to-orange-100 p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition-transform duration-300">🔒</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Enterprise Security</h3>
                    <p class="text-gray-600 mb-4">Advanced security features with audit logging, IP whitelisting, and data encryption</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• End-to-end encryption</li>
                        <li>• Audit trails</li>
                        <li>• IP restrictions</li>
                    </ul>
                </div>
                
                <div class="group bg-gradient-to-br from-red-50 to-pink-100 p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition-transform duration-300">⚡</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">High Performance</h3>
                    <p class="text-gray-600 mb-4">Optimized for scale with Redis caching, queue processing, and CDN integration</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Redis caching</li>
                        <li>• Queue processing</li>
                        <li>• CDN integration</li>
                    </ul>
                </div>
                
                <div class="group bg-gradient-to-br from-indigo-50 to-blue-100 p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-5xl mb-4 group-hover:scale-110 transition-transform duration-300">🛠️</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Easy Integration</h3>
                    <p class="text-gray-600 mb-4">RESTful APIs, webhooks, and third-party integrations for seamless workflow automation</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• RESTful APIs</li>
                        <li>• Webhook support</li>
                        <li>• Third-party integrations</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Simple Pricing</h2>
                <p class="text-xl text-gray-600">Choose the perfect plan for your business needs</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Starter</h3>
                        <div class="text-5xl font-bold text-blue-600 mb-4">₹2,499<span class="text-lg text-gray-500">/month</span></div>
                        <p class="text-gray-600 mb-6">Perfect for small teams getting started</p>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">5 Users</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">1,000 Leads</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Basic Dashboard</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Email Support</span>
                        </div>
                    </div>

                    <a href="{{ route('register') }}" class="w-full bg-blue-600 text-white py-3 px-4 rounded-full hover:bg-blue-700 font-semibold transform hover:scale-105 transition-all duration-200 block text-center">Get Started</a>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-2xl border-4 border-blue-600 transform scale-105 relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm font-semibold">Most Popular</span>
                    </div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Professional</h3>
                        <div class="text-5xl font-bold text-blue-600 mb-4">₹6,699<span class="text-lg text-gray-500">/month</span></div>
                        <p class="text-gray-600 mb-6">Ideal for growing businesses</p>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">25 Users</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">10,000 Leads</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Advanced Analytics</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Priority Support</span>
                        </div>
                    </div>

                    <a href="{{ route('register') }}" class="w-full bg-blue-600 text-white py-3 px-4 rounded-full hover:bg-blue-700 font-semibold transform hover:scale-105 transition-all duration-200 block text-center">Get Started</a>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Enterprise</h3>
                        <div class="text-5xl font-bold text-blue-600 mb-4">₹16,699<span class="text-lg text-gray-500">/month</span></div>
                        <p class="text-gray-600 mb-6">For large organizations</p>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">100 Users</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">50,000 Leads</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Custom Integrations</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Dedicated Support</span>
                        </div>
                    </div>

                    <a href="{{ route('register') }}" class="w-full bg-blue-600 text-white py-3 px-4 rounded-full hover:bg-blue-700 font-semibold transform hover:scale-105 transition-all duration-200 block text-center">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Built with Modern Tech</h2>
                <p class="text-xl text-gray-600">Powered by industry-leading technologies for maximum performance and reliability</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center">
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-red-600">L</span>
                    </div>
                    <p class="text-gray-600 font-medium">Laravel 11</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-blue-600">PHP</span>
                    </div>
                    <p class="text-gray-600 font-medium">PHP 8.2+</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-blue-600">MySQL</span>
                    </div>
                    <p class="text-gray-600 font-medium">MySQL 8.0</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-cyan-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-cyan-600">TW</span>
                    </div>
                    <p class="text-gray-600 font-medium">Tailwind CSS</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-red-600">R</span>
                    </div>
                    <p class="text-gray-600 font-medium">Redis</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl font-bold text-blue-600">🐳</span>
                    </div>
                    <p class="text-gray-600 font-medium">Docker</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
                <p class="text-xl text-gray-600">The talented developers behind StandaloneCoders</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold group-hover:scale-110 transition-transform duration-300 shadow-xl">YS</div>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mx-auto w-32 h-32 opacity-20 group-hover:opacity-40 transition-opacity duration-300 blur-xl"></div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Yogendra Singh</h3>
                    <p class="text-blue-600 font-medium mb-2">Lead Developer & Founder</p>
                    <p class="text-gray-500 text-sm">Full-stack developer with expertise in Laravel, React, and cloud architecture</p>
                </div>
                
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold group-hover:scale-110 transition-transform duration-300 shadow-xl">GR</div>
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full mx-auto w-32 h-32 opacity-20 group-hover:opacity-40 transition-opacity duration-300 blur-xl"></div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Govind Raajpoot</h3>
                    <p class="text-purple-600 font-medium mb-2">Backend Developer</p>
                    <p class="text-gray-500 text-sm">Backend specialist focused on API development, database optimization, and security</p>
                </div>
                
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 bg-gradient-to-r from-green-600 to-emerald-600 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold group-hover:scale-110 transition-transform duration-300 shadow-xl">SJ</div>
                        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-600 rounded-full mx-auto w-32 h-32 opacity-20 group-hover:opacity-40 transition-opacity duration-300 blur-xl"></div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Sparsh Jain</h3>
                    <p class="text-green-600 font-medium mb-2">Frontend Developer</p>
                    <p class="text-gray-500 text-sm">UI/UX expert specializing in modern frontend frameworks and responsive design</p>
                </div>
                
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 bg-gradient-to-r from-red-600 to-orange-600 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold group-hover:scale-110 transition-transform duration-300 shadow-xl">PM</div>
                        <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-orange-600 rounded-full mx-auto w-32 h-32 opacity-20 group-hover:opacity-40 transition-opacity duration-300 blur-xl"></div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pranay Mukherjee</h3>
                    <p class="text-red-600 font-medium mb-2">Full Stack Developer</p>
                    <p class="text-gray-500 text-sm">Versatile developer with expertise in both frontend and backend technologies</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to Transform Your Business?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">Join thousands of companies already using our platform to streamline their telecalling operations and boost productivity</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transform hover:scale-105 transition-all duration-200 shadow-xl">
                    🚀 Start Your Free Trial
                </a>
                <a href="mailto:contact@standalonecoders.com" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-all duration-200">
                    💬 Contact Sales
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">SC</span>
                        </div>
                        <h3 class="text-2xl font-bold">StandaloneCoders</h3>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">Building digital empires that scale. We create enterprise-grade SaaS solutions that transform businesses and drive growth.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <span class="text-sm font-bold">GH</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <span class="text-sm font-bold">LI</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <span class="text-sm font-bold">TW</span>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API Docs</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Integrations</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#team" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">&copy; 2024 StandaloneCoders. All rights reserved.</p>
                <div class="flex space-x-6 text-gray-400">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>