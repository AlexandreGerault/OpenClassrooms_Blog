<?php

use \AGerault\Blog\Controllers\Admin\BlogController as AdminBlogController;
use AGerault\Blog\Controllers\Authentication\LoginController;
use AGerault\Blog\Controllers\BlogController;
use AGerault\Blog\Controllers\HomeController;

return [
    [
        'path' => '/',
        'name' => 'home',
        'method' => 'GET',
        'action' => [HomeController::class]
    ],

    [
        'path' => '/connexion',
        'name' => 'showLogin',
        'method' => 'GET',
        'action' => [LoginController::class]
    ],
    [
        'path' => '/connexion',
        'name' => 'handleLogin',
        'method' => 'POST',
        'action' => [LoginController::class]
    ],

    // Blog routes
    [
        'path' => '/blog/(.+)/([\d]+)',
        'name' => 'blog.show',
        'method' => 'GET',
        'action' => [BlogController::class, 'show'],
        'parameters' => ['slug', 'id']
    ],
    [
        'path' => '/blog',
        'name' => 'blog.index',
        'method' => 'GET',
        'action' => [BlogController::class, 'index']
    ],

    // Blog administration routes
    [
        'path' => '/admin/blog/create',
        'name' => 'admin.blog.create',
        'method' => 'GET',
        'action' => [AdminBlogController::class, 'create']
    ],
    [
        'path' => '/admin/blog/(.+)/([\d]+)/edit',
        'name' => 'admin.blog.edit',
        'method' => 'GET',
        'action' => [AdminBlogController::class, 'edit'],
        'parameters' => ['slug', 'id']
    ],
    [
        'path' => '/admin/blog/(.+)/([\d]+)',
        'name' => 'admin.blog.show',
        'method' => 'GET',
        'action' => [AdminBlogController::class, 'show'],
        'parameters' => ['slug', 'id']
    ],
    [
        'path' => '/admin/blog/(.+)/([\d]+)',
        'name' => 'admin.blog.update',
        'method' => 'PUT',
        'action' => [AdminBlogController::class, 'update'],
        'parameters' => ['slug', 'id']
    ],
    [
        'path' => '/admin/blog',
        'name' => 'admin.blog.index',
        'method' => 'GET',
        'action' => [AdminBlogController::class, 'index']
    ],
    [
        'path' => '/admin/blog',
        'name' => 'admin.blog.store',
        'method' => 'POST',
        'action' => [AdminBlogController::class, 'store']
    ],
];
