<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('comment', function (Blueprint $table) {
            // บางเครื่องชื่อคีย์อาจต่างกัน ลองดรอปแบบป้องกันข้อผิดพลาด
            $connection = Schema::getConnection();
            $sm = $connection->getDoctrineSchemaManager();
            $doctrineTable = $sm->introspectTable($connection->getTablePrefix() . 'comment');

            $dropIfExists = function (string $fkName) use ($table, $doctrineTable) {
                foreach ($doctrineTable->getForeignKeys() as $fk) {
                    if ($fk->getName() === $fkName) {
                        $table->dropForeign($fkName);
                        return;
                    }
                }
            };

            // คีย์ที่น่าจะมีจากข้อความ error
            $dropIfExists('comment_phone_info_comment_foreign');
            $dropIfExists('cm_id2');

            // ดรอป foreign key ใด ๆ ที่ผูกกับ column commentable_id (กันเหนียว)
            foreach ($doctrineTable->getForeignKeys() as $fk) {
                $local = array_map('strtolower', $fk->getLocalColumns());
                if (in_array('commentable_id', $local, true)) {
                    $table->dropForeign($fk->getName());
                }
            }
        });
    }

    public function down(): void
    {
        // ไม่สร้าง FK กลับ เพราะ polymorphic ไม่ควรมี FK
    }
};


