<?php
	include 'views/header.php';
					
	//get the sectors through the API via the proxy php file
	$sectorsData = getSectorsData($_GET['sector']);
	usort($sectorsData->subsectors, 'cmpname');
	//echo '<!--'.var_dump($sectorsData, true).'-->';
	
	
?>
        <!-- Add your site or application content here -->    
	        	<?php
				if(count($sectorsData->subsectors) !== 0):
				?>
        <div id="subsectors" data-role="page" data-theme="b" data-dom-cache="true" data-back-btn-theme="b" data-add-back-btn="true">
        	<div data-role="header"><h4><?php echo $sectorsData->name?></h4></div>
        	<div data-role="content">
	        	<ul data-role="listview">
					<?php
							foreach($sectorsData->subsectors as $subsector):
					?>
							<li class="subsector"><a href="brands.php?sector=<?php echo $subsector->id?>&title=<?php echo urlencode($subsector->name)?>"><h3 class="sectorname"><?php echo $subsector->name?></h3></a></li>
					<?php
							endforeach; //end subsector loop
							
					?>
				</ul>
	        	
        	</div>	        

        	<?php $navbar_active = 'sectors'; include 'views/footer-navbar.php' ?>

        </div>
		        <?php
		        endif;
		        ?>
        

<?php include 'views/footer.php'; ?>