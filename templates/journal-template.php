<div class="container-fluid py-3 journal-page">

    <!-- Top Card: Selected Journal Entry -->
    <div class="card journal-header shadow-sm mb-4" id="journal-details-card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Select a Journal Entry</h5>
        </div>
        <div class="card-body journal-meta">
            <p class="mb-0 text-muted">Click an entry from the table below to see full details here.</p>
        </div>
    </div>

    <!-- Journal Entries Table -->
    <div class="card journal-table shadow-sm">
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
                        <?php foreach ($journals as $journal): ?>
                        <tr data-id="<?= (int)$journal['id'] ?>">
                            <td><?= htmlspecialchars($journal['created_at']) ?></td>
                            <td><?= htmlspecialchars($journal['entry']) ?></td>
                            <td><?= htmlspecialchars($journal['added_by']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script src="<?= APP_BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/datatables/js/datatables.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>


<script>
jQuery(document).ready(function() {
    var table = jQuery('#journal_entries').DataTable();

    table.on('click', 'tbody tr', function () {
        var journalId = $(this).data('id');
        if (!journalId) return;

        jQuery.ajax({
            url: '<?= APP_BASE_URL ?>/api/journal.php',
            method: 'GET',
            data: { id: journalId },
            dataType: 'json',
            success: function(response) {
                if (!response.success || !response.data) return;

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
                $('#journal-details-card .card-header h5').text('Journal Entry Details');

                // Highlight the selected row
                $('#journal_entries tbody tr').removeClass('table-primary');
                $(`#journal_entries tbody tr[data-id='${journalId}']`).addClass('table-primary');
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    });

});

</script>
