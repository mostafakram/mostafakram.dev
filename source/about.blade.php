---
title: About
description: A little bit about the site
---
@extends('_layouts.master')

@section('body')
    <h1>Hi, I'm Mostafa.</h1>

    <div style="background-image: url('/assets/img/about.png')"
         class="flex rounded-full h-64 w-64 bg-cover mx-auto md:float-right my-6 md:ml-10"></div>

    <p class="mb-6">
        A full-stack developer at <a href="34ml.com">34ML</a> located in Cairo, Egypt.
        Most of my time is spent at 34ml developing web and mobile apps with <span class="font-bold">Laravel</span> and <span class="font-bold">Swift</span>.
    </p>

    <h3>My Work</h3>

    <p class="mb-6">
        I've worked on some pretty interesting projects, including iOS app for Premium Card Egypt, internal iOS app for Merck Group, backend app for Family Transport and other interesting customers as AstraZeneca, Colors, Inploy and more, serving over 100k users.
    </p>

    <h3>Uses</h3>

    <ul class="pl-4 mb-6">
        <li> <a href="https://www.jetbrains.com/phpstorm/">Phpstorm</a> is my main IDE for developing laravel project</li>
        <li> <a href="https://developer.apple.com/xcode/">Xcode</a> for iOS projects</li>
        <li> <a href="https://www.sublimetext.com/">Sublime Text</a> for quick files edits</li>
        <li> <a href="https://www.sublimemerge.com/">Sublime Merge</a> is my daily use for GUI git</li>
        <li> <a href="https://myray.app/">Ray</a> from Spatie for debugging</li>
        <li> <a href="https://invoker.dev/">Invoker</a> to quickly manipulate the data and tinker my app</li>
        <li> <a href="https://xdebug.org/">Xdebug</a> for debugging when tracing down the code is needed</li>
        <li> <a href="https://laravel.com/docs/8.x/valet">Laravel Valet</a> as my local development environment</li>
        <li> <a href="https://dbeaver.io/">DBeaver</a> for mysql databases</li>
        <li> <a href="https://www.docker.com/">Docker</a> to run apps in containers</li>
        <li><a href="https://github.com/nicoverbruggen/phpmon">Php monitor</a> to manage Laravel Valet's php</li>
    </ul>

@endsection
