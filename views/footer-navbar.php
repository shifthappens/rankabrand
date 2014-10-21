<?php $active = isset($navbar_active) ? $navbar_active : 'search'; ?>
	    	<div data-role="footer" data-position="fixed" data-id="bottomnavbar" data-transition="none">	        	
				<div data-role="navbar">
					<ul>
						<li><a href="sectors.php" data-icon="star" data-prefetch="true" data-transition="none" <?php echo $active == 'sectors' ? 'class="ui-btn-active ui-state-persist"' : '' ?>><?php echo _('Sectoren') ?></a></li>
						<li><a href="search.php" data-icon="search" data-transition="none" <?php echo $active == 'search' || empty($active) ? 'class="ui-btn-active ui-state-persist"' : '' ?>><?php echo _('Zoeken') ?></a></li>
						<li><a href="aboutus.php" data-icon="info" data-prefetch="true" data-transition="none" <?php echo $active == 'aboutus' ? 'class="ui-btn-active ui-state-persist"' : '' ?>><?php echo _('Over Ons') ?></a></li>
					</ul>
				</div>	        	
	    	</div>
