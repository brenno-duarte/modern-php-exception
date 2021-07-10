<div class="modal fade" id="bench" tabindex="-1" aria-labelledby="benchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <p><strong>Elapse time:</strong> <?= $this->bench->getTime() ?></p>
                <p><strong>Elapse microtime:</strong> <?= $this->bench->getTime(true) ?></p>
                <p><strong>Elapse time format:</strong> <?= $this->bench->getTime(false, '%d%s') ?></p>
                <p><strong>Memory peak:</strong> <?= $this->bench->getMemoryPeak() ?></p>
                <p><strong>Memory peak in bytes:</strong> <?= $this->bench->getMemoryPeak(true) ?></p>
                <p><strong>Memory peak format:</strong> <?= $this->bench->getMemoryPeak(false, '%.3f%s') ?></p>
                <p><strong>Memory usage:</strong> <?= $this->bench->getMemoryUsage() ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>