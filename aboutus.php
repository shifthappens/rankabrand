<?php include 'views/header.php' ?>

        <div id="aboutus" data-role="page" data-back-btn-text="<?php echo _('Terug') ?>">
		        	<div data-role="header"><h4><?php echo _('Over Ons') ?></h4></div>
        	<div data-role="content">
<p align="center">
	<a href="http://www.rankabrand.nl/home/wat-we-doen"><img src="images/rank-a-brand-logo.png" width="250" /></a>
</p>
<p>
<?php echo _('Deze app is een initiatief van Rank a Brand, de grootste duurzame merkenvergelijkingssite van Europa. Hier vind je een gemakkelijk overzicht van belangrijke consumentenmerken en hun score op het gebied van duurzaamheid. De app bevat meer dan 800 merken in verschillende sectoren, waaronder kleding, elektronica, reizen, telecom en eten&amp;drinken.') ?>
</p>

<p>
	<?php echo _("Omdat Rank a Brand in het nieuws komt en consumenten kiezen voor de bestscorende merken, stimuleren wij samen dat merken beter presteren op duurzame thema's als milieubeleid, klimaatbeleid en arbeidsomstandigheden. Meer weten? Kijk op <a href=\"http://www.rankabrand.nl\">www.rankabrand.nl</a>.") ?>
</p>

<p align="center">
	<a href="http://www.hivos.nl/"><img src="images/hivos-logo.png" width="250" /></a>
</p>

<p><?php echo _("Deze applicatie is gemaakt met ondersteuning van Hivos (Humanistisch Instituut voor Ontwikkelingssamenwerking), op basis van een gedeelde visie: een eerlijke, vrije en duurzame wereld.") ?></p>


	<p align="center">
	<a href="http://www.terrafutura.nl"><img src="images/terrafuturalogo(2).png" width="250" /></a>
<p><?php echo _("De applicatie is technisch ontwikkeld door Tjerk Feitsma en Coen de Jong van <a href=\"http://terrafutura.nl\">stichting Terra Futura.") ?></a></p>
	
</p>
			
			
			
			</div>
        	<?php $navbar_active = 'aboutus'; include 'views/footer-navbar.php' ?>
        </div>

<?php include 'views/footer.php' ?>