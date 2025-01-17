<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Account Pending - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full">
    <div class="flex flex-col min-h-screen font-[Inter]">
        <header class="w-full flex justify-between items-center p-4 px-20">
            <div class="flex items-center">
                <img src="/assets/images/logoBig.jpg" alt="logo" class="h-10">
            </div>
            <div class="flex items-center relative z-20" id="get-started">
                <a href="/logout" class="bg-[#1fda92] text-[#252525] px-6 py-2 border-2 border-[#252525] font-black text-lg rounded-3xl">Logout</a>
            </div>
        </header>

        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-[#1fda92] p-6">
                    <h1 class="text-[#252525] text-2xl font-bold text-center">Account Pending Approval</h1>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto text-[#1fda92]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="mt-4 text-2xl font-bold text-[#252525]">Thank You for Registering!</h2>
                        <p class="mt-2 text-gray-600">Your teacher account is currently pending administrative approval.</p>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-[#252525] mb-3">What happens next?</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 mr-2 text-[#1fda92]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Our admin team will review your application
                            </li>
                            <li class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 mr-2 text-[#1fda92]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                You'll receive an email when your account is approved
                            </li>
                            <li class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 mr-2 text-[#1fda92]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Once approved, you can start creating courses
                            </li>
                        </ul>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="font-semibold text-[#252525] mb-2">Prepare Your Courses</h4>
                            <p class="text-gray-600 text-sm">Start planning your course content and materials while you wait</p>
                        </div>
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="font-semibold text-[#252525] mb-2">Review Guidelines</h4>
                            <p class="text-gray-600 text-sm">Familiarize yourself with our teaching standards and best practices</p>
                        </div>
                    </div>

                    <div class="text-center border-t pt-6">
                        <p class="text-gray-600 mb-4">Need help? Contact our support team at support@youdemy.com</p>
                        <div class="space-x-4">
                            <a href="/" class="inline-block bg-[#252525] text-white px-6 py-2 rounded-3xl font-semibold hover:bg-opacity-90">Return to Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>