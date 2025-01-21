<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Statistics - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full font-[Inter] bg-gray-50">
    <div class="flex">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#252525]">Course Statistics</h1>
                <p class="text-gray-600 mt-1">Overview of your courses' performance</p>
            </div>

            <!-- Overall Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Courses -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Courses</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= $totalCourses ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="book" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Students -->
                <?php
                $totalStudents = 0;
                $totalCompleted = 0;
                foreach ($courseStats as $stat) {
                    $totalStudents += $stat['totalStudents'];
                    $totalCompleted += $stat['completedCount'];
                }
                ?>
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Students</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= $totalStudents ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="users" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Completions -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Completions</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= $totalCompleted ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="check-circle" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Statistics Table -->
            <div class="relative z-10">
                <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                    <h2 class="text-xl font-bold text-[#252525] mb-6">Course Details</h2>
                    
                    <?php if (empty($courseStats)): ?>
                        <div class="text-center py-8">
                            <i data-lucide="bar-chart" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                            <p class="text-gray-500">No course statistics available</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left bg-gray-50">
                                        <th class="p-4 font-semibold text-[#252525]">Course</th>
                                        <th class="p-4 font-semibold text-[#252525]">Total Students</th>
                                        <th class="p-4 font-semibold text-[#252525]">Completed</th>
                                        <th class="p-4 font-semibold text-[#252525]">Completion Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    <?php foreach ($courseStats as $stat): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="p-4">
                                                <div class="font-medium text-[#252525]"><?= htmlspecialchars($stat['course']->getTitle()) ?></div>
                                            </td>
                                            <td class="p-4 text-gray-600"><?= $stat['totalStudents'] ?></td>
                                            <td class="p-4 text-gray-600"><?= $stat['completedCount'] ?></td>
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                                        <div class="bg-[#1fda92] h-2.5 rounded-full" style="width: <?= $stat['completionRate'] ?>%"></div>
                                                    </div>
                                                    <span class="text-sm text-gray-600"><?= $stat['completionRate'] ?>%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
