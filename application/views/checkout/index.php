<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-10">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Header -->
		<div class="mb-8">
			<a href="<?= site_url('course/' . $course->slug) ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 hover:text-brand-800 mb-3">
				&larr; Kembali ke Detail Kelas
			</a>
			<h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Checkout Pembelian Kelas</h1>
			<p class="mt-1 text-sm text-slate-500">Selesaikan pembayaran untuk mengaktifkan akses kelas Anda</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-5 gap-8">
			<!-- Left: Order Summary & Bank Instructions -->
			<div class="md:col-span-3 space-y-6">
				<!-- Order Summary -->
				<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
					<h3 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">
						Rincian Pesanan
					</h3>
					
					<div class="flex items-start gap-4">
						<div class="w-16 h-16 rounded-xl bg-brand-800 text-white flex items-center justify-center font-bold text-xl flex-shrink-0">
							<span class="font-arabic text-2xl">ع</span>
						</div>
						<div class="flex-1 min-w-0">
							<span class="text-xs font-semibold px-2 py-0.5 rounded bg-amber-100 text-amber-800">Kelas Berbayar</span>
							<h4 class="text-base font-bold text-slate-900 mt-1 leading-snug">
								<?= html_escape($course->title) ?>
							</h4>
							<p class="text-xs text-slate-500 mt-0.5">Kode Transaksi: <strong class="text-slate-700"><?= html_escape($transaction->transaction_code) ?></strong></p>
						</div>
					</div>

					<div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
						<span class="text-sm text-slate-600">Total Tagihan:</span>
						<span class="text-xl font-extrabold text-slate-900"><?= format_rupiah($transaction->amount) ?></span>
					</div>
				</div>

				<!-- Bank Transfer Instructions -->
				<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
					<h3 class="text-base font-bold text-slate-900 mb-2">Instruksi Pembayaran Manual</h3>
					<p class="text-xs text-slate-500 mb-4">Silakan transfer tepat sebesar nominal di atas ke salah satu rekening berikut:</p>

					<div class="space-y-3">
						<div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
							<div>
								<span class="text-xs font-bold text-brand-800 uppercase tracking-wider block">Bank Syariah Indonesia (BSI)</span>
								<span class="text-base font-mono font-bold text-slate-900 block mt-0.5">7123 4567 890</span>
								<span class="text-xs text-slate-500">a.n. Rumah Bahasa Arab LMS</span>
							</div>
							<span class="px-2.5 py-1 rounded bg-brand-100 text-brand-800 text-xs font-semibold">Utama</span>
						</div>

						<div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
							<div>
								<span class="text-xs font-bold text-blue-800 uppercase tracking-wider block">Bank Central Asia (BCA)</span>
								<span class="text-base font-mono font-bold text-slate-900 block mt-0.5">8020 1234 567</span>
								<span class="text-xs text-slate-500">a.n. Rumah Bahasa Arab LMS</span>
							</div>
							<span class="px-2.5 py-1 rounded bg-slate-200 text-slate-700 text-xs font-semibold">Alternatif</span>
						</div>
					</div>

					<div class="mt-4 text-xs text-slate-500 bg-amber-50 p-3 rounded-xl border border-amber-200">
						💡 <strong>Catatan:</strong> Setelah melakukan transfer, silakan unggah foto atau tangkapan layar bukti transfer pada formulir di samping agar Admin dapat segera mengaktifkan akses kelas Anda.
					</div>
				</div>
			</div>

			<!-- Right: Upload Proof Form -->
			<div class="md:col-span-2">
				<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-24">
					<h3 class="text-base font-bold text-slate-900 mb-1">Konfirmasi Pembayaran</h3>
					<p class="text-xs text-slate-500 mb-5">Unggah bukti transfer untuk verifikasi</p>

					<?php if (!empty($transaction->payment_proof)): ?>
						<div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800">
							<p class="font-bold flex items-center gap-1.5">
								<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
								Bukti telah diunggah!
							</p>
							<p class="mt-1 text-emerald-700">Status saat ini: <strong>Menunggu Verifikasi Admin</strong>.</p>
							<a href="<?= base_url('uploads/payments/' . $transaction->payment_proof) ?>" target="_blank" class="mt-2 inline-flex items-center gap-1 text-brand-800 font-semibold underline">
								Lihat bukti yang diunggah &nearr;
							</a>
						</div>
					<?php endif; ?>

					<?= form_open_multipart('checkout/submit/' . $transaction->transaction_code, array('class' => 'space-y-4')) ?>
						<div>
							<label for="payment_proof" class="block text-xs font-semibold text-slate-700 mb-1">
								Pilih File Bukti Transfer <span class="text-rose-500">*</span>
							</label>
							<input type="file" id="payment_proof" name="payment_proof" required accept=".jpg,.jpeg,.png,.webp,.pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-800 hover:file:bg-brand-100 border border-slate-300 rounded-xl p-1.5 focus:outline-none focus:ring-1 focus:ring-brand-600">
							<p class="mt-1 text-xs text-slate-400">Format: JPG, PNG, WEBP, PDF (Maks. 2MB)</p>
						</div>

						<div>
							<label for="payment_notes" class="block text-xs font-semibold text-slate-700 mb-1">
								Catatan Pembayaran (Opsional)
							</label>
							<textarea id="payment_notes" name="payment_notes" rows="3" placeholder="Contoh: Transfer via BSI atas nama Fulan" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-600 text-slate-900"><?= set_value('payment_notes', $transaction->payment_notes) ?></textarea>
						</div>

						<div>
							<button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-brand-800 hover:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-700 transition-colors shadow-sm">
								<?= !empty($transaction->payment_proof) ? 'Unggah Ulang Bukti' : 'Kirim Bukti Pembayaran' ?>
							</button>
						</div>
					<?= form_close() ?>

					<div class="mt-4 pt-4 border-t border-slate-100 text-center">
						<a href="<?= site_url('my-transactions') ?>" class="text-xs text-slate-500 hover:text-slate-800">
							Lihat Semua Riwayat Transaksi &rarr;
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
