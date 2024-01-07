<?php

use Lite\Database\DB;
use Lite\Database\Migration\IMigration;

return new class implements IMigration
{
    public function up()
    {
        DB::statement("
            CREATE TABLE USERS(
                ID SERIAL PRIMARY KEY,
                name VARCHAR(256),
                email VARCHAR(256),
                password VARCHAR(256),
                created_at timestamp NULL,
                updated_at timestamp NULL
            ); 
        ");
    }
    public function down()
    {
        DB::statement("DROP TABLE USERS;");
    }
};
