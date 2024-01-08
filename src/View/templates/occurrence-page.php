<?php if ($this->is_occurrence_enabled === true) : ?>
    <div class="modal fade" id="occurrencesid" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 txt-dark-theme" id="staticBackdropLabel">Occurrences</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($resources['list_occurrences']) : ?>
                        <?php foreach ($resources['list_occurrences'] as $occurrence) : ?>
                            <section class="bg-main-info-exc p-3 rounded-3 border border-secondary-subtle mb-3">
                                <div class="row justify-content-start">
                                    <div class="col-md-8">
                                        <?php $exception_error_name = explode("-", $occurrence['type_error']); ?>

                                        <p>
                                            <strong class="txt-dark-theme"><?= $exception_error_name[0] ?></strong>
                                            <small class="txt-dark-theme-2"><?= $exception_error_name[1] ?></small>
                                        </p>

                                        <code class="text-primary txt-error-file"><?= $occurrence['description_error'] ?></code>

                                        <p class="mt-4">
                                            <strong class="txt-dark-theme">URL</strong> 
                                            <small class="txt-dark-theme-2"><?= $occurrence['url_occurrence'] ?></small>
                                        </p>
                                        <p>
                                            <strong class="txt-dark-theme">File</strong>
                                            <small class="txt-dark-theme-2"><?= $occurrence['file_occurrence'] ?></small>
                                        </p>
                                        <p>
                                            <strong class="txt-dark-theme">Line</strong>
                                            <small class="txt-dark-theme-2"><?= $occurrence['line_occurrence'] ?></small>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span class="txt-dark-theme">Occurrences</span>
                                                <span class="badge bg-primary rounded-pill"><?= $occurrence['times_occurrence'] ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span class="txt-dark-theme">First occurrence</span>
                                                <span class="badge bg-primary rounded-pill"><?= $occurrence['first_occurrence'] ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span class="txt-dark-theme">Last occurrence</span>
                                                <span class="badge bg-primary rounded-pill"><?= $occurrence['last_occurrence'] ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span class="txt-dark-theme">Environment</span>
                                                <span class="badge bg-primary rounded-pill"><?= ($occurrence['is_production'] === 0) ? "Development" : "Production" ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>