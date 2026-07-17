<?php
/** @var array $media */
/** @var string|null $error */
/** @var string|null $success */
?>

<section class="space-y-6">
    <p class="text-slate-500">Upload images, PDFs, Word docs, or ZIP archives (max 10 MB).</p>

    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="alert-success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form id="upload-form" class="card grid gap-4" action="/dashboard/media" method="post" enctype="multipart/form-data">
        <div class="grid gap-1.5">
            <label class="label" for="file">File</label>
            <input class="input" type="file" id="file" name="file" required
                   accept=".jpg,.jpeg,.png,.webp,.pdf,.zip,.doc,.docx,image/jpeg,image/png,image/webp,application/pdf,application/zip,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
            <p id="file-name" class="text-sm text-slate-500">No file chosen</p>
        </div>

        <div class="grid gap-1.5">
            <label class="label" for="alt_text">Alt text (optional)</label>
            <input class="input" type="text" id="alt_text" name="alt_text" maxlength="255">
        </div>

        <div class="grid gap-1.5">
            <label class="label" for="caption">Caption (optional)</label>
            <input class="input" type="text" id="caption" name="caption" maxlength="255">
        </div>

        <div class="grid gap-1.5">
            <label class="label" for="task_id">Attach to task ID (optional)</label>
            <input class="input" type="number" id="task_id" name="task_id" min="1" placeholder="e.g. 1">
        </div>

        <button class="btn justify-self-start" type="submit">Upload</button>
    </form>

    <div>
        <h2 class="mb-3 text-lg font-semibold">Uploaded files</h2>

        <?php if (empty($media)): ?>
            <p class="text-slate-500">No files uploaded yet.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="data-table">
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
                                <td>
                                    <div class="flex items-center gap-3">
                                        <a class="font-medium text-brand hover:underline" href="/dashboard/media/<?= (int) $item['id'] ?>/download">Download</a>
                                        <form action="/dashboard/media/<?= (int) $item['id'] ?>/delete" method="post" data-confirm="Delete this file?">
                                            <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
