<?php

/**
 * 403 - Access Denied page.
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa_mobile').'/css/403.css'); ?>

<header id="navbar" role="banner" class="<?php print $navbar_classes; ?>">
  <div class="<?php print $container_class; ?>">
    <div class="navbar-header">
      <?php if ($logo): ?>
        <a class="logo navbar-btn pull-left" href="<?php echo "/home"; ?>" title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
        </a>
      <?php endif; ?>

      <?php if (!empty($site_name)): ?>
        <a class="name navbar-brand" href="<?php echo "/home"; ?>" title="<?php print t('Home'); ?>"><?php print $site_name; ?></a>
      <?php endif; ?>

      <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
          <span class="sr-only"><?php print t('Toggle navigation'); ?></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      <?php endif; ?>
    </div>

    <?php //if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])):?>
      <div class="navbar-collapse collapse" id="navbar-collapse">
        <nav role="navigation">
          <?php if (!empty($primary_nav)): ?>
            <?php print render($primary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($secondary_nav)): ?>
            <?php print render($secondary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($page['navigation'])): ?>
            <?php print render($page['navigation']); ?>
          <?php endif; ?>
        </nav>
      </div>
    <?php //endif;?>
  </div>
</header>

<div class="main-container <?php print $container_class; ?>">
  <div class="centered-image">
      <?php 
          global $language;
          if ($language->language == 'en') {
      ?>
      <img src="/sites/all/themes/miletos_muteferriqa_mobile/images/403_en.png" onclick="goback()"/>
      <?php
          } else {
      ?>
      <img src="/sites/all/themes/miletos_muteferriqa_mobile/images/403_tr.png" onclick="goback()"/>
      <?php
          }
      ?>
    </div> 

</div>

<?php //if (!empty($page['footer'])):?>
  <footer class="footer <?php print $container_class; ?>">
      <div class="row" id="footer">
          <div class="col-md-6 footer-left">
          <strong><a href="/">Muteferriqa</a></strong> by <a href="http://miletos.co"><img src="/sites/all/themes/miletos_muteferriqa_mobile/images/miletos180.png"></a>. Copyright © 2019 Miletos Inc.
      </div>
      <ul class="col-md-6 footer-right footer-links">
          <li><a href="/content/acknowledgements"><?php echo t("Acknowledgements"); ?></a> |</li>
          <li><a href="/content/licenses"><?php echo t("Licenses"); ?></a> |</li>
          <li><a href="/content/terms-privacy"><?php echo t("Terms & Privacy"); ?></a></li>
      </ul>
      </div>
    <?php //print render($page['footer']);?>
  </footer>
  <script>
      function goback() {
              window.history.go(-1);
      }
  </script>
<?php //endif;?>
