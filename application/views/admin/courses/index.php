<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-8">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
		<!-- Header -->
		<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
			<div>
				<h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Kelas Bahasa Arab</h1>
				<p class="mt-1 text-sm text-slate-500">Daftar kelas, pengaturan harga, serta kurikulum materi video</p>
			</div>

			<a href="<?= site_url('admin/courses/create') ?>" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-brand-800 hover:bg-brand-900 shadow-sm transition-colors self-start sm:self-auto">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
				Tambah Kelas Baru
			</a>
		</div>

		<!-- Table -->
		<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-slate-200 text-left text-sm">
					<thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
						<tr>
							<th class="px-6 py-4">Judul Kelas</th>
							<th class="px-6 py-4">Tipe & Harga</th>
							<th class="px-6 py-4">Materi Video</th>
							<th class="px-6 py-4">Peserta</th>
							<th class="px-6 py-4">Status</th>
							<th class="px-6 py-4 text-right">Aksi</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-100">
						<?php if (!empty($courses)): ?>
							<?php foreach ($courses as $c): ?>
								<tr class="hover:bg-slate-50/70 transition-colors">
									<td class="px-6 py-4">
										<div class="font-bold text-slate-900 text-sm"><?= html_escape($c->title) ?></div>
										<div class="text-xs text-slate-500 mt-0.5 max-w-md line-clamp-1"><?= html_escape($c->description) ?></div>
										<a href="<?= site_url('course/' . $c->slug) ?>" target="_blank" class="text-[11px] text-brand-700 hover:underline mt-1 inline-flex items-center gap-0.5">
											Pratinjau Halaman Kelas &nearr;
										</a>
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold <?= $c->type === 'free' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' ?>">
											<?= $c->type === 'free' ? 'Gratis' : 'Berbayar' ?>
										</span>
										<div class="text-xs font-bold text-slate-800 mt-1">
											<?= format_rupiah($c->price) ?>
										</div>
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<a href="<?= site_url('admin/courses/' . $c->id . '/lessons') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition-colors">
											<svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
											<?= $c->total_lessons ?> Video (Kelola)
										</a>
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-xs text-slate-600 font-medium">
										<?= $c->total_students ?> Santri
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<span class="inline-block px-2.5 py-0.5 rounded text-xs font-semibold <?= $c->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' ?>">
											<?= $c->status === 'published' ? 'Publik' : 'Draft' ?>
										</span>
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
										<a href="<?= site_url('admin/courses/edit/' . $c->id) ?>" class="text-xs font-semibold text-slate-700 hover:text-brand-800 bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 rounded-lg transition-colors">
											Edit
										</a>
										<a href="<?= site_url('admin/courses/delete/' . $c->id) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini beserta seluruh materi video di dalamnya?');" class="text-xs font-semibold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-2.5 py-1.5 rounded-lg transition-colors">
											Hapus
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="6" class="px-6 py-8 text-center text-slate-500 text-sm">
									Belum ada kelas yang dibuat. Silakan tambahkan kelas pertama Anda.
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
