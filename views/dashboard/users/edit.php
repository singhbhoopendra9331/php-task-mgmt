<?php
/** @var array $user */
/** @var array $roles */
/** @var string|null $error */

$action = '/dashboard/users/' . (int) $user['id'];
$submitLabel = 'Save Changes';
$cancelUrl = '/dashboard/users/' . (int) $user['id'];

require __DIR__ . '/form.php';
