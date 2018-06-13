<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
  <div class="container">
	<a class="navbar-brand js-scroll-trigger" href="<?php echo $site_url; ?>"><?php echo $site_name; ?></a>
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	  <span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
	  <ul class="navbar-nav ml-auto">
		<?php 
		foreach($menu_pages as $page) { ?>
			<li class="nav-item">
			  <a class="nav-link js-scroll-trigger" href="<?php echo $site_url . $page['link']; ?>"><?php echo $page['title']; ?></a>
			</li>
		<?php } ?>
	  </ul>
	</div>
  </div>
</nav>