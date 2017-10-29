<?php

namespace Sokil\IsoCodes\HistoricCurrencies;

class Currency extends \Sokil\IsoCodes\AbstractDatabaseEntry
{
    public $letter_code;
    
    public $numeric_code;
    
    public $currency_name;
    
    public function getLetterCode()
    {
        return $this->letter_code;
    }
    
    public function getNumericCode()
    {
        return $this->numeric_code;
    }
    
    public function getName()
    {
        return $this->currency_name;
    }
    
    public function getLocalName()
    {
        return dgettext($this->_database->getIso(), $this->currency_name);
    }
}
