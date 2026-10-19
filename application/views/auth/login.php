<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
	<div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-2xl shadow-sm border border-slate-200">
		<div class="text-center">
			<div class="w-12 h-12 rounded-2xl bg-brand-800 text-white flex items-center justify-center font-bold text-2xl mx-auto shadow-sm">
				<span class="font-arabic">ض</span>
			</div>
			<h2 class="mt-4 text-2xl font-bold text-slate-900 tracking-tight">
				Masuk ke Akun Anda
			</h2>
			<p class="mt-1.5 text-sm text-slate-500">
				Belajar bahasa Arab dengan kurikulum video terstruktur
			</p>
		</div>

		<?= form_open('auth/login', array('class' => 'mt-8 space-y-5')) ?>
			<div>
				<label for="email" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email</label>
				<input id="email" name="email" type="email" autocomplete="email" required value="<?= set_value('email') ?>" placeholder="nama@email.com" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm text-slate-900 transition-colors shadow-sm">
				<?= form_error('email', '<p class="mt-1 text-xs text-rose-600">', '</p>') ?>
			</div>

			<div>
				<label for="password" class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi</label>
				<input id="password" name="password" type="password" autocomplete="current-password" required placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm text-slate-900 transition-colors shadow-sm">
				<?= form_error('password', '<p class="mt-1 text-xs text-rose-600">', '</p>') ?>
			</div>

			<div>
				<button type="submit" class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-brand-800 hover:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-700 transition-colors shadow-sm">
					Masuk Sekarang
				</button>
			</div>
		<?= form_close() ?>

		<!-- Demo Accounts Helper Box -->
		<div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-1.5">
			<div class="font-semibold text-slate-700 flex items-center gap-1.5">
				<svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
				Akun Bawaan Demo:
			</div>
			<div>• <strong>Admin:</strong> <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200">admin@rumahbahasaarab.com</code> / <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200">admin123</code></div>
			<div>• <strong>Santri:</strong> <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200">santri@rumahbahasaarab.com</code> / <code class="bg-white px-1.5 py-0.5 rounded border border-slate-200">santri123</code></div>
		</div>

		<div class="text-center pt-2">
			<p class="text-sm text-slate-500">
				Belum memiliki akun?
				<a href="<?= site_url('auth/register') ?>" class="font-semibold text-brand-700 hover:text-brand-800">
					Daftar di sini
				</a>
			</p>
		</div>
	</div>
</div>
