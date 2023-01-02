<?php

namespace App\Interface;

interface InterfaceAPIREST{
    public function insere($array);
    public function busca($id);
    public function atualiza($id, $array);
    public function deleta($id);
}
