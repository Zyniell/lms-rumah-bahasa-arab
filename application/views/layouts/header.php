<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= isset($title) ? html_escape($title) : 'Rumah Bahasa Arab LMS' ?> - Belajar Bahasa Arab Terstruktur</title>
	
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	
	<!-- Tailwind CSS CDN -->
	<script src="https://cdn.tailwindcss.com"></script>
	<script>
		tailwind.config = {
			theme: {
				extend: {
					colors: {
						brand: {
							50: '#f0fdf4',
							100: '#dcfce7',
							200: '#bbf7d0',
							500: '#22c55e',
							600: '#16a34a',
							700: '#15803d',
							800: '#166534',
							900: '#14532d',
						}
					},
					fontFamily: {
						sans: ['"Inter"', 'sans-serif'],
						arabic: ['"Amiri"', 'serif']
					}
				}
			}
		}
	</script>
	<style>
		.font-arabic { font-family: 'Amiri', serif; }
	</style>
</head>
<body class="flex flex-col min-h-full text-slate-800 antialiased font-sans">
