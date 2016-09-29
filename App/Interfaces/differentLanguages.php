<?php
namespace  App\Interfaces;

interface differentLanguages
{
    public function addNewWord($title, $en, $bg);
    public function getWords();
    public function getData($lang);
}