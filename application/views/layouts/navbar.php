<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<!-- Left Brand & Nav Links -->
			<div class="flex items-center">
				<a href="<?= site_url('/') ?>" class="flex items-center gap-3 group">
					<div class="w-10 h-10 rounded-xl bg-brand-800 text-white flex items-center justify-center font-bold text-xl shadow-sm group-hover:bg-brand-900 transition-colors">
						<span class="font-arabic text-2xl leading-none">ض</span>
					</div>
					<div>
						<span class="text-lg font-bold text-slate-900 tracking-tight block leading-tight">Rumah Bahasa Arab</span>
						<span class="text-xs text-brand-700 font-medium font-arabic block leading-none">دار اللغة العربية</span>
					</div>
				</a>

				<div class="hidden md:ml-8 md:flex md:space-x-4">
					<a href="<?= site_url('/') ?>" class="px-3 py-2 rounded-lg text-sm font-medium <?= uri_string() == '' ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' ?>">
						Beranda
					</a>
					<a href="<?= site_url('courses') ?>" class="px-3 py-2 rounded-lg text-sm font-medium <?= strpos(uri_string(), 'courses') === 0 || strpos(uri_string(), 'course') === 0 ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' ?>">
						Katalog Kelas
					</a>
				</div>
			</div>

			<!-- Right Auth Actions -->
			<div class="hidden md:flex md:items-center md:gap-3">
				<?php if (!empty($currentUser)): ?>
					<?php if ($currentUser['role'] === 'admin'): ?>
						<a href="<?= site_url('admin') ?>" class="px-3 py-2 rounded-lg text-sm font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 flex items-center gap-1.5 border border-amber-200 transition-colors">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
							Panel Admin
						</a>
					<?php endif; ?>

					<a href="<?= site_url('my-courses') ?>" class="px-3 py-2 rounded-lg text-sm font-medium <?= uri_string() == 'my-courses' ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' ?>">
						Kelas Saya
					</a>

					<a href="<?= site_url('my-transactions') ?>" class="px-3 py-2 rounded-lg text-sm font-medium <?= uri_string() == 'my-transactions' ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' ?>">
						Transaksi
					</a>

					<div class="h-5 w-px bg-slate-200"></div>

					<div class="flex items-center gap-3">
						<div class="flex flex-col text-right">
							<span class="text-sm font-semibold text-slate-900 leading-tight"><?= html_escape($currentUser['name']) ?></span>
							<span class="text-xs text-slate-500 capitalize"><?= html_escape($currentUser['role']) ?></span>
						</div>
						<a href="<?= site_url('auth/logout') ?>" onclick="return confirm('Apakah Anda yakin ingin keluar?');" class="p-2 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors" title="Keluar">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
						</a>
					</div>
				<?php else: ?>
					<a href="<?= site_url('auth/login') ?>" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
						Masuk
					</a>
					<a href="<?= site_url('auth/register') ?>" class="px-4 py-2 text-sm font-semibold text-white bg-brand-800 hover:bg-brand-900 rounded-lg shadow-sm transition-colors">
						Daftar Sekarang
					</a>
				<?php endif; ?>
			</div>

			<!-- Mobile Menu Button -->
			<div class="flex items-center md:hidden">
				<button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
				</button>
			</div>
		</div>
	</div>

	<!-- Mobile dropdown -->
	<div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-4 space-y-1">
		<a href="<?= site_url('/') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Beranda</a>
		<a href="<?= site_url('courses') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Katalog Kelas</a>
		<?php if (!empty($currentUser)): ?>
			<?php if ($currentUser['role'] === 'admin'): ?>
				<a href="<?= site_url('admin') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-amber-700 bg-amber-50">Panel Admin</a>
			<?php endif; ?>
			<a href="<?= site_url('my-courses') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Kelas Saya</a>
			<a href="<?= site_url('my-transactions') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Riwayat Transaksi</a>
			<div class="pt-2 border-t border-slate-200 mt-2">
				<div class="px-3 py-1 text-sm font-semibold text-slate-800"><?= html_escape($currentUser['name']) ?> (<?= html_escape($currentUser['role']) ?>)</div>
				<a href="<?= site_url('auth/logout') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-rose-600 hover:bg-rose-50">Keluar</a>
			</div>
		<?php else: ?>
			<div class="pt-2 border-t border-slate-200 flex flex-col gap-2 mt-2">
				<a href="<?= site_url('auth/login') ?>" class="block text-center px-4 py-2 text-sm font-semibold text-slate-700 border border-slate-300 rounded-lg">Masuk</a>
				<a href="<?= site_url('auth/register') ?>" class="block text-center px-4 py-2 text-sm font-semibold text-white bg-brand-800 rounded-lg">Daftar Sekarang</a>
			</div>
		<?php endif; ?>
	</div>
</nav>
