<?php

use Lite\Database\DB;
use Lite\Database\Migration\IMigration;

return new class implements IMigration
{
    public function up()
    {
        DB::statement("
            CREATE TABLE COMPANIES(
                ID INT PRIMARY KEY
            );
        ");
    }
    public function down()
    {
        DB::statement("DROP TABLE COMPANIES;");
    }
};
