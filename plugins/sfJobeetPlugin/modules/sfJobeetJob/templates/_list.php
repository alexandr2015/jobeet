<table class="jobs">
  <?php foreach ($jobs as $i => $job): ?>
    <tr class="<?= fmod($i, 2) ? 'even' : 'odd' ?>">
        <td class="location">
            <?= $job->getLocation() ?>
        </td>
        <td class="position">
            <?= link_to($job->getPosition(), 'job_show_user', $job) ?>
        </td>
        <td class="company">
            <?= $job->getCompany() ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>