<div id="job_actions">
    <h3>Admin</h3>
    <ul>
        <?php if (!$job->getIsActivated()): ?>
            <li><?= link_to('Edit', 'job_edit', $job) ?></li>
            <li><?= link_to('Publish', 'job_edit', $job) ?></li>
        <?php endif ?>
        <li><?= link_to('Delete', 'job_delete', $job, array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></li>
        <?php if ($job->getIsActivated()): ?>
            <li<?php $job->expiresSoon() and print ' class="expires_soon"' ?>>
                <?php if ($job->isExpired()): ?>
                    Expired
                <?php else: ?>
                    Expires in <strong><?= $job->getDaysBeforeExpires() ?></strong> days
                <?php endif ?>

                <?php if ($job->expiresSoon()): ?>
                    - <?php echo link_to('Extend', 'job_extend', $job, array('method' => 'put')) ?> for another <?php echo sfConfig::get('app_active_days') ?> days
                <?php endif ?>
            </li>
        <?php else: ?>
            <li>
                [Bookmark this <?= link_to('URL', 'job_show', $job, true) ?> to manage this job in the future.]
            </li>
        <?php endif ?>
        <li>
            <?=link_to('Publish', 'job_publish', $job, array('method' => 'put')) ?>
        </li>
    </ul>
</div>