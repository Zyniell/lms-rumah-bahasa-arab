<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$pendingTrxCount = $this->db->where('status', 'pending')->count_all_results('transactions');
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= isset($title) ? html_escape($title) : 'Admin Panel' ?> - Rumah Bahasa Arab</title>
	
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
	
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
</head>
<body class="flex flex-col min-h-full text-slate-800 antialiased font-sans">
	<!-- Admin Topbar -->
	<header class="bg-slate-900 text-white sticky top-0 z-50 border-b border-slate-800">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-16">
				<div class="flex items-center gap-4">
					<a href="<?= site_url('admin') ?>" class="flex items-center gap-3">
						<div class="w-9 h-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-lg">
							<span class="font-arabic text-xl leading-none">ض</span>
						</div>
						<div>
							<span class="text-base font-bold tracking-tight text-white block leading-tight">Admin RBA</span>
							<span class="text-xs text-emerald-400 block leading-tight">Panel Pengelola LMS</span>
						</div>
					</a>

					<div class="hidden md:flex items-center gap-1 ml-6">
						<a href="<?= site_url('admin') ?>" class="px-3 py-1.5 rounded-lg text-sm font-medium <?= uri_string() === 'admin' ? 'bg-slate-800 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' ?>">
							Dashboard
						</a>
						<a href="<?= site_url('admin/courses') ?>" class="px-3 py-1.5 rounded-lg text-sm font-medium <?= strpos(uri_string(), 'admin/courses') === 0 || strpos(uri_string(), 'admin/lessons') === 0 ? 'bg-slate-800 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' ?>">
							Kelola Kelas & Video
						</a>
						<a href="<?= site_url('admin/transactions') ?>" class="px-3 py-1.5 rounded-lg text-sm font-medium flex items-center gap-2 <?= strpos(uri_string(), 'admin/transactions') === 0 ? 'bg-slate-800 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' ?>">
							<span>Verifikasi Transaksi</span>
							<?php if ($pendingTrxCount > 0): ?>
								<span class="bg-amber-500 text-slate-950 text-xs px-2 py-0.5 rounded-full font-bold">
									<?= $pendingTrxCount ?>
								</span>
							<?php endif; ?>
						</a>
						<a href="<?= site_url('admin/students') ?>" class="px-3 py-1.5 rounded-lg text-sm font-medium <?= strpos(uri_string(), 'admin/students') === 0 ? 'bg-slate-800 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' ?>">
							Daftar Peserta
						</a>
					</div>
				</div>

				<div class="flex items-center gap-4">
					<a href="<?= site_url('/') ?>" target="_blank" class="text-xs text-slate-300 hover:text-white flex items-center gap-1 bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-700">
						<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
						Lihat Web Publik
					</a>
					<div class="text-right hidden sm:block">
						<span class="text-xs text-slate-400 block">Masuk sebagai</span>
						<span class="text-xs font-semibold text-white block"><?= html_escape($currentUser['name']) ?></span>
					</div>
					<a href="<?= site_url('auth/logout') ?>" onclick="return confirm('Keluar dari panel admin?');" class="text-slate-400 hover:text-rose-400 p-1.5 rounded-lg hover:bg-slate-800 transition-colors" title="Keluar">
						<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
					</a>
				</div>
			</div>
		</div>

		<!-- Mobile Submenu -->
		<div class="md:hidden border-t border-slate-800 px-4 py-2 flex items-center gap-2 overflow-x-auto text-xs">
			<a href="<?= site_url('admin') ?>" class="px-2.5 py-1 rounded bg-slate-800 text-white whitespace-nowrap">Dashboard</a>
			<a href="<?= site_url('admin/courses') ?>" class="px-2.5 py-1 rounded text-slate-300 hover:bg-slate-800 whitespace-nowrap">Kelola Kelas</a>
			<a href="<?= site_url('admin/transactions') ?>" class="px-2.5 py-1 rounded text-slate-300 hover:bg-slate-800 whitespace-nowrap">Transaksi (<?= $pendingTrxCount ?>)</a>
			<a href="<?= site_url('admin/students') ?>" class="px-2.5 py-1 rounded text-slate-300 hover:bg-slate-800 whitespace-nowrap">Peserta</a>
		</div>
	</header>
