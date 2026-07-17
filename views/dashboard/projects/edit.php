<?php
/** @var array $project */
/** @var array $statuses */
/** @var string|null $error */

$action = '/dashboard/projects/' . (int) $project['id'];
$submitLabel = 'Save Changes';
$cancelUrl = '/dashboard/projects/' . (int) $project['id'];

require __DIR__ . '/form.php';
