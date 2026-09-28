<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Opsi ini mengatur "guard" dan "password reset broker" default untuk
    | aplikasi Anda. Anda dapat mengubah default ini sesuai kebutuhan,
    | namun pengaturan ini sudah ideal untuk sebagian besar aplikasi.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Di sinilah kita mendaftarkan "guards" untuk Admin dan Siswa.
    | Guard bertugas memelihara sesi (session) user untuk setiap role.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Guard khusus Admin
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        // Guard khusus Siswa
        'siswa' => [
            'driver' => 'session',
            'provider' => 'siswas',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Provider mendefinisikan bagaimana data user (admin/siswa) diambil dari 
    | database. Kita menggunakan driver 'eloquent' dan mengarahkannya
    | ke Model yang sudah kita buat sebelumnya.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // Provider khusus Admin (menggunakan Model Admin)
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        // Provider khusus Siswa (menggunakan Model Siswa)
        'siswas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Siswa::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Konfigurasi ini mengatur fitur lupa password. Meskipun mungkin tidak
    | diuji di UKK, kita tetap mendaftarkannya agar struktur file valid.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],

        'siswas' => [
            'provider' => 'siswas',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Menentukan berapa detik sebelum konfirmasi password kedaluwarsa dan 
    | pengguna diminta memasukkan ulang password melalui layar konfirmasi.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];