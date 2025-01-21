<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($course->getTitle()) ?> - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full font-[Inter] bg-gray-50">
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
                <a href="/dashboard" class="text-[#252525] hover:text-[#1fda92] font-semibold">Dashboard</a>
                <form action="/logout" method="POST" class="inline">
                    <button type="submit" class="bg-[#1fda92] text-[#252525] px-4 py-2 rounded-3xl font-semibold hover:bg-[#14F3B1]">Logout</button>
                </form>
            </div>
        <?php endif; ?>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="relative z-10 mb-8">
            <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
            <div class="bg-white rounded-xl p-8 relative border-2 border-[#252525]">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="relative aspect-video rounded-lg overflow-hidden">
                        <?php
                        $thumbnail = $course->getThumbnail();
                        $thumbnailPath = $thumbnail ? $thumbnail->getPath() : '/assets/images/default-course.jpg';
                        ?>
                        <img
                            src="/<?= htmlspecialchars($thumbnailPath) ?>"
                            alt="<?= htmlspecialchars($course->getTitle()) ?>"
                            class="w-full h-full object-cover">
                    </div>

                    <div class="flex flex-col justify-between">
                        <div>
                            <?php $category = $course->getCategory(); ?>
                            <span class="inline-block bg-[#1fda92] text-[#252525] px-4 py-1.5 rounded-full text-sm font-semibold mb-4">
                                <?= htmlspecialchars($category->getName()) ?>
                            </span>

                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php foreach ($course->getTags() as $tag): ?>
                                    <span class="inline-block bg-gray-100 text-[#252525] px-3 py-1 rounded-full text-sm border border-[#252525]">
                                        <?= htmlspecialchars($tag->getName()) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <h1 class="text-3xl font-bold text-[#252525] mb-4">
                                <?= htmlspecialchars($course->getTitle()) ?>
                            </h1>
                            <p class="text-gray-600 mb-6">
                                <?= htmlspecialchars($course->getDescription()) ?>
                            </p>
                        </div>

                        <?php $teacher = $course->getTeacher(); ?>
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg border-2 border-[#252525]">
                            <div class="h-12 w-12 rounded-full bg-[#1fda92] flex items-center justify-center text-[#252525] font-bold text-lg">
                                <?= strtoupper(substr($teacher->getUserName(), 0, 2)) ?>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-[#252525]"><?= htmlspecialchars($teacher->getUserName()) ?></p>
                                <p class="text-sm text-gray-500">Course Instructor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <h2 class="text-2xl font-bold text-[#252525] mb-6">Course Content</h2>

                        <?php if (empty($contents)): ?>
                            <p class="text-gray-500">No content available yet.</p>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($contents as $content): ?>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="mr-4">
                                            <?php if ($content->getType() == 'video'): ?>
                                                <svg class="w-6 h-6 text-[#1fda92]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            <?php else: ?>
                                                <svg class="w-6 h-6 text-[#1fda92]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow">
                                            <h3 class="font-semibold text-[#252525]">
                                                <?= htmlspecialchars($content->getTitle()) ?>
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                <?= htmlspecialchars($content->getDescription()) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="relative z-10">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl top-2 left-2"></div>
                    <div class="bg-white rounded-xl p-6 relative border-2 border-[#252525]">
                        <h2 class="text-xl font-bold text-[#252525] mb-4">Course Details</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Created on</p>
                                <p class="font-semibold"><?= date('F j, Y', strtotime($course->getCreatedAt())) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Category</p>
                                <p class="font-semibold"><?= htmlspecialchars($category->getName()) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Tags</p>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($course->getTags() as $tag): ?>
                                        <span class="inline-block bg-gray-100 text-[#252525] px-3 py-1 rounded-full text-xs border border-[#252525]">
                                            <?= htmlspecialchars($tag->getName()) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php if (!\Core\Auth::check()): ?>
                                <button onclick="goto('/login')"
                                    class="w-full bg-[#1fda92] text-[#252525] py-2 px-4 rounded-lg font-semibold 
                                               border-2 border-[#252525] hover:bg-[#14F3B1] transition duration-300">
                                    Login to Enroll
                                </button>
                            <?php else: ?>
                                <?php
                                $user = \Core\Auth::user();
                                if ($user->getRole() === 'student'):
                                    if ($course->isStudentEnrolled($user->getId())):
                                ?>
                                        <div class="text-center p-3 bg-gray-100 rounded-lg border-2 border-[#252525]">
                                            <p class="text-[#252525] font-semibold">Already Enrolled</p>
                                            <p class="text-sm text-gray-500">Continue learning from your dashboard</p>
                                        </div>
                                    <?php else: ?>
                                        <div class="relative z-10">
                                            <button class="absolute translate-x-1 -z-10 translate-y-1 bg-[#252525] text-[#252525] w-full py-2 border-2 border-[#252525] font-semibold rounded-lg">
                                                Enroll Now
                                            </button>
                                            <form action="/courses/<?= $course->getId() ?>/enroll" method="POST">
                                                <button type="submit"
                                                    class="block w-full text-center bg-[#1fda92] text-[#252525] font-semibold py-2 
                                                          rounded-lg transition duration-300 border-2 border-[#252525] hover:translate-x-1 hover:translate-y-1">
                                                    Enroll Now
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-[#252525] text-white py-6 mt-12">
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

    <script>
        function goto(url) {
            window.location.href = url;
        }
    </script>
</body>

</html>