<?php
session_start();
$_SESSION['review_prompt_shown'] = true;
http_response_code(204); // No content
exit();
