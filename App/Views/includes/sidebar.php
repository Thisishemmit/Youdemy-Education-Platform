<?php

use Core\Auth;

$role = Auth::user()->getRole();
$currentPath = $_SERVER['REQUEST_URI'];

// Define menu items for each role
$menuItems = [
    'admin' => [
        [
            'title' => 'Dashboard',
            'icon' => 'layout-dashboard',
            'url' => '/admin',
            'active' => $currentPath === '/admin'
        ],
        [
            'title' => 'Teachers',
            'icon' => 'users',
            'url' => '/admin/teachers',
            'active' => str_contains($currentPath, '/admin/teachers')
        ],
        [
            'title' => 'Students',
            'icon' => 'graduation-cap',
            'url' => '/admin/students',
            'active' => str_contains($currentPath, '/admin/students')
        ],
        [
            'title' => 'Courses',
            'icon' => 'book-open',
            'url' => '/admin/courses',
            'active' => str_contains($currentPath, '/admin/courses')
        ],
        [
            'title' => 'Categories',
            'icon' => 'folder',
            'url' => '/admin/categories',
            'active' => str_contains($currentPath, '/admin/categories')
        ],
        [
            'title' => 'Tags',
            'icon' => 'hash',
            'url' => '/admin/tags',
            'active' => str_contains($currentPath, '/admin/tags')
        ]
    ],
    'teacher' => [
        [
            'title' => 'Dashboard',
            'icon' => 'layout-dashboard',
            'url' => '/teacher',
            'active' => $currentPath === '/teacher'
        ],
        [
            'title' => 'My Courses',
            'icon' => 'book-open',
            'url' => '/teacher/courses',
            'active' => str_contains($currentPath, '/teacher/courses')
        ],
        [
            'title' => 'Analytics',
            'icon' => 'bar-chart',
            'url' => '/teacher/analytics',
            'active' => str_contains($currentPath, '/teacher/analytics')
        ]
    ],
    'student' => [
        [
            'title' => 'Dashboard',
            'icon' => 'layout-dashboard',
            'url' => '/student',
            'active' => $currentPath === '/student'
        ],
        [
            'title' => 'My Courses',
            'icon' => 'book-open',
            'url' => '/student/courses',
            'active' => str_contains($currentPath, '/student/courses')
        ],
    ]
];

$currentMenuItems = $menuItems[$role] ?? [];
?>

<aside class="w-64 h-screen bg-[#252525] text-white fixed left-0 top-0 overflow-y-auto">
    <div class="p-4">
        <div class="flex items-center space-x-2 mb-8 bg-white p-2 rounded-lg justify-center">
            <img src="/assets/images/logoBig.jpg" alt="logo" class="h-8">
        </div>

        <nav>
            <?php foreach ($currentMenuItems as $item): ?>
                <a href="<?php echo $item['url']; ?>"
                    class="flex items-center space-x-2 p-2 rounded-lg mb-1 <?php echo $item['active'] ? 'bg-[#1fda92] text-[#252525]' : 'hover:bg-white/10'; ?>">
                    <i data-lucide="<?php echo $item['icon']; ?>" class="w-5 h-5"></i>
                    <span><?php echo $item['title']; ?></span>
                </a>
            <?php endforeach; ?>

            <div class="border-t border-white/10 my-4"></div>

            <form action="/logout" method="POST">
                <button type="submit" class="flex items-center space-x-2 p-2 rounded-lg text-red-400 hover:bg-white/10 w-full">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </div>
</aside>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>