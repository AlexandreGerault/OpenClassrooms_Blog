<?php

use \AGerault\Blog\Controllers\Admin\BlogController as AdminBlogController;
use AGerault\Blog\Controllers\Admin\CommentsController;
use AGerault\Blog\Controllers\Admin\DashboardController;
use AGerault\Blog\Controllers\Authentication\LoginController;
use AGerault\Blog\Controllers\Authentication\RegistrationController;
use AGerault\Blog\Controllers\BlogController;
use AGerault\Blog\Controllers\SubmitCommentController;
use AGerault\Blog\Controllers\HomeController;
use AGerault\Blog\Controllers\Logout;
use AGerault\Blog\Controllers\SubmitContactController;

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

    [
        'path' => '/inscription',
        'name' => 'showRegister',
        'method' => 'GET',
        'action' => [RegistrationController::class]
    ],
    [
        'path' => '/inscription',
        'name' => 'handleRegister',
        'method' => 'POST',
        'action' => [RegistrationController::class]
    ],

    // Blog routes
    [
        'path' => '/blog/(.+)/([\d]+)/comment',
        'name' => 'comment.handleSubmit',
        'method' => 'POST',
        'action' => [SubmitCommentController::class],
        'parameters' => ['slug', 'id']
    ],
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

    // Comment administration routes
    [
        'path' => '/admin/comments/([\d]+)/valid',
        'name' => 'admin.comments.valid',
        'method' => 'PATCH',
        'action' => [CommentsController::class, 'validComment'],
        'parameters' => ['id']
    ],
    [
        'path' => '/admin/comments/([\d]+)/invalid',
        'name' => 'admin.comments.invalid',
        'method' => 'PATCH',
        'action' => [CommentsController::class, 'invalidComment'],
        'parameters' => ['id']
    ],
    [
        'path' => '/admin/comments/([\d]+)',
        'name' => 'admin.comments.destroy',
        'method' => 'DELETE',
        'action' => [CommentsController::class, 'delete'],
        'parameters' => ['id']
    ],
    [
        'path' => '/admin/comments/([\d]+)',
        'name' => 'admin.comments.show',
        'method' => 'GET',
        'action' => [CommentsController::class, 'show'],
        'parameters' => ['id']
    ],
    [
        'path' => '/admin/comments',
        'name' => 'admin.comments.index',
        'method' => 'GET',
        'action' => [CommentsController::class, 'index']
    ],

    // Blog administration routes
    [
        'path' => '/admin',
        'name' => 'admin.dashboard',
        'method' => 'GET',
        'action' => [DashboardController::class]
    ],
    [
        'path' => '/admin/blog/create',
        'name' => 'admin.blog.create',
        'method' => 'GET',
        'action' => [AdminBlogController::class, 'create']
    ],
    [
        'path' => '/admin/blog/(.+)/([\d]+)',
        'name' => 'admin.blog.edit',
        'method' => 'GET',
        'action' => [AdminBlogController::class, 'edit'],
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
        'path' => '/admin/blog/(.+)/([\d]+)',
        'name' => 'admin.blog.destroy',
        'method' => 'DELETE',
        'action' => [AdminBlogController::class, 'delete'],
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

    [
        'path' => '/auth/logout',
        'name' => 'auth.logout',
        'method' => 'POST',
        'action' => [Logout::class]
    ],
    [
        'path' => '/contact',
        'name' => 'contact',
        'method' => 'POST',
        'action' => [SubmitContactController::class]
    ]
];
