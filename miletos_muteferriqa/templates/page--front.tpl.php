<?php

/**
 * Front page
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa').'/css/front.css'); ?>

<header id="navbar" role="banner" class="<?php print $navbar_classes; ?>">
  <div class="<?php print $container_class; ?>">
    <div class="navbar-header">
      <?php if ($logo): ?>
        <a class="logo navbar-btn pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
        </a>
      <?php endif; ?>

      <?php if (!empty($site_name)): ?>
        <a class="name navbar-brand" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"><?php print $site_name; ?></a>
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
            <ul id="navbar-menu">
                <li id="navbar-menu-profile"><a class="profile" href="/user"><i class="fas fa-3x fa-user-circle"></i></a></li>
                <li id="navbar-menu-advanced-search"><a class="advanced-search" href="/advanced-search"><?php echo t("Advanced Search"); ?></a></li>
            </ul>
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
    <div id="homepage-container">
        <div class="slogan-wrapper">
            <img src="/sites/all/themes/miletos_muteferriqa/images/slogan3.png">
        </div>
        <div id="user-interaction-wrapper">
            <?php
                echo '<div class="slogan-wrapper-anon"><img src="/sites/all/themes/miletos_muteferriqa/images/slogan3.png"></div>';
                $userblock = module_invoke('user', 'block_view', 'login');
                print render($userblock['content']);
                echo "<hr><div id='take-a-glance'><span>". t("Don't want to log in? You can take a glance at the Muteferriqa by clicking <a href='/muteferriqa/muteferriqa:demo'>here</a>.") . "</span></div>";
            ?>
        </div>
        <div id="homepage-search-wrapper">
                <?php
                    $block = module_invoke('islandora_solr', 'block_view', 'simple');
                    print render($block['content']);
                ?>
        </div>
        <div id="homepage-collection-wrapper">
            <span id="browse-collections"><?php echo t('Browse the <a href="/islandora">Muteferriqa Collection</a>'); ?></span>
        </div>
        <?php print render($page['content']); ?>
    </div>

</div>

<?php //if (!empty($page['footer'])):?>
  <footer class="footer <?php print $container_class; ?>">
      <div class="row" id="footer">
          <div class="col-md-6 footer-left">
          <strong><a href="/">Muteferriqa</a></strong> by <a href="http://miletos.co"><img src="/sites/all/themes/miletos_muteferriqa/images/miletos180.png"></a>. Copyright © 2019 Miletos Inc.
      </div>
      <ul class="col-md-6 footer-right footer-links">
          <li><a href="/content/acknowledgements"><?php echo t("Acknowledgements"); ?></a> |</li>
          <li><a href="/content/licenses"><?php echo t("Licenses"); ?></a> |</li>
          <li><a href="/content/terms-privacy"><?php echo t("Terms & Privacy"); ?></a></li>
      </ul>
      </div>
    <?php //print render($page['footer']);?>
  </footer>
<?php //endif;?>
