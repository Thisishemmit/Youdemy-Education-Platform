<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="assets/js/tailwind.js"></script>
    <!-- inter font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">

    <style>
        #mid-header:hover #arrow {
            transition: 0.3s;
            top: -4px;
            left: 4px;
        }

        #get-started:hover button:last-child {
            transform: translateX(3px) translateY(3px);
        }

        #get-started:active button:last-child {
            background: #14F3B1;
        }
    </style>
</head>

<body class="w-full">
    <div class="flex flex-col min-h-screen font-[Inter]">
        <header class="w-full flex justify-between items-center p-4 px-20">
            <div class="flex items-center">
                <img src="/assets/images/logoBig.jpg" alt="logo" class=" h-10">
            </div>
            <div class="flex items-center">
                <a href="/courses" class="flex items-center" id="mid-header">
                    <i data-lucide="book-text" class="h-5 text-[#252525] relative left-1 top-0.5"></i>
                    <span class="text-[#252525] ml-2 font-bold text-xl underline">our courses</span>
                    <i data-lucide="arrow-up-right" class="h-6 text-[#252525] relative translate-y-0.5" id="arrow"></i>
                </a>
            </div>
            <div class="flex items-center relative z-20" id="get-started">
                <button class="absolute translate-x-1 -z-10 translate-y-1 bg-[#252525] text-[#252525] px-6 py-2 border-2 border-[#252525] font-semibold text-lg rounded-3xl">Get Started</button>
                <button onclick="goto('/login')" class="bg-[#1fda92] text-[#252525] px-6 py-2 border-2 border-[#252525] font-black text-lg rounded-3xl">Get Started</button>
            </div>
        </header>
        <main class="w-full h-full">
            <div class="h-96 flex w-full items-center">
                <div class="h-full w-full flex flex-col justify-center">
                    <h1 class="text-7xl font-bold text-[#252525] px-20">Learn from <br> the best</h1>
                    <p class="text-[#252525] text-lg px-20">Discover the best courses on the internet and get the best learning experience, with the best teachers and the best materials</p>
                </div>
                <div class="h-full w-full flex justify-center items-center">
                    <img src="/assets/images/landing.jpg" alt="landing" class="h-96">
                </div>
            </div>

            <div class="py-12 bg-gray-100">
                <div class="max-w-7xl mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-6">Features</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-6 bg-white rounded shadow">
                            <h3 class="text-xl font-semibold mb-2">Interactive Learning</h3>
                            <p>Engaging tools & interactive content to make learning fun.</p>
                        </div>
                        <div class="p-6 bg-white rounded shadow">
                            <h3 class="text-xl font-semibold mb-2">Expert Instructors</h3>
                            <p>Learn from teachers with deep expertise in their fields.</p>
                        </div>
                        <div class="p-6 bg-white rounded shadow">
                            <h3 class="text-xl font-semibold mb-2">Flexible Schedule</h3>
                            <p>Access courses any time, anywhere with ease.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-6">Popular Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Example course card -->
                        <div class="border p-4 rounded">
                            <h3 class="text-xl font-semibold">Course Title</h3>
                            <p class="text-sm">Short description...</p>
                            <button class="mt-2 bg-[#1fda92] px-4 py-2 rounded">View Course</button>
                        </div>
                        <!-- ...add more cards as needed... -->
                    </div>
                </div>
            </div>

            <div class="py-12 bg-gray-100">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <h2 class="text-3xl font-bold mb-6">What Our Students Say</h2>
                    <p class="max-w-2xl mx-auto mb-6">"This platform has transformed my learning experience!"</p>
                    <p class="max-w-2xl mx-auto">"The courses and teachers are top-notch. Highly recommended."</p>
                </div>
            </div>
        </main>
        <footer class="bg-[#252525] text-white py-6 mt-6">
            <div class="max-w-7xl mx-auto px-4 flex justify-between">
                <div>
                    <h3 class="font-bold text-xl">Youdemy</h3>
                    <p>&copy; <?= date('Y') ?> Youdemy. All rights reserved.</p>
                </div>
                <div>
                    <!-- ...any social links or quick nav... -->
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
