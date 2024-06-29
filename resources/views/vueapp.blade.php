<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml"
    xmlns:h="http://java.sun.com/jsf/html"
    xmlns:f="http://java.sun.com/jsf/core"
    xmlns:p="http://primefaces.org/ui"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <x-meta />
    {{-- @include('components.meta.index') --}}
    @vite(['resources/css/app.css','resources/js/app.ts'])
</head>
<body class="antialiased bg-bg-700 w-full flex flex-row gap-0 relative">
	<x-warning-misconfiguration />
    @include('includes.svg')
	<div id="app">
        <app/>
	</div>
</body>
</html>
