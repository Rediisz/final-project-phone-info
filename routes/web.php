<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/test-user', function () {
    $products = DB::table('user')->get();  // ดึงข้อมูลทั้งหมดจากตาราง user
    return $products;  // จะได้เป็น array ว่าง [] ถ้ายังไม่มีข้อมูล
});

