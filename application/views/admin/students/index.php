<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-8">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
		<!-- Header -->
		<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
			<div>
				<h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Peserta & Santri</h1>
				<p class="mt-1 text-sm text-slate-500">Pantau data santri terdaftar dan keikutsertaan kelas bahasa Arab</p>
			</div>

			<!-- Course Filter -->
			<div>
				<form method="get" action="<?= site_url('admin/students') ?>" class="flex items-center gap-2">
					<label for="course_id" class="text-xs font-semibold text-slate-700 whitespace-nowrap">Filter Kelas:</label>
					<select id="course_id" name="course_id" onchange="this.form.submit()" class="text-xs px-3 py-2 rounded-xl border border-slate-300 bg-white focus:ring-1 focus:ring-brand-600">
						<option value="">Semua Santri Terdaftar</option>
						<?php foreach ($courses as $c): ?>
							<option value="<?= $c->id ?>" <?= ($selectedCourse && $selectedCourse->id == $c->id) ? 'selected' : '' ?>>
								<?= html_escape($c->title) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</form>
			</div>
		</div>

		<?php if ($selectedCourse): ?>
			<div class="p-4 rounded-xl bg-brand-50 border border-brand-200 text-xs text-brand-900 flex items-center justify-between">
				<div>
					Menampilkan santri terdaftar untuk kelas: <strong><?= html_escape($selectedCourse->title) ?></strong> (<?= count($students) ?> Santri)
				</div>
				<a href="<?= site_url('admin/students') ?>" class="text-brand-700 font-semibold hover:underline">Hapus Filter &times;</a>
			</div>
		<?php endif; ?>

		<!-- Table -->
		<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-slate-200 text-left text-sm">
					<thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
						<tr>
							<th class="px-6 py-4">Nama Santri</th>
							<th class="px-6 py-4">Alamat Email</th>
							<?php if ($selectedCourse): ?>
								<th class="px-6 py-4">Tanggal Bergabung Kelas</th>
								<th class="px-6 py-4">Status Akses</th>
							<?php else: ?>
								<th class="px-6 py-4">Total Kelas Diikuti</th>
								<th class="px-6 py-4">Tanggal Registrasi</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-100">
						<?php if (!empty($students)): ?>
							<?php foreach ($students as $s): ?>
								<tr class="hover:bg-slate-50/70 transition-colors">
									<td class="px-6 py-4 font-bold text-slate-900">
										<div class="flex items-center gap-3">
											<div class="w-8 h-8 rounded-full bg-brand-100 text-brand-800 font-bold text-xs flex items-center justify-center">
												<?= strtoupper(substr($s->name, 0, 1)) ?>
											</div>
											<span><?= html_escape($s->name) ?></span>
										</div>
									</td>
									<td class="px-6 py-4 text-slate-600 text-xs font-mono">
										<?= html_escape($s->email) ?>
									</td>
									<?php if ($selectedCourse): ?>
										<td class="px-6 py-4 text-xs text-slate-500">
											<?= date('d M Y, H:i', strtotime($s->enrolled_at)) ?>
										</td>
										<td class="px-6 py-4">
											<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
												<span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
												Aktif
											</span>
										</td>
									<?php else: ?>
										<td class="px-6 py-4 font-semibold text-slate-800 text-xs">
											<?= $s->total_enrolled ?> Kelas
										</td>
										<td class="px-6 py-4 text-xs text-slate-500">
											<?= date('d M Y', strtotime($s->created_at)) ?>
										</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm">
									Belum ada santri terdaftar pada filter ini.
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
