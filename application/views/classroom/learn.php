<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Top Classroom Header Bar -->
<header class="bg-slate-900 text-white border-b border-slate-800 sticky top-0 z-40">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex items-center justify-between h-16">
			<!-- Back Link & Course Title -->
			<div class="flex items-center gap-4 min-w-0">
				<a href="<?= site_url('my-courses') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 px-3 py-1.5 rounded-lg border border-slate-700 transition-colors flex-shrink-0">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
					<span class="hidden sm:inline">Kelas Saya</span>
				</a>
				<div class="min-w-0">
					<span class="text-xs text-brand-400 font-semibold uppercase tracking-wider block leading-tight">Ruang Belajar</span>
					<h1 class="text-sm sm:text-base font-bold text-white truncate leading-tight">
						<?= html_escape($course->title) ?>
					</h1>
				</div>
			</div>

			<!-- Course Progress Display -->
			<div class="flex items-center gap-3 flex-shrink-0">
				<div class="hidden sm:flex flex-col text-right">
					<span class="text-xs font-semibold text-slate-200" id="progress-text">Progres: <?= $progressPercent ?>%</span>
					<span class="text-[10px] text-slate-400"><?= count($completedIds) ?> dari <?= count($lessons) ?> selesai</span>
				</div>
				<div class="w-20 sm:w-28 bg-slate-800 rounded-full h-2 overflow-hidden border border-slate-700">
					<div id="progress-bar-fill" class="bg-brand-500 h-2 rounded-full transition-all duration-300" style="width: <?= $progressPercent ?>%"></div>
				</div>
			</div>
		</div>
	</div>
</header>

<main class="flex-1 bg-slate-950 py-6">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
			<!-- Left / Main: Video Player & Details -->
			<div class="lg:col-span-2 space-y-5">
				<!-- 16:9 Video Embed Player -->
				<div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-black shadow-2xl border border-slate-800">
					<?php if (!empty($currentLesson->youtube_video_id)): ?>
						<iframe 
							class="w-full h-full" 
							src="<?= youtube_embed_url($currentLesson->youtube_video_id) ?>" 
							title="<?= html_escape($currentLesson->title) ?>" 
							frameborder="0" 
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
							allowfullscreen>
						</iframe>
					<?php else: ?>
						<div class="flex items-center justify-center h-full text-slate-500 text-sm">
							Video tidak ditemukan atau URL YouTube tidak valid.
						</div>
					<?php endif; ?>
				</div>

				<!-- Action Controls & Title -->
				<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 text-white shadow-sm space-y-4">
					<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
						<div>
							<span class="inline-block px-2.5 py-0.5 rounded text-xs font-semibold bg-brand-900 text-brand-300 border border-brand-700/50 mb-1.5">
								Materi Ke-<?= $currentLesson->order_num ?>
							</span>
							<h2 class="text-lg sm:text-xl font-bold text-white leading-snug">
								<?= html_escape($currentLesson->title) ?>
							</h2>
						</div>

						<!-- Mark as Completed Button -->
						<div>
							<?= form_open('learn/toggle-progress/' . $course->id . '/' . $currentLesson->id, array('id' => 'progress-form')) ?>
								<button type="submit" id="btn-toggle-progress" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm <?= $isCurrentLessonCompleted ? 'bg-emerald-600 hover:bg-emerald-700 text-white ring-2 ring-emerald-500/50' : 'bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700' ?>">
									<?php if ($isCurrentLessonCompleted): ?>
										<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
										<span>Selesai Dipelajari</span>
									<?php else: ?>
										<svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
										<span>Tandai Selesai</span>
									<?php endif; ?>
								</button>
							<?= form_close() ?>
						</div>
					</div>

					<!-- Navigation (Prev / Next) -->
					<div class="flex items-center justify-between pt-1">
						<?php if ($prevLesson): ?>
							<a href="<?= site_url('learn/' . $course->id . '/' . $prevLesson->id) ?>" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 bg-slate-800 hover:bg-slate-700 hover:text-white transition-colors">
								&larr; <span class="hidden sm:inline">Materi Sebelumnya</span><span class="sm:hidden">Sebelumnya</span>
							</a>
						<?php else: ?>
							<span class="text-xs text-slate-600 px-3.5 py-2">&larr; Awal Materi</span>
						<?php endif; ?>

						<?php if ($nextLesson): ?>
							<a href="<?= site_url('learn/' . $course->id . '/' . $nextLesson->id) ?>" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-brand-700 hover:bg-brand-600 transition-colors shadow-sm">
								<span class="hidden sm:inline">Materi Selanjutnya</span><span class="sm:hidden">Selanjutnya</span> &rarr;
							</a>
						<?php else: ?>
							<span class="text-xs text-emerald-400 font-semibold px-3.5 py-2 flex items-center gap-1">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
								Materi Terakhir
							</span>
						<?php endif; ?>
					</div>

					<!-- Description / Notes -->
					<?php if (!empty($currentLesson->description)): ?>
						<div class="mt-4 pt-4 border-t border-slate-800 text-xs sm:text-sm text-slate-300 leading-relaxed">
							<h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Catatan Pembelajaran:</h4>
							<p><?= nl2br(html_escape($currentLesson->description)) ?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Right: Sidebar Playlist Navigation -->
			<div class="lg:col-span-1">
				<div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-sm sticky top-24 flex flex-col max-h-[calc(100vh-8rem)]">
					<div class="p-4 bg-slate-800/80 border-b border-slate-700/80 flex items-center justify-between">
						<div>
							<h3 class="text-sm font-bold text-white">Daftar Materi Video</h3>
							<p class="text-xs text-slate-400 mt-0.5"><?= count($lessons) ?> Video Terstruktur</p>
						</div>
						<span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-700 text-slate-300">
							<?= count($completedIds) ?>/<?= count($lessons) ?>
						</span>
					</div>

					<!-- Scrollable Lesson List -->
					<div class="divide-y divide-slate-800/80 overflow-y-auto flex-1">
						<?php foreach ($lessons as $lesson): ?>
							<?php 
								$isActive = ((int)$lesson->id === (int)$currentLesson->id);
								$isDone = in_array((int)$lesson->id, $completedIds);
							?>
							<a href="<?= site_url('learn/' . $course->id . '/' . $lesson->id) ?>" class="p-3.5 flex items-start gap-3 transition-colors <?= $isActive ? 'bg-brand-950/70 border-l-4 border-brand-500' : 'hover:bg-slate-800/50' ?>">
								<!-- Status Checkmark / Order -->
								<div class="flex-shrink-0 mt-0.5">
									<?php if ($isDone): ?>
										<div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center border border-emerald-500/40">
											<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
										</div>
									<?php else: ?>
										<div class="w-6 h-6 rounded-full bg-slate-800 text-slate-400 text-xs font-semibold flex items-center justify-center border border-slate-700">
											<?= $lesson->order_num ?>
										</div>
									<?php endif; ?>
								</div>

								<!-- Info -->
								<div class="flex-1 min-w-0">
									<div class="flex items-center gap-1.5">
										<h5 class="text-xs font-semibold leading-snug <?= $isActive ? 'text-brand-300 font-bold' : 'text-slate-300' ?>">
											<?= html_escape($lesson->title) ?>
										</h5>
									</div>
									<div class="flex items-center gap-2 text-[11px] text-slate-500 mt-1">
										<span>Video YouTube</span>
										<?php if ($isActive): ?>
											<span class="text-brand-400 font-semibold">• Sedang Diputar</span>
										<?php endif; ?>
									</div>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
