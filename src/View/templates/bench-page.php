<div class="modal fade" id="bench" tabindex="-1" aria-labelledby="benchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 txt-dark-theme" id="staticBackdropLabel">Benchmark</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="txt-dark-theme">Elapse time</span>
                        <span class="badge error-color bg-primary rounded-pill"><?= $this->bench->getTime() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="txt-dark-theme">Memory peak</span>
                        <span class="badge error-color bg-primary rounded-pill"><?= $this->bench->getMemoryPeak() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="txt-dark-theme">Memory usage by PHP</span>
                        <span class="badge error-color bg-primary rounded-pill"><?= $this->bench->getMemoryUsage() ?></span>
                    </li>
                    <?php if (!is_null($resources['cpu_usage'])) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="txt-dark-theme">CPU usage</span>
                            <span class="badge error-color bg-primary rounded-pill"><?= $resources['cpu_usage'] ?>%</span>
                        </li>
                    <?php endif; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="txt-dark-theme">Memory usage by system</span>
                        <span class="badge error-color bg-primary rounded-pill"><?= $resources['memory_usage'] ?></span>
                    </li>
                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary modal-close" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>