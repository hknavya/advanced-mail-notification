<?php
/**
Module Name : Mail Template
Description:This template uses mustache library to render the variables used and creates a html template.
Author Name: Navya H.K
**/

$m = new Mustache();
/*renders the mail subject and mail body using mustache library.*/
$subject = $m->render($mailSubject,$vars);
$bodyHTML = $m->render($mailTemplate,$vars);