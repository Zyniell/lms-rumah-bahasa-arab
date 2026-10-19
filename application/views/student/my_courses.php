<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-10">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Header -->
		<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
			<div>
				<h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Kelas Saya</h1>
				<p class="mt-1 text-sm text-slate-500">Daftar kelas bahasa Arab yang sedang Anda ikuti</p>
			</div>

			<a href="<?= site_url('courses') ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition-colors self-start sm:self-auto">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
				Jelajahi Kelas Baru
			</a>
		</div>

		<?php if (!empty($courses)): ?>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php foreach ($courses as $c): ?>
					<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
						<!-- Card Top -->
						<div>
							<div class="h-32 bg-gradient-to-br from-brand-900 via-brand-800 to-slate-900 p-5 flex flex-col justify-between text-white relative">
								<div class="flex justify-between items-start">
									<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold <?= $c->type === 'free' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-500/20 text-amber-300' ?>">
										<?= $c->type === 'free' ? 'Gratis' : 'Berbayar' ?>
									</span>
									<span class="text-xs text-brand-200 font-medium">Terdaftar: <?= date('d M Y', strtotime($c->enrolled_at)) ?></span>
								</div>
								<h3 class="text-base font-bold text-white line-clamp-2 leading-snug">
									<?= html_escape($c->title) ?>
								</h3>
							</div>

							<div class="p-5">
								<!-- Progress Bar -->
								<div class="mb-4">
									<div class="flex justify-between text-xs font-medium text-slate-600 mb-1.5">
										<span>Progres Belajar</span>
										<span class="font-bold text-slate-900"><?= $c->progress_percent ?>%</span>
									</div>
									<div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
										<div class="bg-brand-600 h-2 rounded-full transition-all duration-300" style="width: <?= $c->progress_percent ?>%"></div>
									</div>
									<p class="text-xs text-slate-400 mt-1.5">
										<?= $c->completed_lessons ?> dari <?= $c->total_lessons ?> materi selesai dipelajari
									</p>
								</div>
							</div>
						</div>

						<!-- Card Bottom Action -->
						<div class="p-5 pt-0">
							<a href="<?= site_url('learn/' . $c->id) ?>" class="w-full py-2.5 px-4 rounded-xl text-xs font-semibold text-center block text-white bg-brand-800 hover:bg-brand-900 shadow-sm transition-colors">
								<?= $c->progress_percent > 0 ? 'Lanjut Belajar &rarr;' : 'Mulai Belajar Sekarang &rarr;' ?>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-lg mx-auto">
				<div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center mx-auto mb-4">
					<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
				</div>
				<h3 class="text-lg font-bold text-slate-900">Belum Ada Kelas yang Diikuti</h3>
				<p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">
					Anda belum terdaftar di kelas manapun. Ikuti kelas gratis atau pesan kelas berbayar untuk mulai belajar.
				</p>
				<div class="mt-6">
					<a href="<?= site_url('courses') ?>" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand-800 hover:bg-brand-900 shadow-sm transition-colors">
						Lihat Katalog Kelas
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
