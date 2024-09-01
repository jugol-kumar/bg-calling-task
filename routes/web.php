<?php
Illuminate\Support\Facades\Route::view('/{any}', 'app')->where('any', '.*');