<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
* Classe RechercheTAG
* Classe utilisé pour la recherche de tag
*
*/

class RechercheTAG
{

    private $tag;


    public function settag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    public function gettag()
    {
        return $this->tag;
    }

    public function getSearch()
    {
        return $this->tag;
    }
}
?>
