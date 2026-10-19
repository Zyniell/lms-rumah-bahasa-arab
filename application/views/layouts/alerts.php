<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
	<?php if ($this->session->flashdata('success')): ?>
		<div class="flex items-center p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm" role="alert">
			<svg class="flex-shrink-0 inline w-5 h-5 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
			<div>
				<span class="font-semibold">Berhasil!</span> <?= $this->session->flashdata('success') ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="flex items-center p-4 mb-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 shadow-sm" role="alert">
			<svg class="flex-shrink-0 inline w-5 h-5 mr-3 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
			<div>
				<span class="font-semibold">Perhatian:</span> <?= $this->session->flashdata('error') ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('warning')): ?>
		<div class="flex items-center p-4 mb-4 text-sm text-amber-800 rounded-xl bg-amber-50 border border-amber-200 shadow-sm" role="alert">
			<svg class="flex-shrink-0 inline w-5 h-5 mr-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
			<div>
				<span class="font-semibold">Informasi:</span> <?= $this->session->flashdata('warning') ?>
			</div>
		</div>
	<?php endif; ?>
</div>
