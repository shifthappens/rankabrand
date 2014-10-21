<?php include 'views/header.php' ?>

        <div id="rabloading"><img src="images/rank-a-brand-logo-260.jpg" alt="rank-a-brand-logo" width="260" /></div>
	    <div id="search" data-role="page" data-back-btn-text="<?php echo _('Terug') ?>" data-dom-cache="true">
        	<div data-role="content">
        	<form class="ui-listview-filter ui-bar-c" id="brand-search-form" role="search" onsubmit="return false;">
        		<input id="brand-search-input" class="brandsearchinput" data-type="search" placeholder="<?php echo _('Zoek op merknaam...') ?>" />
        	</form>
	        	<ul id="brands" data-role="listview" class="brandslistview">
		        	<li class="brand template"><a class="brandpage" href=""><span class="brandname"></span>
		        		<div class="brandrank"><div class="brandrank-percentage" data-score="" data-score-total=""></div> <span class="brandrank-grade"></span></div></a>
              		</li>
              	</ul>
        	</div>
        	<?php $navbar_active = 'search'; include 'views/footer-navbar.php' ?>
        </div>
<?php include 'views/footer.php' ?>