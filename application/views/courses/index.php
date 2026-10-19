<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="py-10">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Header -->
		<div class="mb-8">
			<div class="flex items-center gap-2 text-xs font-semibold text-brand-700 uppercase tracking-wider mb-2">
				<a href="<?= site_url('/') ?>" class="hover:underline">Beranda</a> &rsaquo; <span>Katalog Kursus</span>
			</div>
			<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
				<div>
					<h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Kelas Bahasa Arab</h1>
					<p class="mt-1 text-sm text-slate-500">Pilih program belajar bahasa Arab sesuai tingkat dan kebutuhan Anda</p>
				</div>

				<!-- Filter Tabs -->
				<div class="inline-flex p-1 bg-slate-200/80 rounded-xl text-xs font-semibold self-start sm:self-auto">
					<a href="<?= site_url('courses') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= empty($currentType) ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
						Semua
					</a>
					<a href="<?= site_url('courses?type=free') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= $currentType === 'free' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
						Gratis
					</a>
					<a href="<?= site_url('courses?type=paid') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= $currentType === 'paid' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
						Berbayar
					</a>
				</div>
			</div>
		</div>

		<!-- Course Grid -->
		<?php if (!empty($courses)): ?>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php foreach ($courses as $c): ?>
					<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col group">
						<!-- Course Card Header / Thumbnail Banner -->
						<div class="relative h-44 bg-gradient-to-br from-brand-900 via-brand-800 to-slate-900 flex items-center justify-center p-6 text-white overflow-hidden">
							<div class="absolute inset-0 opacity-10 font-arabic text-8xl flex items-center justify-center select-none pointer-events-none">
								عربية
							</div>
							<div class="relative z-10 text-center">
								<span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold <?= $c->type === 'free' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30' ?> mb-2">
									<?= $c->type === 'free' ? 'Kelas Gratis' : 'Kelas Berbayar' ?>
								</span>
								<h3 class="text-lg font-bold line-clamp-2 leading-snug">
									<?= html_escape($c->title) ?>
								</h3>
							</div>
						</div>

						<!-- Card Body -->
						<div class="p-5 flex-1 flex flex-col justify-between">
							<div>
								<div class="flex items-center gap-3 text-xs text-slate-500 mb-3">
									<span class="flex items-center gap-1 font-medium">
										<svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
										<?= $c->total_lessons ?> Video Materi
									</span>
									<span>•</span>
									<span class="flex items-center gap-1">
										<svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
										<?= $c->total_students ?> Santri
									</span>
								</div>

								<p class="text-sm text-slate-600 line-clamp-3 leading-relaxed mb-4">
									<?= html_escape($c->description) ?>
								</p>
							</div>

							<div class="pt-4 border-t border-slate-100 flex items-center justify-between">
								<div>
									<span class="text-xs text-slate-400 block leading-tight">Biaya Belajar:</span>
									<span class="text-base font-bold <?= $c->type === 'free' ? 'text-emerald-700' : 'text-slate-900' ?>">
										<?= format_rupiah($c->price) ?>
									</span>
								</div>

								<a href="<?= site_url('course/' . $c->slug) ?>" class="px-4 py-2 rounded-xl text-xs font-semibold text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition-colors">
									Lihat Detail &rarr;
								</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-md mx-auto">
				<div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
				</div>
				<h3 class="text-base font-bold text-slate-800">Tidak ada kelas ditemukan</h3>
				<p class="text-sm text-slate-500 mt-1">Coba pilih filter lain untuk melihat kelas yang tersedia.</p>
				<a href="<?= site_url('courses') ?>" class="mt-4 inline-block px-4 py-2 text-xs font-semibold text-brand-700 bg-brand-50 rounded-lg">Reset Filter</a>
			</div>
		<?php endif; ?>
	</div>
</section>
