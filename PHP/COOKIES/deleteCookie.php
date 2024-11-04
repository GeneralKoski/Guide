<?php
// Imposto il tempo al passato e setto il nome del cookie = al passato in modo che scada
$tempo = time() - 3600;
setcookie('numberOfVists', '', $tempo);
setcookie('numberOfVisits', '', $tempo);
setcookie('visitCookiePage', '', $tempo);