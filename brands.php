<?php
	include 'views/header.php';
	
	function getBrandsDataBySector()
	{
		$brands = getFromAPI('brands/sector/'.$_GET['sector']);
				
		return $brands;
	}
					
	function printBrandsOfSector($sectorid)
	{
		$brands = getFromAPI('brands/sector/'.$sectorid);
		$html = '';
		
		if(count($brands) !== 0):
			$html .= '<ul id="brands-'.$sectorid.'">';
			
			foreach($brands as $brand):
			
	        		
	        endforeach;
			
			$html .= '</ul>';
		endif;
		
		return $html;
	}
	
	//get the sectors through the API via the proxy php file
	$brandsData = getBrandsDataBySector();
	usort($brandsData, 'cmppercent');
	//echo '<!--'.var_dump($brandsData, true).'-->';
	
	
?>
        <!-- Add your site or application content here -->    
        <div id="brandsbysector" data-role="page" data-dom-cache="false" data-add-back-btn="true" data-back-btn-text="<?php echo _('Terug') ?>">
        	<div data-role="header"><h4><?php echo urldecode($_GET['title'])?></h4></div>
        	<div data-role="content">
	        	<ul data-role="listview" id="listofbrandsinsector">
	        	<?php foreach($brandsData as $brand): ?>
					<li class="brand"><a class="brandpage" href="singlebrand.php?bid=<?php echo $brand['id']?>&active=sectors"><span class="brandname"><?php echo $brand['brandname']?></span>
							        <div class="brandrank"><div class="brandrank-percentage" data-score="<?php echo $brand['score']?>" data-score-total="<?php echo $brand["score_total"]?>"></div> <span class="brandrank-grade"></span></div></a>
					</li>
				<?php
	        		endforeach; //end brands loop
	        	?>	
	        	</ul>
	        	
        	</div>	        

        	<?php $navbar_active = 'sectors'; include 'views/footer-navbar.php' ?>

        </div>        

<?php include 'views/footer.php'; ?>