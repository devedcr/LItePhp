<?php

namespace Lite\Database\Migration;

use PhpParser\Node\Expr\Print_;

class Migrator
{
    private int $id;

    public function __construct(
        private string $directionCreate,
        private string $directionTemplate,
    ) {
        $this->directionCreate = $directionCreate;
        $this->directionTemplate = $directionTemplate;
        $this->id = 0;
    }

    public function make(string $commnad)
    {

        if (preg_match("/create_(.*)_table/", $commnad, $matches)) {
            $file = file_get_contents("$this->directionTemplate/Migration.php");
            $file = str_replace("@table", strtoupper($matches[1]), $file);
            file_put_contents("$this->directionCreate/{$this->generate_id()}_{$matches[0]}.php", $file);
            return;
        }
        if (preg_match("/(add|remove)_(.*)_(to|from)_(.*)_table/", $commnad, $matches)) {
            return;
        }
    }

    public function generate_id()
    {
        $this->id = count(glob("$this->directionCreate/*.php"));
        $date = date("Y_m_d");
        $number_secuence = $this->id;
        while (strlen($number_secuence) < 6)
            $number_secuence = "0" . $number_secuence;

        return "{$date}_{$number_secuence}";
    }
}
