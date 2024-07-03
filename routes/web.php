<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware(['auth'])->group(function () {
    Volt::route('/home', 'pages.home')->name('home');
    Volt::route('/user/{username}', 'pages.profile.view')->name('profile.view');
    Volt::route('/profile/edit', 'pages.profile.edit')->name('profile.edit');
    Volt::route('/notification', 'pages.notification')->name('notification');
    Volt::route('/ask', 'pages.ask')->name('ask');
    Volt::route('/search', 'pages.search')->name('search');
    Volt::route('/question/{question_id}', 'pages.question-detail')->name('question.view');
});

require __DIR__.'/auth.php';
