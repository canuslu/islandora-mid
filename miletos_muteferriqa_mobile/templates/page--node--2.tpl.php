<?php

/**
 * Advanced search page
 */
?>
<?php drupal_add_css(drupal_get_path('theme', 'miletos_muteferriqa_mobile').'/css/advanced-search.css'); ?>


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
            <ul id="navbar-menu">
                <li id="navbar-menu-user-dropdown" class="dropdown">
                    <a class="user-dropdown-toggle-button dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-3x fa-user-circle"></i> 
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li class="dropdown-menu-item"><a href="/user">Profile</a></li>
                      <li class="dropdown-menu-item" role="separator" class="divider"></li>
                      <li class="dropdown-menu-item"><a href="/user/logout">Logout</a></li>
                    </ul>
                </li>

                <li id="navbar-menu-advanced-search"><a class="advanced-search" href="/advanced-search"><?php echo t("Advanced Search"); ?></a></li>
                <li id="navbar-menu-islandora-simple-search">
                    <?php
                        $block = module_invoke('islandora_solr', 'block_view', 'simple');
                        print render($block['content']);
                    ?>
                </li>
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
<div class="background-image-holder"></div>
<div class="main-container <?php print $container_class; ?>">
    <?php print render($page['content']); ?>
    <div class="jumbotron">
      <h1>Advanced Search</h1>
      <p></p>
    </div>
  <div class="container">
      <div class="col-md-3">
          <div class="row">
              <h3>Add more terms by clicking the <strong>+</strong> icon</h3>
              <hr>
              <p>
                  and select in which field of the documents you want each term to be present.<br>
                  Note that each term gets searched only in its respective field.<br>
                  (You can use simple search box at the top or on the main page for general searches.)
              </p>
        </div>
      </div>
      <div class="col-md-6">
          <?php
              $advanced = module_invoke('islandora_solr', 'block_view', 'advanced');
              print render($advanced['content']);
          ?>
      </div>
      <div class="col-md-3">
          <div class="row">
              <h3>Combine your terms with the <strong>AND</strong>, <strong>OR</strong>, <strong>NOT</strong> operators</h3>
              <hr>
              <p>
                  <strong>AND</strong> results in documents containing both of the flanking terms<br>
                  <strong>OR</strong> results in documents containing at least one, but not necessarily all, of the terms<br>
                  <strong>NOT</strong> excludes all the documents containing the term, even if the document satisfies the other search criteria
              </p>
          </div>
      </div>
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
<?php //endif;?>
