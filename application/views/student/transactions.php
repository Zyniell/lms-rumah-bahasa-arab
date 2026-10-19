<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-10">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Header -->
		<div class="mb-8">
			<h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Transaksi</h1>
			<p class="mt-1 text-sm text-slate-500">Daftar pembelian kelas berbayar dan status verifikasi pembayaran Anda</p>
		</div>

		<?php if (!empty($transactions)): ?>
			<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
				<div class="overflow-x-auto">
					<table class="min-w-full divide-y divide-slate-200 text-left text-sm">
						<thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
							<tr>
								<th scope="col" class="px-6 py-4">Kode Transaksi</th>
								<th scope="col" class="px-6 py-4">Kelas</th>
								<th scope="col" class="px-6 py-4">Nominal</th>
								<th scope="col" class="px-6 py-4">Tanggal</th>
								<th scope="col" class="px-6 py-4">Status</th>
								<th scope="col" class="px-6 py-4 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-100">
							<?php foreach ($transactions as $t): ?>
								<tr class="hover:bg-slate-50/60 transition-colors">
									<td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-semibold text-slate-800">
										<?= html_escape($t->transaction_code) ?>
									</td>
									<td class="px-6 py-4">
										<div class="font-semibold text-slate-900"><?= html_escape($t->course_title) ?></div>
										<?php if (!empty($t->payment_proof)): ?>
											<span class="text-xs text-brand-700 flex items-center gap-1 mt-0.5">
												<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
												Bukti transfer terunggah
											</span>
										<?php else: ?>
											<span class="text-xs text-amber-600 flex items-center gap-1 mt-0.5">
												<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
												Belum unggah bukti
											</span>
										<?php endif; ?>
									</td>
									<td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900">
										<?= format_rupiah($t->amount) ?>
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
										<?= date('d M Y, H:i', strtotime($t->created_at)) ?>
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<?php if ($t->status === 'approved'): ?>
											<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
												<span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
												Disetujui / Aktif
											</span>
										<?php elseif ($t->status === 'rejected'): ?>
											<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
												<span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
												Ditolak
											</span>
											<?php if (!empty($t->admin_notes)): ?>
												<p class="text-xs text-rose-600 mt-1 max-w-xs"><?= html_escape($t->admin_notes) ?></p>
											<?php endif; ?>
										<?php else: ?>
											<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
												<span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
												Menunggu Verifikasi
											</span>
										<?php endif; ?>
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-right">
										<?php if ($t->status === 'approved'): ?>
											<a href="<?= site_url('learn/' . $t->course_id) ?>" class="px-3 py-1.5 rounded-lg text-xs font-bold text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition-colors">
												Buka Kelas &rarr;
											</a>
										<?php else: ?>
											<a href="<?= site_url('checkout/' . $t->course_id) ?>" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 transition-colors">
												Detail & Bukti
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php else: ?>
			<div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-md mx-auto">
				<div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
				</div>
				<h3 class="text-base font-bold text-slate-800">Belum ada riwayat transaksi</h3>
				<p class="text-sm text-slate-500 mt-1">Anda belum melakukan pemesanan kelas berbayar.</p>
				<a href="<?= site_url('courses') ?>" class="mt-4 inline-block px-4 py-2 text-xs font-semibold text-brand-700 bg-brand-50 rounded-lg">Pilih Kelas Berbayar</a>
			</div>
		<?php endif; ?>
	</div>
</div>
