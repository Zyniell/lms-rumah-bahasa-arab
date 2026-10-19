<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-8">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
		<!-- Welcome Header -->
		<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
			<div>
				<h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Pengelola</h1>
				<p class="mt-1 text-sm text-slate-500">Ringkasan aktivitas, kelas, dan transaksi LMS Rumah Bahasa Arab</p>
			</div>

			<div class="flex items-center gap-3">
				<a href="<?= site_url('admin/courses/create') ?>" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-brand-800 hover:bg-brand-900 shadow-sm transition-colors">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
					Tambah Kelas Baru
				</a>
			</div>
		</div>

		<!-- 4 Metrics Overview Cards -->
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
			<!-- Total Courses -->
			<div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
				<div>
					<span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Kelas</span>
					<span class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 block"><?= $totalCourses ?></span>
					<a href="<?= site_url('admin/courses') ?>" class="text-xs text-brand-700 hover:underline mt-1 inline-block">Lihat semua kelas &rarr;</a>
				</div>
				<div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
				</div>
			</div>

			<!-- Total Students -->
			<div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
				<div>
					<span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Santri</span>
					<span class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 block"><?= $totalStudents ?></span>
					<a href="<?= site_url('admin/students') ?>" class="text-xs text-brand-700 hover:underline mt-1 inline-block">Lihat data santri &rarr;</a>
				</div>
				<div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
				</div>
			</div>

			<!-- Pending Transactions -->
			<div class="bg-white p-5 rounded-2xl border <?= $pendingTransactions > 0 ? 'border-amber-300 ring-2 ring-amber-200' : 'border-slate-200' ?> shadow-sm flex items-center justify-between">
				<div>
					<span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Menunggu Verifikasi</span>
					<span class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1 block"><?= $pendingTransactions ?></span>
					<a href="<?= site_url('admin/transactions?status=pending') ?>" class="text-xs text-amber-700 font-semibold hover:underline mt-1 inline-block">Proses verifikasi &rarr;</a>
				</div>
				<div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
				</div>
			</div>

			<!-- Total Active Enrollments -->
			<div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
				<div>
					<span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Akses Kelas Aktif</span>
					<span class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 block"><?= $totalEnrollments ?></span>
					<span class="text-xs text-slate-400 mt-1 block">Peserta di seluruh kelas</span>
				</div>
				<div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
				</div>
			</div>
		</div>

		<!-- Pending Transactions Queue -->
		<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
			<div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
				<div>
					<h3 class="text-base font-bold text-slate-900">Antrean Verifikasi Pembayaran</h3>
					<p class="text-xs text-slate-500 mt-0.5">Transaksi berbayar yang memerlukan konfirmasi bukti transfer</p>
				</div>
				<a href="<?= site_url('admin/transactions') ?>" class="text-xs font-semibold text-brand-700 hover:text-brand-800">
					Lihat Semua Transaksi &rarr;
				</a>
			</div>

			<?php if (!empty($recentPending)): ?>
				<div class="overflow-x-auto">
					<table class="min-w-full divide-y divide-slate-200 text-left text-sm">
						<thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
							<tr>
								<th class="px-6 py-3.5">Kode</th>
								<th class="px-6 py-3.5">Santri</th>
								<th class="px-6 py-3.5">Kelas</th>
								<th class="px-6 py-3.5">Nominal</th>
								<th class="px-6 py-3.5">Bukti Transfer</th>
								<th class="px-6 py-3.5 text-right">Aksi Verifikasi</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-100">
							<?php foreach ($recentPending as $trx): ?>
								<tr class="hover:bg-slate-50/70 transition-colors">
									<td class="px-6 py-4 font-mono text-xs font-bold text-slate-800">
										<?= html_escape($trx->transaction_code) ?>
									</td>
									<td class="px-6 py-4">
										<div class="font-semibold text-slate-900 text-sm"><?= html_escape($trx->user_name) ?></div>
										<div class="text-xs text-slate-500"><?= html_escape($trx->user_email) ?></div>
									</td>
									<td class="px-6 py-4 font-medium text-slate-800 text-xs">
										<?= html_escape($trx->course_title) ?>
									</td>
									<td class="px-6 py-4 font-extrabold text-slate-900 text-sm">
										<?= format_rupiah($trx->amount) ?>
									</td>
									<td class="px-6 py-4">
										<?php if (!empty($trx->payment_proof)): ?>
											<a href="<?= base_url('uploads/payments/' . $trx->payment_proof) ?>" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-200">
												<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
												Lihat Bukti &nearr;
											</a>
										<?php else: ?>
											<span class="text-xs text-slate-400 italic">Belum diunggah</span>
										<?php endif; ?>
									</td>
									<td class="px-6 py-4 text-right space-x-2">
										<a href="<?= site_url('admin/transactions/approve/' . $trx->id) ?>" onclick="return confirm('Setujui transaksi ini dan aktifkan akses kelas untuk santri?');" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-sm transition-colors">
											<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
											Setujui (Approve)
										</a>
										<button type="button" onclick="document.getElementById('reject-modal-<?= $trx->id ?>').classList.remove('hidden')" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition-colors">
											Tolak
										</button>

										<!-- Reject Modal -->
										<div id="reject-modal-<?= $trx->id ?>" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
											<div class="bg-white rounded-2xl max-w-sm w-full p-6 text-left shadow-xl space-y-4">
												<h4 class="text-base font-bold text-slate-900">Tolak Pembayaran</h4>
												<p class="text-xs text-slate-500">Masukkan alasan penolakan agar santri dapat mengetahui hal yang perlu diperbaiki.</p>
												<?= form_open('admin/transactions/reject/' . $trx->id) ?>
													<textarea name="admin_notes" rows="3" placeholder="Contoh: Bukti transfer buram / nominal tidak sesuai" class="w-full text-xs p-2.5 border border-slate-300 rounded-xl focus:ring-1 focus:ring-rose-500 mb-4"></textarea>
													<div class="flex justify-end gap-2">
														<button type="button" onclick="document.getElementById('reject-modal-<?= $trx->id ?>').classList.add('hidden')" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200">Batal</button>
														<button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-rose-600 hover:bg-rose-700">Konfirmasi Tolak</button>
													</div>
												<?= form_close() ?>
											</div>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php else: ?>
				<div class="p-8 text-center text-slate-500 text-sm">
					<svg class="w-8 h-8 text-emerald-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
					Tidak ada transaksi pembayaran yang menunggu verifikasi saat ini.
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
