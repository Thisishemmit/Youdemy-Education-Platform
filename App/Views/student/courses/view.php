<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($course->getTitle()) ?> - Learning - Youdemy</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full font-[Inter] bg-gray-50">
    <div class="flex">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>
        <main class="flex-1 ml-64 p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-[#252525]"><?= htmlspecialchars($course->getTitle()) ?></h1>
                    <div class="flex items-center gap-4 mt-2">
                        <?php $teacher = $course->getTeacher(); ?>
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-[#1fda92] flex items-center justify-center text-[#252525] font-bold text-sm">
                                <?= strtoupper(substr($teacher->getUserName(), 0, 2)) ?>
                            </div>
                            <p class="ml-2 text-sm text-gray-600">
                                <?= htmlspecialchars($teacher->getUserName()) ?>
                            </p>
                        </div>
                        <span class="text-gray-400">•</span>
                        <span class="bg-[#1fda92] px-3 py-1 rounded-full text-sm font-medium">
                            <?= htmlspecialchars($course->getCategory()->getName()) ?>
                        </span>
                    </div>
                </div>

                <div class="flex gap-4">
                    <?php if (!$student->isCompleted($course->getId())): ?>
                        <form action="/student/courses/<?= $course->getId() ?>/complete" method="POST">
                            <button type="submit"
                                class="bg-[#1fda92] text-[#252525] px-6 py-2 rounded-lg font-semibold border-2 border-[#252525] hover:bg-[#14F3B1]">
                                Mark as Complete
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="bg-green-100 text-green-800 px-6 py-2 rounded-lg font-semibold border-2 border-green-800 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Completed
                        </div>
                    <?php endif; ?>

                    <form action="/student/courses/<?= $course->getId() ?>/drop" method="POST"
                        onsubmit="return confirm('Are you sure you want to drop this course?');">
                        <button type="submit"
                            class="bg-white text-red-600 px-6 py-2 rounded-lg font-semibold border-2 border-red-600 hover:bg-red-600 hover:text-white">
                            Drop Course
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-8">
                <div class="col-span-2 bg-white rounded-xl border-2 border-[#252525] relative">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl -z-10 top-2 left-2"></div>
                    <div class="p-6">
                        <?php

                        if ($content):
                            if ($content->getType() === 'video'):
                        ?>
                                <video controls class="w-full rounded-lg mb-4 bg-black">
                                    <source src="/<?= htmlspecialchars($content->getPath()) ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <?php
                            elseif ($content instanceof \App\Models\Document):
                                $ext = strtolower($content->getFileExtension());
                                if ($ext === 'pdf'):
                                ?>
                                    <iframe src="/<?= htmlspecialchars($content->getPath()) ?>"
                                        class="w-full h-[600px] rounded-lg mb-4 border border-gray-200">
                                    </iframe>
                                <?php else: ?>
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <svg class="w-8 h-8 text-[#1fda92]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($content->getTitle()) ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <?= number_format($content->getFileSize() / 1024 / 1024, 2) ?> MB
                                                </p>
                                            </div>
                                        </div>
                                        <a href="/<?= htmlspecialchars($content->getPath()) ?>"
                                            class="bg-[#1fda92] text-[#252525] px-4 py-2 rounded-lg text-sm font-semibold border border-[#252525]"
                                            download>
                                            Download
                                        </a>
                                    </div>
                        <?php
                                endif;
                            endif;
                        endif;
                        ?>

                        <div class="mt-6">
                            <h2 class="text-xl font-bold text-[#252525] mb-4">
                                <?php echo $content->getTitle() ?>
                                <?= htmlspecialchars($course->getTitle()) ?>
                            </h2>
                            <p class="text-gray-600">
                                <?= htmlspecialchars($course->getDescription()) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 bg-white rounded-xl border-2 border-[#252525] relative h-fit">
                    <div class="absolute w-full h-full bg-[#252525] rounded-xl -z-10 top-2 left-2"></div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-4">Course Content</h3>
                        <div class="space-y-2">
                            <div class="p-3 rounded-lg bg-[#1fda92]/10 border-2 border-[#1fda92]">
                                <div class="flex items-center">
                                    <div class="mr-3">
                                        <?php if ($content instanceof \App\Models\Video): ?>
                                            <i data-lucide="play-circle" class="w-5 h-5 text-[#1fda92]"></i>
                                        <?php else: ?>
                                            <i data-lucide="file-text" class="w-5 h-5 text-[#1fda92]"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-sm font-medium text-[#252525]">
                                            <?= htmlspecialchars($content->getTitle()) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
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