<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Teacher Dashboard</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full font-[Inter] bg-gray-50">
    <div class="flex">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 ml-64 p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-[#252525]">My Courses</h1>
                    <p class="text-gray-600 mt-1">Manage and organize your courses</p>
                </div>
                <a href="/teacher/courses/create"
                    class="bg-[#1fda92] text-[#252525] px-6 py-2 rounded-lg font-semibold border-2 border-[#252525] hover:bg-[#14F3B1]">
                    Create New Course
                </a>
            </div>

            <?php if ($this->hasFlash('/teacher/courses')): ?>
                <?php $flash = $this->getFlash('/teacher/courses'); ?>
                <div class="mb-6 p-4 rounded-lg <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' ?>">
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>

            <?php if (empty($courses)): ?>
                <div class="bg-white rounded-xl p-8 text-center border-2 border-[#252525] relative">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl -z-10 top-2 left-2"></div>
                    <i data-lucide="book" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                    <h3 class="text-lg font-medium text-[#252525] mb-2">No courses yet</h3>
                    <p class="text-gray-500 mb-6">Start creating your first course</p>
                    <a href="/teacher/courses/create"
                        class="inline-block bg-[#1fda92] text-[#252525] px-6 py-2 rounded-lg font-semibold border-2 border-[#252525] hover:bg-[#14F3B1]">
                        Create Course
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-6">
                    <?php foreach ($courses as $course): ?>
                        <div class="relative z-10">
                            <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                            <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                                <div class="flex items-center gap-6">
                                    <?php
                                    $thumbnail = $course->getThumbnail();
                                    $thumbnailPath = $thumbnail ? $thumbnail->getPath() : '/assets/images/default-course.jpg';
                                    ?>
                                    <img src="/<?= htmlspecialchars($thumbnailPath) ?>"
                                        alt="<?= htmlspecialchars($course->getTitle()) ?>"
                                        class="w-32 h-20 object-cover rounded-lg border border-gray-200">

                                    <div class="flex-grow">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-xl font-bold text-[#252525]">
                                                <?= htmlspecialchars($course->getTitle()) ?>
                                            </h3>
                                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                                                       <?= $course->isPublished() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                                <?= $course->isPublished() ? 'Published' : 'Draft' ?>
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                                            <span class="bg-[#1fda92]/10 px-2 py-1 rounded-md">
                                                <?= htmlspecialchars($course->getCategory()->getName()) ?>
                                            </span>
                                            <span>•</span>
                                            <div class="flex gap-2">
                                                <?php foreach ($course->getTags() as $tag): ?>
                                                    <span class="bg-gray-100 px-2 py-1 rounded-md">
                                                        <?= htmlspecialchars($tag->getName()) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <a href="/teacher/courses/<?= $course->getId() ?>/edit"
                                            class="p-2 text-gray-500 hover:text-[#1fda92]"
                                            title="Edit course">
                                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                                        </a>
                                        <form method="POST" action="/teacher/courses/<?= $course->getId() ?>/<?= $course->isPublished() ? 'unpublish' : 'publish' ?>"
                                            class="inline">
                                            <button type="submit"
                                                class="p-2 text-gray-500 hover:text-[#1fda92]"
                                                title="<?= $course->isPublished() ? 'Unpublish' : 'Publish' ?>">
                                                <i data-lucide="<?= $course->isPublished() ? 'eye-off' : 'eye' ?>" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="/teacher/courses/delete"
                                            class="inline">
                                            <input type="hidden" name="course_id" value="<?= $course->getId() ?>">
                                            <button type="submit"
                                                class="p-2 text-gray-500 hover:text-red-600"
                                                title="Delete course">

                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
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