<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full font-[Inter] bg-gray-50">
    <div class="flex">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#252525]">Welcome, <?= htmlspecialchars($teacher->getUserName()) ?>!</h1>
                <p class="text-gray-600 mt-1">Manage your courses and track your students' progress</p>
            </div>

            <!-- Quick Actions -->
            <div class="relative z-10 mb-8">
                <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="/teacher/courses/create" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <div class="h-12 w-12 rounded-lg bg-[#1fda92] flex items-center justify-center text-[#252525]">
                                <i data-lucide="plus" class="w-6 h-6"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-[#252525]">Create New Course</h3>
                                <p class="text-sm text-gray-500">Add a new course to your catalog</p>
                            </div>
                        </a>
                        <a href="/teacher/courses" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <div class="h-12 w-12 rounded-lg bg-[#1fda92] flex items-center justify-center text-[#252525]">
                                <i data-lucide="book-open" class="w-6 h-6"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-[#252525]">Manage Courses</h3>
                                <p class="text-sm text-gray-500">Edit and update your existing courses</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Courses -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Courses</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= count($courses) ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="book" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Published Courses -->
                <?php
                $publishedCount = 0;
                foreach ($courses as $course) {
                    if ($course->isPublished()) $publishedCount++;
                }
                ?>
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Published</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= $publishedCount ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="check-circle" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Draft Courses -->
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Drafts</p>
                                <p class="text-2xl font-bold text-[#252525]"><?= count($courses) - $publishedCount ?></p>
                            </div>
                            <div class="bg-[#1fda92]/10 p-3 rounded-lg">
                                <i data-lucide="edit-3" class="w-6 h-6 text-[#1fda92]"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Courses -->
            <div class="relative z-10">
                <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-[#252525]">Recent Courses</h2>
                        <a href="/teacher/courses" class="text-[#1fda92] hover:underline">View All</a>
                    </div>

                    <?php if (empty($courses)): ?>
                        <div class="text-center py-8">
                            <i data-lucide="book" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                            <p class="text-gray-500">You haven't created any courses yet</p>
                            <a href="/teacher/courses/create" class="text-[#1fda92] font-medium hover:underline mt-2 inline-block">Create Your First Course</a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php
                            $recentCourses = array_slice($courses, 0, 3);
                            foreach ($recentCourses as $course):
                            ?>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                    <div class="flex items-center gap-4">
                                        <?php
                                        $thumbnail = $course->getThumbnail();
                                        $thumbnailPath = $thumbnail ? $thumbnail->getPath() : '/assets/images/default-course.jpg';
                                        ?>
                                        <img src="/<?= htmlspecialchars($thumbnailPath) ?>"
                                            alt="<?= htmlspecialchars($course->getTitle()) ?>"
                                            class="w-12 h-12 rounded-lg object-cover">
                                        <div>
                                            <h3 class="font-semibold text-[#252525]"><?= htmlspecialchars($course->getTitle()) ?></h3>
                                            <p class="text-sm text-gray-500">
                                                <?= $course->isPublished() ? 'Published' : 'Draft' ?>
                                            </p>
                                        </div>
                                    </div>
                                    <a href="/teacher/courses/<?= $course->getId() ?>/edit"
                                        class="text-[#1fda92] hover:text-[#14F3B1]">
                                        <i data-lucide="edit" class="w-5 h-5"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
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