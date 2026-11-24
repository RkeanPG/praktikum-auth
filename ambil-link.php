<?php
// Mengambil tautan terakhir dari log email. Contoh: php ambil-link.php reset-password
$pola = $argv[1] ?? 'reset-password';
$log = quoted_printable_decode(file_get_contents(__DIR__ . '/storage/logs/laravel.log'));
preg_match_all('~https?://[^\s"<>\)\]]*' . preg_quote($pola, '~') . '[^\s"<>\)\]]*~', $log, $m);
echo (end($m[0]) ?: 'Tautan tidak ditemukan'), PHP_EOL;