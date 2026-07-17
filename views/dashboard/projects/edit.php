<?php
/** @var array $project */
/** @var array $statuses */
/** @var string|null $error */

$action = '/dashboard/projects/' . (int) $project['id'];
$submitLabel = 'Save Changes';

require __DIR__ . '/form.php';
