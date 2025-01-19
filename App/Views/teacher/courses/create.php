
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Content - Teacher Dashboard</title>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
</head>

<body class="w-full bg-gray-50">
    <div class="flex min-h-screen font-[Inter]">
        <?php require_once '../App/Views/includes/sidebar.php'; ?>

        <main class="flex-1 p-8 ml-64">
            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-[#252525]">Create Course Content</h1>
                    <a href="/teacher/courses" class="text-gray-600 hover:text-gray-800">
                        <i data-lucide="arrow-left" class="w-6 h-6"></i>
                    </a>
                </div>

                <?php if ($this->hasFlash('/teacher/content/create')): ?>
                    <?php 
                        $flash = $this->getFlash('/teacher/content/create');
                        $bgColor = $flash['type'] === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
                    ?>
                    <div class="<?php echo $bgColor; ?> border px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline"><?php echo $flash['message']; ?></span>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-lg shadow">
                    <form action="/teacher/content/create" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                        <input type="hidden" name="course_id" value="<?php echo $courseId; ?>">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Content Type</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="content_type" value="video" class="form-radio text-[#1fda92]" required>
                                    <span class="ml-2">Video</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="content_type" value="document" class="form-radio text-[#1fda92]" required>
                                    <span class="ml-2">Document</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                <input type="text" id="title" name="title" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]">
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="description" name="description" rows="4" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1fda92]"></textarea>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Thumbnail</label>
                            <div class="flex flex-col justify-center">
                                <label class="block mb-4">
                                    <span class="sr-only">Choose thumbnail</span>
                                    <input type="file" name="thumbnail" accept="image/jpeg,image/png" required
                                           class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-lg file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-[#1fda92] file:text-[#252525]
                                                  hover:file:bg-opacity-90">
                                </label>
                                <div class="text-sm text-gray-500 space-y-1">
                                    <p>• Maximum file size: 1MB</p>
                                    <p>• Supported formats: JPG, PNG</p>
                                    <p>• Recommended size: 16:9 aspect ratio</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Content File</label>
                            <div class="flex flex-col justify-center">
                                <label class="block mb-4">
                                    <span class="sr-only">Choose content file</span>
                                    <input type="file" name="content_file" required
                                           class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-lg file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-[#1fda92] file:text-[#252525]
                                                  hover:file:bg-opacity-90">
                                </label>
                                <div class="text-sm text-gray-500">
                                    <p>• Videos: MP4 format</p>
                                    <p>• Documents: PDF, DOCX formats</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="/teacher/courses" 
                               class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-[#1fda92] text-[#252525] px-4 py-2 rounded-lg font-semibold hover:bg-opacity-90">
                                Create Content
                            </button>
                        </div>
                    </form>
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