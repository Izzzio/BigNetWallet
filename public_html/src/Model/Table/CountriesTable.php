<?php

namespace App\Model\Table;

class CountriesTable extends AppTable
{
    public function initialize(array $config)
    {
        $this->hasOne(UsersTable::getAlias(), [
            'foreignKey' => 'alpha_3',
            'bindingKey' => 'name_en'
        ]);
    }
}