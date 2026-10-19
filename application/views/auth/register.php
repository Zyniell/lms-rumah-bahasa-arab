<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
	<div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-2xl shadow-sm border border-slate-200">
		<div class="text-center">
			<div class="w-12 h-12 rounded-2xl bg-brand-800 text-white flex items-center justify-center font-bold text-2xl mx-auto shadow-sm">
				<span class="font-arabic">ض</span>
			</div>
			<h2 class="mt-4 text-2xl font-bold text-slate-900 tracking-tight">
				Daftar Siswa Baru
			</h2>
			<p class="mt-1.5 text-sm text-slate-500">
				Mulai perjalanan belajar bahasa Arab Anda hari ini
			</p>
		</div>

		<?= form_open('auth/register', array('class' => 'mt-8 space-y-4')) ?>
			<div>
				<label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
				<input id="name" name="name" type="text" required value="<?= set_value('name') ?>" placeholder="Fulan bin Fulan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm text-slate-900 transition-colors shadow-sm">
				<?= form_error('name', '<p class="mt-1 text-xs text-rose-600">', '</p>') ?>
			</div>

			<div>
				<label for="email" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email</label>
				<input id="email" name="email" type="email" autocomplete="email" required value="<?= set_value('email') ?>" placeholder="nama@email.com" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm text-slate-900 transition-colors shadow-sm">
				<?= form_error('email', '<p class="mt-1 text-xs text-rose-600">', '</p>') ?>
			</div>

			<div>
				<label for="password" class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi (Min. 6 Karakter)</label>
				<input id="password" name="password" type="password" autocomplete="new-password" required placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm text-slate-900 transition-colors shadow-sm">
				<?= form_error('password', '<p class="mt-1 text-xs text-rose-600">', '</p>') ?>
			</div>

			<div>
				<label for="password_confirm" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
				<input id="password_confirm" name="password_confirm" type="password" autocomplete="new-password" required placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm text-slate-900 transition-colors shadow-sm">
				<?= form_error('password_confirm', '<p class="mt-1 text-xs text-rose-600">', '</p>') ?>
			</div>

			<div class="pt-2">
				<button type="submit" class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-brand-800 hover:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-700 transition-colors shadow-sm">
					Daftar Akun Sekarang
				</button>
			</div>
		<?= form_close() ?>

		<div class="text-center pt-2">
			<p class="text-sm text-slate-500">
				Sudah memiliki akun?
				<a href="<?= site_url('auth/login') ?>" class="font-semibold text-brand-700 hover:text-brand-800">
					Masuk di sini
				</a>
			</p>
		</div>
	</div>
</div>
