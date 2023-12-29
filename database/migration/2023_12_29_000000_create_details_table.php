<?php

use Lite\Database\DB;
use Lite\Database\Migration\IMigration;

new class implements IMigration
{
    public function up()
    {
        DB::statement("
            CREATE TABLE DETAILS(
                ID INT PRIMARY KEY
            );
        ");
    }
    public function down()
    {
    }
};
