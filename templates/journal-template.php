<?php 
use Carbon\Carbon;

if (isset($journal_details) && $journal_details): 
    $createdAt = Carbon::parse($journal_details['created_at']);
    $formattedDate = $createdAt->format('M d Y');
?>
<div class="container-fluid py-3">

    <div class="card shadow-sm mb-4" id="journal-details-card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Journal Entry Details</h5>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <h6 class="fw-bold">Entry</h6>
                <p class="mb-0"><?= nl2br(htmlspecialchars($journal_details['entry'] ?? '')) ?></p>
            </div>

            <div class="mb-3">
                <h6 class="fw-bold">Description</h6>
                <p class="mb-0"><?= nl2br(htmlspecialchars($journal_details['description'] ?? '')) ?></p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1">
                        <strong>Added by:</strong>
                        <?= htmlspecialchars($journal_details['added_by'] ?? 'Unknown') ?>
                    </p>
                </div>

                <div class="col-md-6">
                    <p class="mb-1">
                        <strong>Created at:</strong>
                        <?= htmlspecialchars($formattedDate) ?>
                    </p>
                </div>
            </div>

            <?php if (!empty($attachments)): ?>
            <div class="mt-3">
                <h6 class="fw-bold">Attachments</h6>
                <ul class="list-group list-group-flush">
                    <?php foreach ($attachments as $attachment): ?>
                        <li class="list-group-item px-0">
                            <a
                                href="<?= APP_BASE_URL . '/' . htmlspecialchars($attachment['file_path']) ?>"
                                target="_blank"
                            >
                                <?= htmlspecialchars(basename($attachment['file_path'])) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">All Journal Entries</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="journal_entries" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date Added</th>
                            <th>Entry</th>
                            <th>Added By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($journals)): ?>
                            <?php foreach ($journals as $journal): ?>
                                <tr data-id="<?= (int)$journal['id'] ?>">
                                    <td><?= htmlspecialchars($journal['created_at']) ?></td>
                                    <td><?= htmlspecialchars($journal['entry']) ?></td>
                                    <td><?= htmlspecialchars($journal['added_by']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="<?= APP_BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/datatables/js/datatables.min.js"></script>

<script>
jQuery(document).ready(function() {
    var table = jQuery('#journal_entries').DataTable();

    $('#journal_entries tbody').on('click', 'tr', function () {
        var journalId = $(this).data('id');
        if (!journalId) return;

        jQuery.ajax({
            url: '<?= APP_BASE_URL ?>/api/journal.php',
            method: 'GET',
            data: { id: journalId },
            dataType: 'json',
            success: function(response) {
                if (!response.data) return;

                var entry = response.data.entry || '';
                var description = response.data.description || '';
                var addedBy = response.data.added_by || 'Unknown';
                var createdAt = response.data.created_at || '';

                var html = `
                <div class="mb-3">
                    <h6 class="fw-bold">Entry</h6>
                    <p class="mb-0">${entry.replace(/\n/g, '<br>')}</p>
                </div>
                <div class="mb-3">
                    <h6 class="fw-bold">Description</h6>
                    <p class="mb-0">${description.replace(/\n/g, '<br>')}</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Added by:</strong> ${addedBy}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Created at:</strong> ${createdAt}</p>
                    </div>
                </div>`;

                $('#journal-details-card .card-body').html(html);
            }
        });
    });
});
</script>
