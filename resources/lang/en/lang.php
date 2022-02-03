<?php

return [
    'default' => [
        'form-request' => 'Validasyon işleminiz başarısız',
        'unauthorization' => 'Lütfen öncelikle giriş yapınız.',
    ],
    'validation' => [
        'name' => 'Ad',
        'surname' => 'Soyad',
        'email' => 'Mail Adresi',
        'password' => 'Şifre',
        'token' => "Doğrulama kodu"
    ],
    'login' => [
        'response-message' => 'Giriş başarısız!',
        'no-matching-account-found' => 'Eşleşen hesap bulunamadı!',
        'successful' => 'Giriş başarılı!',
    ],
    'register' => [
        'response-message' => 'Kayıt başarısız!',
    ],
    'reset-password' => [
        'response-message' => 'Şifre sıfırlama isteği gönderimi başarısız!',
        'user-not-found' => 'Eşleşen bir hesap bulunamadı!',
        'successful' => 'Parola sıfırlama isteğiniz başarıyla gönderilmiştir, lütfen gelen kutunuzu kontrol edin',
    ],
    'mail' => [
        'forgot-password' => [
            'subject' => 'Parolamı Unuttum',
        ],
    ],
    'reset-password-token' => [
        'response-message' => 'Şifre sıfırlama işlemi başarısız!',
        'expired' => 'Tokenin süresi dolmuştur',
        'successful' => 'Parolanız başarıyla sıfırlanmıştır.',
        'invalid-token' => 'Geçersiz token girildi!'
    ],
    'check-reset-password-token' => [
        'response-message' => 'Geçersiz token!',
        'expired' => 'Tokenin süresi dolmuştur',
        'invalid-token' => 'Geçersiz token girildi!',
        'successful' => 'Token kullanılabilir!'
    ],
];
