<?php
	include 'views/header.php';
					
	//get the sectors through the API via the proxy php file
	$sectorsData = getSectorsData();
	usort($sectorsData, 'cmpname');
	//echo '<!--'.var_dump($sectorsData, true).'-->';
	
	
?>
        <!-- Add your site or application content here -->    
        <div id="topsectors" data-role="page" data-back-btn-text="<?php echo _('Terug') ?>" data-dom-cache="true">
        	<div data-role="header"><h4><?php echo _('Sectoren') ?></h4></div>
        	<div data-role="content">
	        	<ul data-role="listview" id="listoftopsectors">
	        	<?php foreach($sectorsData as $topsector): ?>
        			<?php if(!isset($topsector->subsectors) || count($topsector->subsectors) === 0):
        			$link = 'brands.php?sector='.$topsector->id.'&title='.urlencode($topsector->name);
        			else:
        			$link = 'subsectors.php?sector='.$topsector->id;
        			endif;
        			?>	        		
	        		<li class="sector"><a href="<?php echo $link?>"><h3 class="sectorname"><?php echo $topsector->name?></h3></a></li>
	        	<?php
	        			endforeach; //end topsector loop
	        	?>	
	        	</ul>
	        	
        	</div>	        

        	<?php $navbar_active = 'sectors'; include 'views/footer-navbar.php' ?>

        </div>

		<?php
			//check for subsectors
			foreach($sectorsData as $topsector):
			if(count($topsector->subsectors) !== 0):
		?>
        <div id="subsectors<?php echo $topsector->id?>" data-role="page" data-back-btn-text="<?php echo _('Terug') ?>" data-theme="b" data-dom-cache="true" data-add-back-btn="true">
        	<div data-role="header"><h4><?php echo $topsector->name?></h4></div>
        	<div data-role="content">
	        	<ul data-role="listview">
					<?php
							foreach($topsector->subsectors as $subsector):
					?>
							<li class="subsector"><a href="brands.php?sector=<?php echo $subsector->id?>&title=<?php echo $subsector->name?>"><h3 class="sectorname"><?php echo $subsector->name?></h3></a></li>
					<?php
							endforeach; //end subsector loop
							
					?>
				</ul>
        	</div>
        	<?php $navbar_active = 'sectors'; include 'views/footer-navbar.php' ?>
        </div>
        <?php 
        	endif;
        	endforeach;
        ?>
        

<?php include 'views/footer.php'; ?>