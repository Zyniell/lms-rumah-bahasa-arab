<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Hero Section -->
<section class="bg-gradient-to-b from-brand-50/60 via-white to-slate-50 border-b border-slate-200 py-16 lg:py-24">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="max-w-3xl mx-auto text-center">
			<div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-100 text-brand-800 text-xs font-semibold mb-6 shadow-sm">
				<span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
				Platform Kursus Online Bahasa Arab
				<span class="text-brand-700 font-arabic text-sm">| رِحْلَةُ تَعَلُّمِ العَرَبِيَّةِ</span>
			</div>
			<h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
				Kuasai Bahasa Arab Terstruktur Bersama <span class="text-brand-800">Rumah Bahasa Arab</span>
			</h1>
			<p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
				Pelajari kaidah Nahwu, Shorof, dan Muhadatsah praktis lewat kurikulum materi video YouTube yang disusun berurutan, bertahap, dan mudah dipahami.
			</p>

			<div class="mt-8 flex flex-wrap justify-center gap-4">
				<a href="<?= site_url('courses') ?>" class="px-6 py-3 rounded-xl text-sm font-semibold text-white bg-brand-800 hover:bg-brand-900 shadow-md hover:shadow-lg transition-all">
					Jelajahi Semua Kelas
				</a>
				<?php if (empty($currentUser)): ?>
					<a href="<?= site_url('auth/register') ?>" class="px-6 py-3 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 shadow-sm transition-all">
						Daftar Akun Baru
					</a>
				<?php else: ?>
					<a href="<?= site_url('my-courses') ?>" class="px-6 py-3 rounded-xl text-sm font-semibold text-brand-800 bg-brand-100 hover:bg-brand-200 border border-brand-300 transition-all">
						Buka Kelas Saya
					</a>
				<?php endif; ?>
			</div>
		</div>

		<!-- 3 Benefit Pillars -->
		<div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
			<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
				<div class="w-12 h-12 rounded-xl bg-brand-100 text-brand-800 flex items-center justify-center font-bold text-xl mb-4">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
				</div>
				<h3 class="text-base font-bold text-slate-900">Kurikulum Video Terarah</h3>
				<p class="mt-2 text-sm text-slate-600 leading-relaxed">
					Setiap kelas memiliki daftar video YouTube yang disusun sistematis agar Anda tidak bingung harus mulai belajar dari mana.
				</p>
			</div>

			<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
				<div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xl mb-4">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
				</div>
				<h3 class="text-base font-bold text-slate-900">Pemantauan Progres Belajar</h3>
				<p class="mt-2 text-sm text-slate-600 leading-relaxed">
					Tandai materi yang sudah selesai dipelajari. Pantau persentase kemajuan belajar Anda di setiap kelas secara realtime.
				</p>
			</div>

			<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
				<div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xl mb-4">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
				</div>
				<h3 class="text-base font-bold text-slate-900">Kelas Gratis & Berbayar</h3>
				<p class="mt-2 text-sm text-slate-600 leading-relaxed">
					Ikuti kelas gratis langsung tanpa biaya, atau ambil kelas berbayar intensif dengan proses verifikasi pembayaran cepat.
				</p>
			</div>
		</div>
	</div>
</section>

<!-- Course Catalog Section -->
<section class="py-12 lg:py-16">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
			<div>
				<h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Katalog Kelas Pilihan</h2>
				<p class="mt-1 text-sm text-slate-500">Pilih materi yang ingin Anda kuasai hari ini</p>
			</div>

			<!-- Filter tabs -->
			<div class="inline-flex p-1 bg-slate-200/80 rounded-xl text-xs font-semibold">
				<a href="<?= site_url('/') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= empty($currentType) ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
					Semua
				</a>
				<a href="<?= site_url('/?type=free') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= $currentType === 'free' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
					Gratis
				</a>
				<a href="<?= site_url('/?type=paid') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= $currentType === 'paid' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
					Berbayar
				</a>
			</div>
		</div>

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
									Lihat Kelas &rarr;
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
				<h3 class="text-base font-bold text-slate-800">Belum ada kelas pada kategori ini</h3>
				<p class="text-sm text-slate-500 mt-1">Silakan pilih kategori lain atau kembali ke beranda.</p>
				<a href="<?= site_url('/') ?>" class="mt-4 inline-block px-4 py-2 text-xs font-semibold text-brand-700 bg-brand-50 rounded-lg">Lihat Semua Kelas</a>
			</div>
		<?php endif; ?>
	</div>
</section>
