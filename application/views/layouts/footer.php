<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<footer class="bg-white border-t border-slate-200 mt-auto">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
		<div class="flex flex-col md:flex-row items-center justify-between gap-4">
			<div class="flex items-center gap-3">
				<div class="w-8 h-8 rounded-lg bg-brand-800 text-white flex items-center justify-center font-bold text-sm">
					<span class="font-arabic text-lg leading-none">ض</span>
				</div>
				<div>
					<p class="text-sm font-semibold text-slate-800">Rumah Bahasa Arab (RBA)</p>
					<p class="text-xs text-slate-500">Platform pembelajaran bahasa Arab terstruktur berbasis video YouTube.</p>
				</div>
			</div>

			<div class="flex items-center gap-6 text-sm text-slate-500">
				<a href="<?= site_url('/') ?>" class="hover:text-slate-800 transition-colors">Beranda</a>
				<a href="<?= site_url('courses') ?>" class="hover:text-slate-800 transition-colors">Katalog Kelas</a>
				<?php if (!empty($currentUser)): ?>
					<a href="<?= site_url('my-courses') ?>" class="hover:text-slate-800 transition-colors">Kelas Saya</a>
				<?php endif; ?>
			</div>

			<p class="text-xs text-slate-400">
				&copy; <?= date('Y') ?> Rumah Bahasa Arab. Hak Cipta Dilindungi.
			</p>
		</div>
	</div>
</footer>
</body>
</html>
