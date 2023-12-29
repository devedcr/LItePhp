<?php
namespace Lite\Database\Migration;

interface IMigration
{
    public function up();
    public function down();
}
