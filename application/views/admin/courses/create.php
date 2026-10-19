<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="py-8">
	<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="mb-6">
			<a href="<?= site_url('admin/courses') ?>" class="text-xs font-semibold text-brand-700 hover:text-brand-800 flex items-center gap-1 mb-2">
				&larr; Kembali ke Daftar Kelas
			</a>
			<h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Kelas Baru</h1>
			<p class="text-sm text-slate-500">Buat kelas bahasa Arab dan atur akses gratis atau berbayar</p>
		</div>

		<div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
			<?= form_open_multipart('admin/courses/create', array('class' => 'space-y-6')) ?>
				<div>
					<label for="title" class="block text-sm font-semibold text-slate-700 mb-1">Judul Kelas <span class="text-rose-500">*</span></label>
					<input type="text" id="title" name="title" required value="<?= set_value('title') ?>" placeholder="Contoh: Dasar-Dasar Nahwu & Shorof untuk Pemula" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm">
					<?= form_error('title', '<p class="mt-1 text-xs text-rose-600">', '</p>') ?>
				</div>

				<div>
					<label for="description" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi & Pengantar Kelas</label>
					<textarea id="description" name="description" rows="4" placeholder="Jelaskan silabus, materi yang akan dipelajari, dan target capaian santri..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm"><?= set_value('description') ?></textarea>
					<?= form_error('description', '<p class="mt-1 text-xs text-rose-600">', '</p>') ?>
				</div>

				<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
					<div>
						<label class="block text-sm font-semibold text-slate-700 mb-1">Tipe Kelas <span class="text-rose-500">*</span></label>
						<select id="type" name="type" onchange="togglePriceInput(this.value)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-sm bg-white">
							<option value="free" <?= set_select('type', 'free', true) ?>>Gratis (Free)</option>
							<option value="paid" <?= set_select('type', 'paid') ?>>Berbayar (Paid)</option>
						</select>
					</div>

					<div id="price-container" class="<?= set_value('type') === 'paid' ? '' : 'hidden' ?>">
						<label for="price" class="block text-sm font-semibold text-slate-700 mb-1">Harga Kelas (Rp) <span class="text-rose-500">*</span></label>
						<input type="number" id="price" name="price" value="<?= set_value('price', '0') ?>" min="0" step="1000" placeholder="150000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-sm">
						<?= form_error('price', '<p class="mt-1 text-xs text-rose-600">', '</p>') ?>
					</div>
				</div>

				<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
					<div>
						<label class="block text-sm font-semibold text-slate-700 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
						<select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-600 text-sm bg-white">
							<option value="published" <?= set_select('status', 'published', true) ?>>Publikasikan Sekarang (Published)</option>
							<option value="draft" <?= set_select('status', 'draft') ?>>Simpan Sebagai Draf (Draft)</option>
						</select>
					</div>

					<div>
						<label for="thumbnail" class="block text-sm font-semibold text-slate-700 mb-1">Gambar Banner / Thumbnail (Opsional)</label>
						<input type="file" id="thumbnail" name="thumbnail" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-800 hover:file:bg-slate-200 border border-slate-300 rounded-xl p-1.5">
					</div>
				</div>

				<div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
					<a href="<?= site_url('admin/courses') ?>" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
						Batal
					</a>
					<button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand-800 hover:bg-brand-900 shadow-sm transition-colors">
						Simpan & Lanjut ke Materi Video &rarr;
					</button>
				</div>
			<?= form_close() ?>
		</div>
	</div>
</div>

<script>
	function togglePriceInput(val) {
		const container = document.getElementById('price-container');
		if (val === 'paid') {
			container.classList.remove('hidden');
		} else {
			container.classList.add('hidden');
		}
	}
</script>
