<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-8">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
		<!-- Header -->
		<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
			<div>
				<h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Verifikasi Transaksi Pembayaran</h1>
				<p class="mt-1 text-sm text-slate-500">Kelola dan konfirmasi bukti pembayaran kelas berbayar untuk membuka akses kelas santri</p>
			</div>

			<!-- Status Filter Tabs -->
			<div class="inline-flex p-1 bg-slate-200/80 rounded-xl text-xs font-semibold self-start sm:self-auto">
				<a href="<?= site_url('admin/transactions') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= empty($statusFilter) ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
					Semua
				</a>
				<a href="<?= site_url('admin/transactions?status=pending') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= $statusFilter === 'pending' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
					Menunggu Verifikasi
				</a>
				<a href="<?= site_url('admin/transactions?status=approved') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= $statusFilter === 'approved' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
					Disetujui
				</a>
				<a href="<?= site_url('admin/transactions?status=rejected') ?>" class="px-3.5 py-1.5 rounded-lg transition-colors <?= $statusFilter === 'rejected' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' ?>">
					Ditolak
				</a>
			</div>
		</div>

		<!-- Table -->
		<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-slate-200 text-left text-sm">
					<thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase tracking-wider">
						<tr>
							<th class="px-6 py-4">Kode Transaksi</th>
							<th class="px-6 py-4">Santri</th>
							<th class="px-6 py-4">Kelas</th>
							<th class="px-6 py-4">Nominal</th>
							<th class="px-6 py-4">Bukti Transfer</th>
							<th class="px-6 py-4">Status</th>
							<th class="px-6 py-4 text-right">Aksi Verifikasi</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-100">
						<?php if (!empty($transactions)): ?>
							<?php foreach ($transactions as $t): ?>
								<tr class="hover:bg-slate-50/70 transition-colors">
									<td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-bold text-slate-800">
										<?= html_escape($t->transaction_code) ?>
										<div class="text-[11px] font-normal text-slate-400 font-sans mt-0.5">
											<?= date('d M Y, H:i', strtotime($t->created_at)) ?>
										</div>
									</td>
									<td class="px-6 py-4">
										<div class="font-semibold text-slate-900"><?= html_escape($t->user_name) ?></div>
										<div class="text-xs text-slate-500"><?= html_escape($t->user_email) ?></div>
										<?php if (!empty($t->payment_notes)): ?>
											<div class="text-[11px] text-slate-600 bg-slate-50 p-1.5 rounded border border-slate-200 mt-1">
												Catatan: <?= html_escape($t->payment_notes) ?>
											</div>
										<?php endif; ?>
									</td>
									<td class="px-6 py-4 font-medium text-slate-800 text-xs">
										<?= html_escape($t->course_title) ?>
									</td>
									<td class="px-6 py-4 whitespace-nowrap font-extrabold text-slate-900">
										<?= format_rupiah($t->amount) ?>
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<?php if (!empty($t->payment_proof)): ?>
											<a href="<?= base_url('uploads/payments/' . $t->payment_proof) ?>" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold text-brand-800 bg-brand-50 hover:bg-brand-100 border border-brand-200">
												<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
												Lihat Bukti &nearr;
											</a>
										<?php else: ?>
											<span class="text-xs text-amber-600 font-medium italic">Belum diunggah</span>
										<?php endif; ?>
									</td>
									<td class="px-6 py-4 whitespace-nowrap">
										<?php if ($t->status === 'approved'): ?>
											<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
												<span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
												Disetujui
											</span>
											<?php if ($t->approved_at): ?>
												<div class="text-[10px] text-slate-400 mt-0.5">
													<?= date('d M Y, H:i', strtotime($t->approved_at)) ?>
												</div>
											<?php endif; ?>
										<?php elseif ($t->status === 'rejected'): ?>
											<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
												<span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
												Ditolak
											</span>
											<?php if (!empty($t->admin_notes)): ?>
												<div class="text-[11px] text-rose-600 mt-1 max-w-xs">
													Alasan: <?= html_escape($t->admin_notes) ?>
												</div>
											<?php endif; ?>
										<?php else: ?>
											<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
												<span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
												Menunggu Verifikasi
											</span>
										<?php endif; ?>
									</td>
									<td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
										<?php if ($t->status === 'pending'): ?>
											<a href="<?= site_url('admin/transactions/approve/' . $t->id) ?>" onclick="return confirm('Apakah Anda yakin ingin menyetujui transaksi ini dan mengaktifkan akses kelas santri?');" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-sm transition-colors">
												<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
												Setujui
											</a>
											<button type="button" onclick="document.getElementById('reject-modal-<?= $t->id ?>').classList.remove('hidden')" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition-colors">
												Tolak
											</button>

											<!-- Reject Modal -->
											<div id="reject-modal-<?= $t->id ?>" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
												<div class="bg-white rounded-2xl max-w-sm w-full p-6 text-left shadow-xl space-y-4">
													<h4 class="text-base font-bold text-slate-900">Tolak Pembayaran</h4>
													<p class="text-xs text-slate-500">Tuliskan alasan penolakan untuk santri:</p>
													<?= form_open('admin/transactions/reject/' . $t->id) ?>
														<textarea name="admin_notes" rows="3" placeholder="Contoh: Bukti transfer tidak terbaca / rekening tidak cocok" class="w-full text-xs p-2.5 border border-slate-300 rounded-xl focus:ring-1 focus:ring-rose-500 mb-4"></textarea>
														<div class="flex justify-end gap-2">
															<button type="button" onclick="document.getElementById('reject-modal-<?= $t->id ?>').classList.add('hidden')" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200">Batal</button>
															<button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-rose-600 hover:bg-rose-700">Tolak Transaksi</button>
														</div>
													<?= form_close() ?>
												</div>
											</div>
										<?php else: ?>
											<span class="text-xs text-slate-400">Selesai</span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="7" class="px-6 py-8 text-center text-slate-500 text-sm">
									Tidak ada riwayat transaksi pembayaran.
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
