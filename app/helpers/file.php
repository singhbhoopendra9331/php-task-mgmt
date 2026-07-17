<?php

/**
 * Max upload size in bytes (10 MB).
 */
function file_max_size(): int
{
    return 10 * 1024 * 1024;
}

/**
 * Allowed MIME types from validations.
 *
 * @return string[]
 */
function file_allowed_mimes(): array
{
    static $mimes = null;

    if ($mimes === null) {
        $mimes = require ABS_PATH . '/app/Validations/file.php';
    }

    return $mimes;
}

/**
 * Absolute path to the uploads root.
 */
function file_upload_root(): string
{
    return ABS_PATH . '/storage/uploads';
}

/**
 * Validate an uploaded file from $_FILES.
 *
 * @return array{ok: true}|array{ok: false, error: string}
 */
function file_validate(array $file): array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'error' => 'No file was uploaded.'];
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'error' => 'Upload failed. Please try again.'];
    }

    if (!is_uploaded_file($file['tmp_name'] ?? '')) {
        return ['ok' => false, 'error' => 'Invalid upload.'];
    }

    $size = (int) ($file['size'] ?? 0);

    if ($size <= 0) {
        return ['ok' => false, 'error' => 'File is empty.'];
    }

    if ($size > file_max_size()) {
        return ['ok' => false, 'error' => 'File exceeds the 10 MB limit.'];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']) ?: '';

    if (!in_array($mime, file_allowed_mimes(), true)) {
        return ['ok' => false, 'error' => 'File type is not allowed.'];
    }

    return ['ok' => true];
}

/**
 * Store an uploaded file under storage/uploads/YYYY/MM/.
 *
 * @return array{ok: true, original_name: string, file_name: string, file_path: string, mime_type: string, extension: string, file_size: int}|array{ok: false, error: string}
 */
function file_store(array $file): array
{
    $validation = file_validate($file);

    if (!$validation['ok']) {
        return $validation;
    }

    $originalName = basename((string) $file['name']);
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if ($extension === '') {
        return ['ok' => false, 'error' => 'File must have an extension.'];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $relativeDir = date('Y/m');
    $destinationDir = file_upload_root() . '/' . $relativeDir;

    if (!is_dir($destinationDir) && !mkdir($destinationDir, 0755, true)) {
        return ['ok' => false, 'error' => 'Could not create upload directory.'];
    }

    $storedName = bin2hex(random_bytes(16)) . '.' . $extension;
    $absolutePath = $destinationDir . '/' . $storedName;
    $relativePath = $relativeDir . '/' . $storedName;

    if (!move_uploaded_file($file['tmp_name'], $absolutePath)) {
        return ['ok' => false, 'error' => 'Failed to save uploaded file.'];
    }

    return [
        'ok' => true,
        'original_name' => $originalName,
        'file_name' => $storedName,
        'file_path' => $relativePath,
        'mime_type' => $mime,
        'extension' => $extension,
        'file_size' => (int) $file['size'],
    ];
}

/**
 * Delete a stored file by relative path under storage/uploads.
 */
function file_delete(string $relativePath): bool
{
    $relativePath = ltrim(str_replace(['..', '\\'], '', $relativePath), '/');
    $absolutePath = file_upload_root() . '/' . $relativePath;

    if (!is_file($absolutePath)) {
        return false;
    }

    return unlink($absolutePath);
}

/**
 * Resolve absolute path for a stored relative path.
 */
function file_absolute_path(string $relativePath): string
{
    $relativePath = ltrim(str_replace(['..', '\\'], '', $relativePath), '/');

    return file_upload_root() . '/' . $relativePath;
}

/**
 * Human-readable file size.
 */
function file_format_size(int $bytes): string
{
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = 0;

    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }

    return round($bytes, 1) . ' ' . $units[$i];
}
