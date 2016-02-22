<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>Jobeet (<?= $category ?>)</title>
    <subtitle>Latest Jobs</subtitle>
    <link href="<?= url_for('category', array('sf_subject' => $category, 'sf_format' => 'atom'), true) ?>" rel="self" />
    <link href="<?= url_for('category', array('sf_subject' => $category), true) ?>" />
    <updated><?= gmstrftime('%Y-%m-%dT%H:%M:%SZ', $category->getLatestPost()->getDateTimeObject('created_at')->format('U')) ?></updated>
    <author>
        <name>Jobeet</name>
    </author>
    <id><?= sha1(url_for('category', array('sf_subject' => $category), true)) ?></id>

    <?php include_partial('job/list', array('jobs' => $pager->getResults())) ?>
</feed>