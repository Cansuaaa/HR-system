<?php
namespace App\Models;
use Yee\Yee;
use App\Interfaces\differentLanguages;

class AddNewWordInLanguagesModel implements differentLanguages
{

    public function addNewWord ($title ,$en, $bg) {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        $data = array(
            'titles' => $title,
            'en' => $en,
            'bg' => $bg
        );
        $db->insert('languages', $data);
    }

    public function getWords () {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        $result = $db->get('languages');
        $da =  count($result);
        $lang = $db->get('languages', $da);
        return $lang;
    }

    public function getData($lang) {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        $language = $db->get('languages');

        $keys = array();
        $valuesEn = array();
        $valuesBg = array();

        foreach ($language as $item) {
            array_push($keys, $item['titles']);
            array_push($valuesEn, $item['en']);
            array_push($valuesBg, $item['bg']);
        }

        $original = array_combine($keys, $valuesEn);

        if ($lang == 'en') {
            $data = array_combine($keys, $valuesEn);
        } else {
            $data = array_combine($keys, $valuesBg);
        }

        $newArray = array_filter($data, 'strlen');

        return array_merge($original, $newArray);
    }
}

