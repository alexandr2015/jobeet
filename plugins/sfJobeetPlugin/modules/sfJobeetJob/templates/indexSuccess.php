<?php use_stylesheet('jobs.css') ?>

<div id="jobs">
  <?php foreach ($categories as $category): ?>
    <div class="category_<?= Jobeet::slugify($category->getName()) ?>">
      <div class="category">
        <div class="feed">
          <a href="">Feed</a>
        </div>
        <h1>
          <?= link_to($category, 'category', $category) ?>
        </h1>
      </div>

      <?php include_partial('sfJobeetJob/list', ['jobs' => $category->getActiveJobs(sfConfig::get('app_max_jobs_on_homepage'))]) ?>

      <?php if (($count = $category->countActiveJobs() - sfConfig::get('app_max_jobs_on_homepage')) > 0): ?>
        <div class="more_jobs">
          and <?= link_to($count, 'category', $category) ?>
          more...
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
<div class="feed">
  <a href="<?php echo url_for('category', array('sf_subject' => $category, 'sf_format' => 'atom')) ?>">Feed</a>
</div>