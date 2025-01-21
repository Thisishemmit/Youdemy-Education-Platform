<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
    <style>
        .course-card:hover .hover-button {
            transform: translateX(3px) translateY(3px);
        }

        .course-card:active .hover-button {
            background: #14F3B1;
        }
    </style>
</head>

<body class="w-full font-[Inter]">
    <div class="flex flex-col min-h-screen">
        <header class="w-full flex justify-between items-center p-4 px-20 bg-white shadow-sm">
            <div class="flex items-center">
                <a href="/">
                    <img src="/assets/images/logoBig.jpg" alt="Youdemy" class="h-10">
                </a>
            </div>
            <?php if (!$auth['check']): ?>
                <div class="flex items-center relative z-20" id="get-started">
                    <button class="absolute translate-x-1 -z-10 translate-y-1 bg-[#252525] text-[#252525] px-6 py-2 border-2 border-[#252525] font-semibold text-lg rounded-3xl">Get Started</button>
                    <button onclick="goto('/login')" class="bg-[#1fda92] text-[#252525] px-6 py-2 border-2 border-[#252525] font-black text-lg rounded-3xl">Get Started</button>
                </div>
            <?php else: ?>
                <div class="flex items-center gap-4">
                    <?php $dashboard = $auth['user']->getRole() === 'teacher' ? '/teacher' : '/student'; ?>
                    <a href="<?= $dashboard ?>" class="text-[#252525] hover:text-[#1fda92] font-semibold">Dashboard</a>
                    <form action="/logout" method="POST" class="inline">
                        <button type="submit" class="bg-[#1fda92] text-[#252525] px-4 py-2 rounded-3xl font-semibold hover:bg-[#14F3B1]">Logout</button>
                    </form>
                </div>
            <?php endif; ?>
        </header>

        <main class="flex-grow bg-gray-50 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-[#252525] mb-4">
                        Discover Our Courses
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Expand your knowledge with our diverse selection of professional courses
                    </p>
                </div>

                <?php if (empty($courses)): ?>
                    <div class="text-center py-12 bg-white rounded-lg shadow-sm">
                        <div class="mb-4">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-[#252525]">No courses available</h3>
                        <p class="mt-1 text-gray-500">Check back soon for new courses!</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php foreach ($courses as $course): ?>
                            <div class="course-card z-10 relative">
                                <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2 ">
                                </div>
                                <div class="bg-white rounded-xl relative transition duration-100 flex flex-col hover:top-1 hover:left-1 border-2 border-[#252525]">
                                    <div class="relative aspect-[16/9] h-48">  <!-- Added fixed height h-48 -->
                                        <?php
                                        $thumbnail = $course->getThumbnail();
                                        $thumbnailPath = $thumbnail ? $thumbnail->getPath() : '/assets/images/default-course.jpg';
                                        ?>
                                        <img class="w-full h-full object-cover rounded-t-xl"
                                            src="<?= htmlspecialchars($thumbnailPath) ?>"
                                            alt="<?= htmlspecialchars($course->getTitle()) ?>">
                                        <?php $category = $course->getCategory(); ?>
                                        <span class="absolute bottom-4 left-4 bg-[#1fda92] text-[#252525] px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm">
                                            <?= htmlspecialchars($category->getName()) ?>
                                        </span>
                                    </div>

                                    <div class="p-5 flex-grow flex flex-col justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-[#252525] mb-2 line-clamp-2">
                                                <?= htmlspecialchars($course->getTitle()) ?>
                                            </h3>

                                            <div class="flex flex-wrap gap-1 mb-2">
                                                <?php foreach ($course->getTags() as $tag): ?>
                                                    <span class="inline-block bg-gray-100 text-[#252525] px-2 py-0.5 rounded-full text-xs border border-[#252525]">
                                                        <?= htmlspecialchars($tag->getName()) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>

                                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                                <?= htmlspecialchars($course->getDescription()) ?>
                                            </p>
                                        </div>

                                        <div class="mt-auto">
                                            <?php $teacher = $course->getTeacher(); ?>
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center">
                                                    <div class="h-8 w-8 rounded-full bg-[#1fda92] flex items-center justify-center text-[#252525] font-bold text-sm">
                                                        <?= strtoupper(substr($teacher->getUserName(), 0, 2)) ?>
                                                    </div>
                                                    <div class="ml-2">
                                                        <p class="text-sm font-semibold text-[#252525] leading-tight">
                                                            <?= htmlspecialchars($teacher->getUserName()) ?>
                                                        </p>
                                                        <p class="text-xs text-gray-500">Instructor</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="relative z-10">
                                                <button class="absolute translate-x-1 -z-10 translate-y-1 bg-[#252525] text-[#252525] w-full py-2 border-2 border-[#252525] font-semibold rounded-lg">
                                                    View Course
                                                </button>
                                                <a href="/courses/<?= $course->getId() ?>"
                                                    class="hover-button block w-full text-center bg-[#1fda92] text-[#252525] font-semibold py-2 
                                                      rounded-lg transition duration-300 border-2 border-[#252525]">
                                                    View Course
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

++                <?php if ($totalPages > 1): ?>
                    <div class="mt-8 flex justify-center gap-2">
                        <?php if ($currentPage > 1): ?>
                            <a href="?page=<?= $currentPage - 1 ?>" 
                               class="px-4 py-2 bg-white border-2 border-[#252525] rounded-lg hover:bg-gray-50">
                                Previous
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?>" 
                               class="px-4 py-2 <?= $i === $currentPage ? 'bg-[#1fda92] border-2 border-[#252525]' : 'bg-white border-2 border-[#252525]' ?> rounded-lg hover:bg-gray-50">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?page=<?= $currentPage + 1 ?>" 
                               class="px-4 py-2 bg-white border-2 border-[#252525] rounded-lg hover:bg-gray-50">
                                Next
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <footer class="bg-[#252525] text-white py-6">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-xl">Youdemy</h3>
                    <p>&copy; <?= date('Y') ?> Youdemy. All rights reserved.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="/about" class="hover:text-[#1fda92]">About</a>
                    <a href="/contact" class="hover:text-[#1fda92]">Contact</a>
                    <a href="/privacy" class="hover:text-[#1fda92]">Privacy</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function goto(url) {
            window.location.href = url;
        }
    </script>
</body>

</html>