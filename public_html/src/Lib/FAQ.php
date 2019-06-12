<?php

namespace App\Lib;


use App\Model\Table\FaqTable;
use Cake\Filesystem\Folder;

class FAQ
{
    public static function get()
    {
        $langs = (new Folder(ROOT . '/src/Locale'))->read()[0];

        $basisFAQ = FaqTable::f()->order(['id'=>'DESC'])->hydrate(false)->toArray();


        foreach ($basisFAQ as &$faq) {
            foreach ($langs as $lang) {
                if ($lang === \Cake\Core\Configure::read('App.defaultLocale')) {
                    continue;
                }

                if ($lang !== \Cake\I18n\I18n::locale()) {
                    continue;
                }
                $aKey = $lang . '_' . $faq['id'] . '_a';
                $qKey = $lang . '_' . $faq['id'] . '_q';

                if (empty(KeyValue::read($qKey))) {
                    continue;
                }

                $faq['a'] = KeyValue::read($aKey);
                $faq['q'] = KeyValue::read($qKey);
            }
        }

        return $basisFAQ;
    }
}