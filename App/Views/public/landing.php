<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Learn from the best</title>
    <script src="assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">

    <style>
        #get-started:hover button:last-child {
            transform: translateX(3px) translateY(3px);
        }

        .feature-card:hover {
            transform: translateX(-2px) translateY(-2px);
        }
    </style>
</head>

<body class="w-full font-[Inter]">
    <div class="flex flex-col min-h-screen">
        <header class="w-full flex justify-between items-center p-4 px-20 bg-white shadow-sm">
            <div class="flex items-center">
                <img src="/assets/images/logoBig.jpg" alt="Youdemy" class="h-10">
            </div>
            <a href="/courses" class="text-[#252525] hover:text-[#1fda92] font-semibold">Browse Courses</a>
            <div class="flex items-center relative z-20" id="get-started">
                <button class="absolute translate-x-1 -z-10 translate-y-1 bg-[#252525] text-[#252525] px-6 py-2 border-2 border-[#252525] font-semibold text-lg rounded-3xl">Get Started</button>
                <button onclick="goto('/login')" class="bg-[#1fda92] text-[#252525] px-6 py-2 border-2 border-[#252525] font-black text-lg rounded-3xl">Get Started</button>
            </div>
        </header>

        <main class="flex-grow">
            <div class="relative bg-gray-50 overflow-hidden">
                <div class="max-w-7xl mx-auto py-16 px-4">
                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h1 class="text-6xl font-bold text-[#252525] mb-6">
                                Learn from <br>the best minds
                            </h1>
                            <p class="text-xl text-gray-600 mb-8 max-w-lg">
                                Discover courses taught by industry experts and enhance your skills with practical knowledge.
                            </p>
                            <div class="relative z-10 inline-block">
                                <button class="absolute translate-x-1 -z-10 translate-y-1 bg-[#252525] text-[#252525] px-8 py-3 border-2 border-[#252525] font-semibold text-lg rounded-xl">
                                    Explore Courses
                                </button>
                                <a href="/courses"
                                    class="inline-block bg-[#1fda92] text-[#252525] px-8 py-3 border-2 border-[#252525] font-bold text-lg rounded-xl hover:translate-x-1 hover:translate-y-1 transition-transform">
                                    Explore Courses
                                </a>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                            <img src="/assets/images/landing.jpg" alt="Students learning"
                                class="relative z-10 w-full rounded-xl border-2 border-[#252525]">
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4">
                    <h2 class="text-4xl font-bold text-center text-[#252525] mb-16">Why Choose Youdemy?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="feature-card relative z-10">
                            <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                            <div class="relative bg-white p-8 rounded-xl border-2 border-[#252525] transition-transform duration-200">
                                <div class="h-12 w-12 bg-[#1fda92] rounded-lg flex items-center justify-center mb-6">
                                    <i data-lucide="book-open" class="text-white"></i>
                                </div>
                                <h3 class="text-2xl font-semibold mb-4">Interactive Learning</h3>
                                <p class="text-gray-600">Engaging tools & interactive content to make learning fun.</p>
                            </div>
                        </div>
                        <div class="feature-card relative z-10">
                            <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                            <div class="relative bg-white p-8 rounded-xl border-2 border-[#252525] transition-transform duration-200">
                                <div class="h-12 w-12 bg-[#1fda92] rounded-lg flex items-center justify-center mb-6">
                                    <i data-lucide="user-check" class="text-white"></i>
                                </div>
                                <h3 class="text-2xl font-semibold mb-4">Expert Instructors</h3>
                                <p class="text-gray-600">Learn from teachers with deep expertise in their fields.</p>
                            </div>
                        </div>
                        <div class="feature-card relative z-10">
                            <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                            <div class="relative bg-white p-8 rounded-xl border-2 border-[#252525] transition-transform duration-200">
                                <div class="h-12 w-12 bg-[#1fda92] rounded-lg flex items-center justify-center mb-6">
                                    <i data-lucide="clock" class="text-white"></i>
                                </div>
                                <h3 class="text-2xl font-semibold mb-4">Flexible Schedule</h3>
                                <p class="text-gray-600">Access courses any time, anywhere with ease.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="bg-[#252525] text-white py-6 mt-6">
                <div class="max-w-7xl mx-auto px-4 flex justify-between">
                    <div>
                        <h3 class="font-bold text-xl">Youdemy</h3>
                        <p>&copy; <?= date('Y') ?> Youdemy. All rights reserved.</p>
                    </div>
                    <div>
                    </div>
                </div>
            </footer>
            <script src="https://unpkg.com/lucide@latest"></script>
            <script>
                lucide.createIcons();

                function goto(url) {
                    window.location.href = url;
                }
            </script>
    </div>
</body>

</html>