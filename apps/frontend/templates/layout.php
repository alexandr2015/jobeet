<!-- apps/frontend/templates/layout.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>
    <?php include_slot('title', 'Jobeet - Your best job board') ?>
  </title>
  <link rel="shortcut icon" href="/favicon.ico" />
  <?php include_stylesheets() ?>
  <?php use_javascript('jquery-1.12.0.min.js') ?>
  <?php use_javascript('search.js') ?>
  <?php include_javascripts() ?>
  <link rel="alternate" type="application/atom+xml" title="Latest Jobs"
        href="<?= url_for('job', array('sf_format' => 'atom'), true) ?>" />
</head>
<body>

<div id="container">
  <div id="header">
    <div class="content">
      <h1>
        <a href="<?= url_for('@homepage') ?>">
          <img src="/legacy/images/logo.jpg" alt="Jobeet Job Board" />
        </a>
      </h1>

      <div id="sub_header">
        <div class="post">
          <h2>Ask for people</h2>
          <div>
            <a href="<?= url_for('@job_new') ?>">Post a Job</a>
          </div>
        </div>

        <div class="search">
          <h2>Ask for a job</h2>
          <form action="<?= url_for('job_search') ?>" method="get">
            <input type="text" name="query" value="<?= $sf_request->getParameter('query') ?>" id="search_keywords" />
            <input type="submit" value="search" />
            <img id="loader" src="/legacy/images/loader.gif" style="vertical-align: middle; display: none" />
            <div class="help">
              Enter some keywords (city, country, position, ...)
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="content">
    <div id="job_history">
      Recent viewed jobs:
      <ul>
        <?php foreach ($sf_user->getJobHistory() as $job): ?>
          <li>
            <?= link_to($job->getPosition().' - '.$job->getCompany(), 'job_show_user', $job) ?>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="flash_notice"><?= $sf_user->getFlash('notice') ?></div>
    <?php endif; ?>

    <?php if ($sf_user->hasFlash('error')): ?>
      <div class="flash_error"><?= $sf_user->getFlash('error') ?></div>
    <?php endif; ?>

    <div class="content">
      <?= $sf_content ?>
    </div>
  </div>

  <div id="footer">
    <div class="content">
          <span class="symfony">
            <img src="/legacy/images/jobeet-mini.png" />
            powered by <a href="/">
              <img src="/legacy/images/symfony.gif" alt="symfony framework" /></a>
          </span>
      <ul>
        <li><a href="">About Jobeet</a></li>
        <li class="feed"><a href="">Full feed</a></li>
        <li><a href="">Jobeet API</a></li>
        <li class="last">
          <a href="<?= url_for('affiliate_new') ?>">Become an affiliate</a>
        </li>
        <li class="feed">
          <a href="<?= url_for('job', array('sf_format' => 'atom')) ?>">Full feed</a>
        </li>
      </ul>
    </div>
  </div>
</div>
</body>
</html>