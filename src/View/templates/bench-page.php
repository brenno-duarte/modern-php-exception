<div class="modal fade" id="bench" tabindex="-1" aria-labelledby="benchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body dark-trace">
                <p class="bench-title"><strong>Elapse time:</strong> <?= $this->bench->getTime() ?></p>
                <p class="bench-title"><strong>Elapse microtime:</strong> <?= $this->bench->getTime(true) ?></p>
                <p class="bench-title"><strong>Elapse time format:</strong> <?= $this->bench->getTime(false, '%d%s') ?></p>
                <p class="bench-title"><strong>Memory peak:</strong> <?= $this->bench->getMemoryPeak() ?></p>
                <p class="bench-title"><strong>Memory peak in bytes:</strong> <?= $this->bench->getMemoryPeak(true) ?></p>
                <p class="bench-title"><strong>Memory peak format:</strong> <?= $this->bench->getMemoryPeak(false, '%.3f%s') ?></p>
                <p class="bench-title"><strong>Memory usage:</strong> <?= $this->bench->getMemoryUsage() ?></p>
            </div>
            <div class="modal-footer dark-trace">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>