<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-8">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
		<!-- Header -->
		<div>
			<a href="<?= site_url('admin/courses') ?>" class="text-xs font-semibold text-brand-700 hover:text-brand-800 flex items-center gap-1 mb-2">
				&larr; Kembali ke Daftar Kelas
			</a>
			<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
				<div>
					<span class="text-xs font-semibold px-2.5 py-0.5 rounded-full <?= $course->type === 'free' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' ?>">
						<?= $course->type === 'free' ? 'Kelas Gratis' : 'Kelas Berbayar' ?>
					</span>
					<h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
						Kelola Materi Video: <?= html_escape($course->title) ?>
					</h1>
					<p class="text-xs text-slate-500 mt-0.5">Input URL video YouTube, tentukan nomor urut, dan berikan deskripsi materi</p>
				</div>

				<a href="<?= site_url('course/' . $course->slug) ?>" target="_blank" class="text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 px-3 py-2 rounded-xl self-start sm:self-auto flex items-center gap-1 shadow-sm">
					Lihat Halaman Kelas &nearr;
				</a>
			</div>
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
			<!-- Left: Form Add Lesson -->
			<div class="lg:col-span-1">
				<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-24">
					<h3 class="text-base font-bold text-slate-900 mb-1">Tambah Video Materi</h3>
					<p class="text-xs text-slate-500 mb-5">Tambahkan tautan video YouTube ke kurikulum kelas ini</p>

					<?= form_open('admin/lessons/create/' . $course->id, array('class' => 'space-y-4')) ?>
						<div>
							<label for="title" class="block text-xs font-semibold text-slate-700 mb-1">
								Judul Materi <span class="text-rose-500">*</span>
							</label>
							<input type="text" id="title" name="title" required placeholder="Contoh: Bab 1: Mengenal Isim, Fi'il, dan Huruf" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-1 focus:ring-brand-600 focus:outline-none">
						</div>

						<div>
							<label for="youtube_url" class="block text-xs font-semibold text-slate-700 mb-1">
								URL / Link Video YouTube <span class="text-rose-500">*</span>
							</label>
							<input type="text" id="youtube_url" name="youtube_url" required placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-1 focus:ring-brand-600 focus:outline-none">
							<p class="mt-1 text-[11px] text-slate-400">Bisa link youtube.com, youtu.be, atau Video ID 11 karakter.</p>
						</div>

						<div>
							<label for="order_num" class="block text-xs font-semibold text-slate-700 mb-1">
								Nomor Urut Materi <span class="text-rose-500">*</span>
							</label>
							<input type="number" id="order_num" name="order_num" required value="<?= $nextOrderNum ?>" min="1" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-1 focus:ring-brand-600 focus:outline-none">
						</div>

						<div>
							<label for="description" class="block text-xs font-semibold text-slate-700 mb-1">
								Deskripsi / Catatan Singkat Materi
							</label>
							<textarea id="description" name="description" rows="3" placeholder="Poin penting atau ringkasan yang dipelajari pada video ini..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-1 focus:ring-brand-600 focus:outline-none"></textarea>
						</div>

						<div>
							<button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-brand-800 hover:bg-brand-900 transition-colors shadow-sm">
								+ Tambahkan Video ke Kelas
							</button>
						</div>
					<?= form_close() ?>
				</div>
			</div>

			<!-- Right: Table of Lessons -->
			<div class="lg:col-span-2">
				<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
					<div class="p-5 border-b border-slate-200 flex items-center justify-between">
						<div>
							<h3 class="text-base font-bold text-slate-900">Kurikulum Materi Kelas</h3>
							<p class="text-xs text-slate-500 mt-0.5">Total <?= count($lessons) ?> materi video terdaftar</p>
						</div>
					</div>

					<?php if (!empty($lessons)): ?>
						<div class="divide-y divide-slate-100">
							<?php foreach ($lessons as $l): ?>
								<div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition-colors">
									<div class="flex items-start gap-3.5 flex-1 min-w-0">
										<div class="w-8 h-8 rounded-xl bg-brand-50 text-brand-800 font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5 border border-brand-100">
											#<?= $l->order_num ?>
										</div>

										<div class="min-w-0 flex-1">
											<h4 class="text-sm font-bold text-slate-900 leading-snug">
												<?= html_escape($l->title) ?>
											</h4>
											<div class="flex items-center gap-2 mt-1 text-xs text-slate-500">
												<span class="font-mono bg-slate-100 px-1.5 py-0.5 rounded text-[11px] text-slate-700">ID: <?= html_escape($l->youtube_video_id) ?></span>
												<span>•</span>
												<a href="<?= html_escape($l->youtube_url) ?>" target="_blank" class="text-brand-700 hover:underline inline-flex items-center gap-0.5 text-[11px]">
													Buka YouTube &nearr;
												</a>
											</div>
											<?php if (!empty($l->description)): ?>
												<p class="text-xs text-slate-600 mt-1.5 line-clamp-2 leading-relaxed">
													<?= html_escape($l->description) ?>
												</p>
											<?php endif; ?>
										</div>
									</div>

									<!-- Actions: Edit & Delete -->
									<div class="flex items-center gap-2 self-end sm:self-center flex-shrink-0">
										<button type="button" onclick="document.getElementById('edit-lesson-modal-<?= $l->id ?>').classList.remove('hidden')" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
											Edit
										</button>
										<a href="<?= site_url('admin/lessons/delete/' . $l->id) ?>" onclick="return confirm('Hapus materi video ini?');" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 transition-colors">
											Hapus
										</a>
									</div>

									<!-- Edit Lesson Modal -->
									<div id="edit-lesson-modal-<?= $l->id ?>" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
										<div class="bg-white rounded-2xl max-w-lg w-full p-6 text-left shadow-xl space-y-4">
											<div class="flex items-center justify-between pb-3 border-b border-slate-100">
												<h4 class="text-base font-bold text-slate-900">Ubah Materi Video</h4>
												<button type="button" onclick="document.getElementById('edit-lesson-modal-<?= $l->id ?>').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
											</div>

											<?= form_open('admin/lessons/edit/' . $l->id, array('class' => 'space-y-4')) ?>
												<div>
													<label class="block text-xs font-semibold text-slate-700 mb-1">Judul Materi</label>
													<input type="text" name="title" required value="<?= html_escape($l->title) ?>" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-1 focus:ring-brand-600">
												</div>

												<div>
													<label class="block text-xs font-semibold text-slate-700 mb-1">URL / Link YouTube</label>
													<input type="text" name="youtube_url" required value="<?= html_escape($l->youtube_url) ?>" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-1 focus:ring-brand-600">
												</div>

												<div>
													<label class="block text-xs font-semibold text-slate-700 mb-1">Urutan Materi</label>
													<input type="number" name="order_num" required value="<?= $l->order_num ?>" min="1" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-1 focus:ring-brand-600">
												</div>

												<div>
													<label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Materi</label>
													<textarea name="description" rows="3" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-1 focus:ring-brand-600"><?= html_escape($l->description) ?></textarea>
												</div>

												<div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
													<button type="button" onclick="document.getElementById('edit-lesson-modal-<?= $l->id ?>').classList.add('hidden')" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200">Batal</button>
													<button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-brand-800 hover:bg-brand-900">Simpan Perubahan</button>
												</div>
											<?= form_close() ?>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<div class="p-12 text-center text-slate-500 text-sm">
							<svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
							Belum ada materi video pada kelas ini. Gunakan formulir di sebelah kiri untuk menambahkan materi video pertama.
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
