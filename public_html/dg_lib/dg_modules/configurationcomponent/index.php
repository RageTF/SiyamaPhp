<?php

/**
 * @author mrhard
 * @copyright 2010
 */

defined("CONTENT") or die ("ERR");

    $comp = new mycomp($this->_Q,$this);
    $comp->_inblock = true;
    $comp->_comp = $param[1];
    $comp->_tpl = $param[2];
    $comp->_page = $param[0];
    $comp->_totalobject = $param[3];
    $comp->connect();

?>