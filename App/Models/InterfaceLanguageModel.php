<?php
namespace App\Models;

class InterfaceLanguageModel
{
    public function Languages()
    {
        return $table = array(
            "us" => array(
                'title' => "welcome",
                "content" => "My name is Damyan",
            ),
            "bg" => array(
                "title" => "Здравейте",
                "content" => "Казвам се Дамян"
            )
        );
    }
}