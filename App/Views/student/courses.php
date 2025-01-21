<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full font-[Inter] bg-gray-50">
    <div class="flex">
        <?php
        require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-[#252525]">My Courses</h1>
                    <p class="text-gray-600">Keep track of your learning journey</p>
                </div>
                <a href="/courses"
                    class="bg-[#1fda92] text-[#252525] px-6 py-2 rounded-lg font-semibold border-2 border-[#252525] hover:bg-[#14F3B1]">
                    Browse More Courses
                </a>
            </div>

            <?php if ($this->hasFlash('/student/courses')): ?>
                <?php $flash = $this->getFlash('/student/courses'); ?>
                <div class="mb-6 p-4 rounded-lg <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>

            <?php if (empty($courses)): ?>
                <div class="bg-white rounded-xl p-8 text-center border-2 border-[#252525] relative">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl -z-10 top-2 left-2"></div>
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-lg font-medium text-[#252525] mb-2">No courses enrolled yet</h3>
                    <p class="text-gray-600 mb-6">Start your learning journey by enrolling in a course</p>
                    <a href="/courses"
                        class="inline-block bg-[#1fda92] text-[#252525] px-6 py-2 rounded-lg font-semibold border-2 border-[#252525] hover:bg-[#14F3B1]">
                        Explore Courses
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($courses as $course): ?>
                        <div class="relative z-10">
                            <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                            <div class="bg-white h-full rounded-xl relative border-2 border-[#252525] flex flex-col">
                                <div class="relative aspect-[16/9] h-48">  <!-- Added fixed height h-48 -->
                                    <?php
                                    $thumbnail = $course->getThumbnail();
                                    $thumbnailPath = $thumbnail ? $thumbnail->getPath() : '/assets/images/default-course.jpg';
                                    ?>
                                    <img class="w-full h-full object-cover rounded-t-xl"
                                        src="/<?= htmlspecialchars($thumbnailPath) ?>"
                                        alt="<?= htmlspecialchars($course->getTitle()) ?>">
                                </div>

                                <div class="p-6">
                                    <div class="mb-4">
                                        <h3 class="text-lg font-bold text-[#252525] mb-2">
                                            <?= htmlspecialchars($course->getTitle()) ?>
                                        </h3>
                                        <p class="text-gray-600 text-sm line-clamp-2">
                                            <?= htmlspecialchars($course->getDescription()) ?>
                                        </p>
                                    </div>

                                    <!-- Course Meta -->
                                    <div class="flex items-center justify-between mb-4">
                                        <?php $teacher = $course->getTeacher(); ?>
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-[#1fda92] flex items-center justify-center text-[#252525] font-bold text-sm">
                                                <?= strtoupper(substr($teacher->getUserName(), 0, 2)) ?>
                                            </div>
                                            <div class="ml-2">
                                                <p class="text-sm font-semibold text-[#252525]">
                                                    <?= htmlspecialchars($teacher->getUserName()) ?>
                                                </p>
                                                <p class="text-xs text-gray-500">Instructor</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-auto">
                                        <?php if ($student->isCompleted($course->getId())): ?>
                                            <div class="flex flex-col gap-2">
                                                <div class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-sm text-center border border-green-800">
                                                    Completed
                                                </div>
                                                <a href="/student/courses/<?= $course->getId() ?>"
                                                    class="block w-full text-center bg-[#1fda92] text-[#252525] py-2 px-4 rounded-lg font-semibold 
                                                          border-2 border-[#252525] hover:bg-[#14F3B1] transition duration-300">
                                                    Review Course
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <a href="/student/courses/<?= $course->getId() ?>"
                                                class="block w-full text-center bg-[#1fda92] text-[#252525] py-2 px-4 rounded-lg font-semibold 
                                                      border-2 border-[#252525] hover:bg-[#14F3B1] transition duration-300">
                                                Continue Learning
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>