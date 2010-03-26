<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyled Content in IE */ ?> </script>
</head>
<body class="<?php print $body_classes; ?>"><?php if (!empty($admin)) print $admin; ?>

  <div id="page"><div id="page-inner">
    <div id="header"><div id="header-inner" class="clear-block">

      <?php if ($logo or $site_name or $site_slogan): ?>
        <div id="logo-title">

          <?php if ($logo): ?>
            <div id="logo"><a href="<?php print $base_path; ?>" title="<?php print t('Home'); ?>" rel="home"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" id="logo-image" /></a></div>
          <?php endif; ?>

          <h1 id="site-name">
            <?php print $site_name; ?>
          </h1>

          <?php if ($site_slogan): ?>
            <div id="site-slogan"><?php print $site_slogan; ?></div>
          <?php endif; ?>

        </div> <!-- /#logo-title -->
      <?php endif; ?>

      <?php if ($header): ?>
        <div id="header-blocks" class="region region-header">
          <?php print $header; ?>
        </div> <!-- /#header-blocks -->
      <?php endif; ?>

    </div></div> <!-- /#header-inner, /#header -->

    <div id="main"><div id="main-inner" class="clear-block<?php if ($search_box or $primary_links or $secondary_links or $navbar) { print ' with-navbar'; } ?>">

      <?php if ($top): ?>
        <div id="top" class="region region-top">
          <?php print $top; ?>
        </div> <!-- /#top -->
      <?php endif; ?>
      
      <div id="content"><div id="content-inner">

        <?php if ($mission): ?>
          <div id="mission"><?php print $mission; ?></div>
        <?php endif; ?>
        
        <?php if ($breadcrumb): ?>
        <div id="breadcrumb_wrap">
          <?php print $breadcrumb; ?>
        </div>
        <?php endif; ?>

        <div id="content-area" class="clear-block">

          <div id="content-area-inner">
            <?php if ($title or $tabs or $help or $messages): ?>
              <div id="content-header">
                <?php print $messages; ?>
                <?php if ($title): ?>
                  <h1 class="title"><?php print $title; ?></h1>
                <?php endif; ?>
                <?php if ($tabs): ?>
                  <div class="tabs"><?php print $tabs; ?></div>
                <?php endif; ?>
              </div> <!-- /#content-header -->
            <?php endif; ?>

            <?php if ($content_top): ?>
              <div id="content-top" class="region region-content_top">
                <?php print $content_top; ?>
              </div> <!-- /#content-top -->
            <?php endif; ?>

            <?php print $content; ?>

            <?php if ($content_bottom): ?>
              <div id="content-bottom" class="region region-content_bottom">
                <?php print $content_bottom; ?>
              </div> <!-- /#content_bottom -->
            <?php endif; ?>
          </div> <!-- /#content-area-inner -->

          <?php if ($right || $left): ?>
            <div id="sidebar"><div id="sidebar-inner" class="region region-sidebar">
              <?php print $right; ?>
              <?php print $left; ?>
            </div></div> <!-- /#sidebar-inner, /#sidebar -->
          <?php endif; ?>
        </div> <!-- /#content-area -->

        <?php if ($right && !$is_front): ?>
          <div id="sidebar-bottom-bg">&nbsp;</div>
        <?php endif; ?>

        <?php if ($feed_icons): ?>
          <div class="feed-icons"><?php print $feed_icons; ?></div>
        <?php endif; ?>

        <?php if ($bottom): ?>
          <div id="bottom" class="region region-bottom clear-block">
            <?php print $bottom; ?>
          </div> <!-- /#bottom -->
        <?php endif; ?>

      </div></div> <!-- /#content-inner, /#content -->

      <?php if ($search_box or $primary_links or $secondary_links or $navbar): ?>
        <div id="navbar"><div id="navbar-inner" class="region region-navbar">

          <?php if ($secondary_links): ?>
            <div id="secondary">
              <?php print theme('links', $secondary_links); ?>
            </div> <!-- /#secondary -->
          <?php endif; ?>

          <div id="primary">
            <?php print theme('links', $primary_links); ?>
          </div> <!-- /#primary -->

          <?php if ($primary_links_sub): ?>
            <div id="primary-sub">
              <?php print theme('links', $primary_links_sub); ?>
            </div> <!-- /#primary-sub -->
          <?php endif; ?>

          <?php print $navbar; ?>

        </div></div> <!-- /#navbar-inner, /#navbar -->
      <?php endif; ?>

    </div></div> <!-- /#main-inner, /#main -->

    <div id="footer-wrap"><div id="footer"><div id="footer-inner" class="region region-footer">

      <div class="clear-block">
        <?php if ($primary_links): ?>
          <div id="primary-footer">
            <?php print theme('links', $primary_links); ?>
          </div> <!-- /#primary -->
        <?php endif; ?>

        <div id="footer-right-content">
          <?php if ($follow_site): ?>
            <div id="follow-site"><?php print $follow_site; ?></div>
          <?php endif; ?>

          <?php if ($footer_message): ?>
            <div id="footer-message"><?php print $footer_message; ?></div>
          <?php endif; ?>

          <?php if ($footer_links): ?>
            <div id="footer-links">
              <?php print theme('links', $footer_links); ?>
            </div> <!-- /#div -->
          <?php endif; ?>

          <div id="copyright"><?php print $copyright; ?></div>
        </div> <!-- /#footer-right-content -->
      </div>

      <?php print $footer; ?>

    </div></div></div> <!-- /#footer-inner, /#footer, /#footer-wrap -->

  </div></div> <!-- /#page-inner, /#page -->

  <?php if ($closure_region): ?>
    <div id="closure-blocks" class="region region-closure"><?php print $closure_region; ?></div>
  <?php endif; ?>

  <?php print $closure; ?>

</body>
</html>
