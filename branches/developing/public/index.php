<?php
/**
 * Created on 4 lut 2014 09:26:54
 * @author Tomasz Gajewski
 * @package frontoffice
 * error prefix
 *
 */
include "../include/common.php";

Perms::openPage();
$d = new WebControler();
$d->doAction();
?>