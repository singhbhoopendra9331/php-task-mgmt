<?php
/** @var array $media */
/** @var string|null $error */
/** @var string|null $success */
?>

<section class="media-page">
    <p class="muted">Upload images, PDFs, Word docs, or ZIP archives (max 10 MB).</p>

    <?php if (!empty($error)): ?>
        <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="alert alert-success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form class="upload-form" action="/dashboard/media" method="post" enctype="multipart/form-data">
        <div class="field">
            <label for="file">File</label>
            <input type="file" id="file" name="file" required
                   accept=".jpg,.jpeg,.png,.webp,.pdf,.zip,.doc,.docx,image/jpeg,image/png,image/webp,application/pdf,application/zip,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
        </div>

        <div class="field">
            <label for="alt_text">Alt text (optional)</label>
            <input type="text" id="alt_text" name="alt_text" maxlength="255">
        </div>

        <div class="field">
            <label for="caption">Caption (optional)</label>
            <input type="text" id="caption" name="caption" maxlength="255">
        </div>

        <div class="field">
            <label for="task_id">Attach to task ID (optional)</label>
            <input type="number" id="task_id" name="task_id" min="1" placeholder="e.g. 1">
        </div>

        <button type="submit">Upload</button>
    </form>

    <h2>Uploaded files</h2>

    <?php if (empty($media)): ?>
        <p class="muted">No files uploaded yet.</p>
    <?php else: ?>
        <table class="media-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Uploaded</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($media as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['original_name']) ?></td>
                        <td><?= htmlspecialchars($item['mime_type']) ?></td>
                        <td><?= htmlspecialchars(file_format_size((int) $item['file_size'])) ?></td>
                        <td><?= htmlspecialchars($item['created_at']) ?></td>
                        <td class="actions">
                            <a href="/dashboard/media/<?= (int) $item['id'] ?>/download">Download</a>
                            <form action="/dashboard/media/<?= (int) $item['id'] ?>/delete" method="post" onsubmit="return confirm('Delete this file?');">
                                <button type="submit" class="link-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
