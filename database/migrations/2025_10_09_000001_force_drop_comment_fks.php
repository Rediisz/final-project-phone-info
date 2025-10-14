<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // หาและดรอป FK ใด ๆ ที่โยงกับตาราง comment บนคอลัมน์ commentable_id
        $db = DB::getDatabaseName();

        $constraints = DB::select(<<<SQL
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = ?
              AND TABLE_NAME = 'comment'
              AND COLUMN_NAME = 'commentable_id'
              AND REFERENCED_TABLE_NAME IS NOT NULL
        SQL, [$db]);

        foreach ($constraints as $row) {
            $name = $row->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE `comment` DROP FOREIGN KEY `{$name}`");
        }

        // กันเหนียว: ถ้ามีคีย์ตามชื่อใน error ก็ลองดรอปอีกครั้ง (ไม่ error ถ้าไม่มี)
        try { DB::statement('ALTER TABLE `comment` DROP FOREIGN KEY `comment_phone_info_comment_foreign`'); } catch (\Throwable $e) {}
        try { DB::statement('ALTER TABLE `comment` DROP FOREIGN KEY `cm_id2`'); } catch (\Throwable $e) {}
    }

    public function down(): void
    {
        // ไม่สร้าง FK กลับ เพราะ polymorphic ไม่ควรมี FK
    }
};


