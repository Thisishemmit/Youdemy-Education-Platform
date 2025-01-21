<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full font-[Inter] bg-gray-50">
    <div class="flex">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#252525]">Welcome back, <?= htmlspecialchars($student->getUserName()) ?>!</h1>
                <p class="text-gray-600 mt-1">Here's an overview of your learning progress</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Courses -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl border-2 border-[#252525] p-6 relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Enrolled Courses</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= count($courses) ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="book-open" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Courses -->
                <?php
                $completedCount = 0;
                foreach ($courses as $course) {
                    if ($student->isCompleted($course->getId())) $completedCount++;
                }
                ?>
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl border-2 border-[#252525] p-6 relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Completed</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= $completedCount ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="check-circle" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl border-2 border-[#252525] p-6 relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">In Progress</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= count($courses) - $completedCount ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="trending-up" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Courses -->
            <div class="relative z-10">
                <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                <div class="bg-white rounded-xl border-2 border-[#252525] p-6 relative">
                    <h2 class="text-xl font-bold text-[#252525] mb-4">Recently Enrolled Courses</h2>

                    <?php if (empty($courses)): ?>
                        <div class="text-center py-8">
                            <i data-lucide="book" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                            <p class="text-gray-500">You haven't enrolled in any courses yet.</p>
                            <a href="/courses" class="text-[#1fda92] font-medium hover:underline mt-2 inline-block">Browse Courses</a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php
                            $recentCourses = array_slice($courses, 0, 3); // Show only 3 most recent
                            foreach ($recentCourses as $course):
                            ?>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-lg bg-[#1fda92] flex items-center justify-center text-[#252525]">
                                            <i data-lucide="book-open" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-[#252525]"><?= htmlspecialchars($course->getTitle()) ?></h3>
                                            <p class="text-sm text-gray-500">
                                                <?= $student->isCompleted($course->getId()) ? 'Completed' : 'In Progress' ?>
                                            </p>
                                        </div>
                                    </div>
                                    <a href="/student/courses/<?= $course->getId() ?>"
                                        class="text-[#1fda92] hover:text-[#14F3B1]">
                                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>

                            <?php if (count($courses) > 3): ?>
                                <a href="/student/courses"
                                    class="block text-center text-[#1fda92] font-medium hover:underline mt-4">
                                    View all courses
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
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