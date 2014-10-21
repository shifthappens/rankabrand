<?php
	include 'views/header.php';
	$brandid = $_GET['bid'];
	$active_nav = $_GET['active'];
		
	$brandData = getFromAPI('brand/brand/'.$brandid);
	$gradeletter = calculateBrandRanking($brandData['score'], $brandData['score_total']);
	
?>
        <!-- Add your site or application content here -->    
        <div id="singlebrand" data-role="page" data-back-btn-text="<?php echo _('Terug') ?>" data-add-back-btn="true">
        <!--<?php echo print_r($brandData, true) ?>-->
		        	<div data-role="header"><h4><?php echo $brandData['brandname']?></h4></div>
        	<div data-role="content">
        		<a href="#shareMenu" data-position-to="window" data-rel="popup" data-role="button" data-mini="true" data-inline="true" data-icon="gear"><?php echo _('Delen') ?></a>
        		<a href="brands.php?sector=<?php echo $brandData['sectorId']?>&title=<?php echo urlencode($brandData['sector']) ?>" data-role="button" data-mini="true" data-inline="true" data-icon="check"><?php echo _('Vergelijk') ?></a>
        		<img id="brandlogo" src="<?php echo $brandData['logo']?>" />
        		
        		<h5 class="rabscore"><?php echo _('Rank a Brand score') ?></h5>
        		<div class="scorecard">
			        <div class="brandrank"><div class="brandrank-percentage" data-score="<?php echo $brandData['score'] ?>" data-score-total="<?php echo $brandData['score_total']?>"></div> <span class="brandrank-grade"></span></div>
			        <div class="brandrank-text"><?php echo $brandData['score']?> <?php echo _('van') ?> <?php echo $brandData['score_total'] ?></div>
        		</div>
        		

        		<h3 class="scorerapport"><?php echo _('Score Rapport') ?></h3>
        		<hr />
        		<?php foreach($brandData['scores'] as $subscore): ?>
        		<div class="subscore">
	        		<h5 class="subscore-title"><?php echo $subscore['name']?></h5>
	        		<div class="scorecard">
				        <div class="brandrank"><div class="brandrank-percentage" data-score="<?php echo $subscore['score'] ?>" data-score-total="<?php echo $subscore['score_total']?>"></div> <span class="brandrank-grade"></span></div>
				        <div class="brandrank-text"><?php echo $subscore['score']?> <?php echo _('van') ?> <?php echo $subscore['score_total'] ?></div>
	        		</div>	        		
					
					
					
        		</div>
        		<?php endforeach; ?>

        		<h3 class="brandinfo"><?php echo _('Info') ?></h3>
        		<hr />
        		<div class="infoitem">
	        		<h5 class="infoitem-title"><?php echo _('Eigenaar') ?></h5>
	        		<p class="infoitem-value"><?php echo $brandData['owner']?></p>
        		</div>
        		<div class="infoitem">
	        		<h5 class="infoitem-title"><?php echo _('Hoofdkantoor') ?></h5>
	        		<p class="infoitem-value"><?php echo $brandData['headoffice']?></p>
        		</div>
        		<div class="infoitem">
	        		<h5 class="infoitem-title"><?php echo _('Sector') ?></h5>
	        		<p class="infoitem-value"><?php echo $brandData['sector']?></p>
        		</div>
        		<div class="infoitem">
	        		<h5 class="infoitem-title"><?php echo _('Categorieën') ?></h5>
	        		<p class="infoitem-value"><?php echo implode(', ', $brandData['categories'])?></p>
        		</div>
        		<div class="infoitem">
	        		<h5 class="infoitem-title"><?php echo _('Tags') ?></h5>
	        		<p class="infoitem-value"><?php echo implode(', ', $brandData['tags'])?></p>
        		</div>
        		<div class="infoitem">
	        		<h5 class="infoitem-title"><?php echo _('Meer info') ?></h5>
	        		<p class="infoitem-value"><a href="<?php echo $brandData['url']?>"><?php echo $brandData['url']?></a></p>
        		</div>


		<div data-role="popup" id="shareMenu" style="min-width: 250px;">
				<ul data-role="listview" data-inset="true">
					<li data-role="divider" data-theme="e"><?php echo _('Deel via:') ?></li>
					<li><a href="mailto:?subject=<?php echo sprintf(_('%s krijgt een %s-label op Rank a Brand!'), $brandData['brandname'], $gradeletter); ?>&body=<?php echo sprintf(_("Hoi! Ik wil het merk %s met je delen op Rank a Brand. Daar krijgt dit merk een %s-label. Nieuwsgierig geworden? Check jouw favoriete merken op http://rankabrand.nl!"), $brandData['brandname'], $gradeletter); ?>"><?php echo _('E-mail') ?></a></li>
					<li><a href="sms:"><?php echo _('SMS') ?></a></li>
					<li><a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(sprintf(_("%s krijgt 'n %s op Rank a Brand voor duurzaamheid. Nieuwsgierig naar jouw favoriete merken? http://rankabrand.nl"), $brandData['brandname'], $gradeletter)) ?>" target="_blank">Twitter</a></li>
					<li><a href="https://www.facebook.com/sharer.php?s=100&p[url]=<?php echo urlencode(getFullURL()) ?>&p[title]=<?php echo urlencode(sprintf(_('%s op Rank a Brand'), $brandData['brandname'])) ?>&p[summary]=<?php echo urlencode(_("Rank a Brand helpt je bij het kopen van duurzame merken. Hoe maatschappelijk verantwoord zijn populaire merken als Apple, Nokia en Nike? Rank a Brand beoordeelt de duurzaamheid van merken zodat u hun prestaties kunt vergelijken.")); ?>&p[images][0]=<?php echo urlencode($brandData['logo']) ?>" target="_blank">Facebook</a></li>
				</ul>
		</div>

			</div>
			<?php $navbar_active = $active_nav; include 'views/footer-navbar.php'; ?>
        </div>

<?php include 'views/footer.php'; ?>