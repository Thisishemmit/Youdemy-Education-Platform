<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full font-[Inter] bg-gray-50">
    <div class="flex">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#252525]">Admin Dashboard</h1>
                <p class="text-gray-600 mt-1">Platform overview and statistics</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Teachers -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Teachers</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= $totalTeachers ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="users" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Students -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Students</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= $totalStudents ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="graduation-cap" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Courses -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Courses</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= $totalCourses ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="book" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Teachers -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Pending Teachers</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= $pendingTeachers ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="clock" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="/admin/teachers" class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525] hover:bg-gray-50">
                        <h3 class="font-semibold text-[#252525] mb-2">Manage Teachers</h3>
                        <p class="text-sm text-gray-600">View and manage teacher accounts</p>
                    </div>
                </a>

                <a href="/admin/students" class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525] hover:bg-gray-50">
                        <h3 class="font-semibold text-[#252525] mb-2">Manage Students</h3>
                        <p class="text-sm text-gray-600">View and manage student accounts</p>
                    </div>
                </a>

                <a href="/admin/courses" class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525] hover:bg-gray-50">
                        <h3 class="font-semibold text-[#252525] mb-2">Manage Courses</h3>
                        <p class="text-sm text-gray-600">View and manage courses</p>
                    </div>
                </a>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
