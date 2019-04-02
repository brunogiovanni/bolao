<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-danger alert-dismissible" data-dismiss="alert" onclick="this.classList.add('hidden');"><?= $message ?></div>
