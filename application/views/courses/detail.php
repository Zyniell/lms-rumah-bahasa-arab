<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-10">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Breadcrumb -->
		<div class="flex items-center gap-2 text-xs font-semibold text-brand-700 uppercase tracking-wider mb-6">
			<a href="<?= site_url('/') ?>" class="hover:underline">Beranda</a> &rsaquo; 
			<a href="<?= site_url('courses') ?>" class="hover:underline">Katalog</a> &rsaquo; 
			<span class="text-slate-500 truncate max-w-xs sm:max-w-md"><?= html_escape($course->title) ?></span>
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
			<!-- Main Left Column: Info & Syllabus -->
			<div class="lg:col-span-2 space-y-8">
				<!-- Header Box -->
				<div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
					<div class="flex items-center gap-2 mb-3">
						<span class="px-3 py-1 rounded-full text-xs font-semibold <?= $course->type === 'free' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' ?>">
							<?= $course->type === 'free' ? 'Kelas Gratis' : 'Kelas Berbayar' ?>
						</span>
						<span class="text-xs text-slate-400">•</span>
						<span class="text-xs text-slate-500 font-medium"><?= count($lessons) ?> Materi Video</span>
					</div>

					<h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
						<?= html_escape($course->title) ?>
					</h1>

					<div class="mt-4 prose prose-slate max-w-none text-slate-600 leading-relaxed text-sm sm:text-base">
						<p><?= nl2br(html_escape($course->description)) ?></p>
					</div>
				</div>

				<!-- Curriculum / Syllabus Box -->
				<div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
					<div class="flex items-center justify-between mb-6">
						<div>
							<h2 class="text-lg font-bold text-slate-900">Kurikulum & Materi Pembelajaran</h2>
							<p class="text-xs text-slate-500 mt-0.5">Daftar video YouTube terstruktur yang akan Anda pelajari</p>
						</div>
						<span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700">
							<?= count($lessons) ?> Bab
						</span>
					</div>

					<?php if (!empty($lessons)): ?>
						<div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
							<?php foreach ($lessons as $index => $lesson): ?>
								<div class="p-4 hover:bg-slate-50/80 transition-colors flex items-start gap-4">
									<div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-800 font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5 border border-brand-100">
										<?= $lesson->order_num ?>
									</div>
									<div class="flex-1 min-w-0">
										<h4 class="text-sm font-semibold text-slate-900 leading-tight">
											<?= html_escape($lesson->title) ?>
										</h4>
										<?php if (!empty($lesson->description)): ?>
											<p class="text-xs text-slate-500 mt-1 leading-relaxed">
												<?= html_escape($lesson->description) ?>
											</p>
										<?php endif; ?>
									</div>
									<div class="flex-shrink-0 flex items-center text-xs text-slate-400 gap-1.5 self-center">
										<svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
										<span>Video</span>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<p class="text-sm text-slate-500 italic p-4 text-center bg-slate-50 rounded-xl">Materi pembelajaran sedang dipersiapkan oleh pengajar.</p>
					<?php endif; ?>
				</div>
			</div>

			<!-- Right Column: Enrollment Card -->
			<div class="lg:col-span-1">
				<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-24 space-y-6">
					<!-- Visual Thumbnail / Banner -->
					<div class="h-36 rounded-xl bg-gradient-to-br from-brand-900 to-slate-900 flex items-center justify-center text-white relative overflow-hidden">
						<span class="font-arabic text-6xl opacity-15">لغة</span>
						<div class="relative z-10 text-center px-4">
							<span class="text-xs font-semibold px-2.5 py-0.5 rounded-full <?= $course->type === 'free' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-500/20 text-amber-300' ?>">
								<?= $course->type === 'free' ? 'Gratis 100%' : 'Program Berbayar' ?>
							</span>
							<p class="text-xs text-slate-300 mt-2 font-medium">Platform LMS Rumah Bahasa Arab</p>
						</div>
					</div>

					<!-- Pricing Display -->
					<div class="pb-4 border-b border-slate-100">
						<span class="text-xs text-slate-400 block">Biaya Investasi Belajar:</span>
						<div class="text-2xl sm:text-3xl font-extrabold <?= $course->type === 'free' ? 'text-emerald-700' : 'text-slate-900' ?>">
							<?= format_rupiah($course->price) ?>
						</div>
						<?php if ($course->type === 'paid'): ?>
							<span class="text-xs text-slate-500 mt-1 block">Akses penuh selamanya ke semua materi video bab ini.</span>
						<?php endif; ?>
					</div>

					<!-- Dynamic Action CTA -->
					<div>
						<?php if ($isEnrolled): ?>
							<div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 font-medium mb-3 flex items-center gap-2">
								<svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
								<span>Anda sudah terdaftar di kelas ini!</span>
							</div>
							<a href="<?= site_url('learn/' . $course->id) ?>" class="w-full py-3 px-4 rounded-xl text-sm font-semibold text-white bg-brand-800 hover:bg-brand-900 text-center block shadow-sm transition-colors">
								Buka Ruang Belajar &rarr;
							</a>
						<?php elseif ($course->type === 'free'): ?>
							<a href="<?= site_url('course/enroll-free/' . $course->id) ?>" class="w-full py-3 px-4 rounded-xl text-sm font-semibold text-white bg-emerald-700 hover:bg-emerald-800 text-center block shadow-sm transition-colors">
								Ikuti Kelas Gratis Sekarang
							</a>
						<?php elseif ($course->type === 'paid'): ?>
							<?php if ($pendingTransaction): ?>
								<div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800 font-medium mb-3">
									<p class="font-bold">Pesanan Anda Sedang Diproses</p>
									<p class="mt-0.5">Silakan selesaikan pembayaran & unggah bukti transfer.</p>
								</div>
								<a href="<?= site_url('checkout/' . $course->id) ?>" class="w-full py-3 px-4 rounded-xl text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 text-center block shadow-sm transition-colors">
									Lanjut ke Pembayaran &rarr;
								</a>
							<?php else: ?>
								<a href="<?= site_url('checkout/' . $course->id) ?>" class="w-full py-3 px-4 rounded-xl text-sm font-semibold text-white bg-brand-800 hover:bg-brand-900 text-center block shadow-sm transition-colors">
									Beli Kelas Sekarang
								</a>
							<?php endif; ?>
						<?php endif; ?>
					</div>

					<!-- Feature checklist -->
					<div class="pt-4 border-t border-slate-100 text-xs text-slate-600 space-y-2.5">
						<div class="flex items-center gap-2">
							<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
							<span>Materi video YouTube berkualitas & terstruktur</span>
						</div>
						<div class="flex items-center gap-2">
							<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
							<span>Pelacakan progres materi secara interaktif</span>
						</div>
						<div class="flex items-center gap-2">
							<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
							<span>Akses belajar fleksibel kapan saja</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
