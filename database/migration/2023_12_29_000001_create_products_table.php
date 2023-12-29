<?php

use Lite\Database\DB;
use Lite\Database\Migration\IMigration;

return new class implements IMigration
{
    public function up()
    {
        DB::statement("
            CREATE TABLE PRODUCTS(
                ID INT PRIMARY KEY,
                NAME VARCHAR(255)           
            );
        ");
    }
    public function down()
    {
    }
};
