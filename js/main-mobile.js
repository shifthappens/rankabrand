allowedKeyCodes = new Array(8, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80,
							81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 186, 187, 188, 189,
							190, 191, 192, 219, 220, 221, 222);
							
$(document).on('mobileinit', function(event)
{
	$.mobile.defaultPageTransition = 'slide';
	$.mobile.page.prototype.options.addBackBtn = true;
	
	
	//$('#search').live('pagecreate', function() { getAllBrands(populateBrandsList); });
	//getAllBrands(populateBrandsList);
		
	$('#search, #singlebrand, #sectors, #brandsbysector').live('pagecreate', processBrandRankings);
	$('#search').live('pagebeforeshow', function() { $.mobile.loading('show'); });
	$('#search').live('pageshow', function() { $('#rabloading').fadeOut(1500, function() { $(this).remove(); }); $.mobile.loading('hide'); initSearchPage(event); });
});

function initSearchPage(event)
{
	console.log('taking events off of brand search...');
	$('#brand-search-form .ui-input-clear').die('click.brandupdate');
	$('#brand-search-input').die('keyup.brandupdate');
	$('#brands').die('vmousemove');
	$('#brand-search-form').die('submit');

	console.log('putting events back on brand search...');
	$('#brand-search-form .ui-input-clear').live('click.brandupdate', emptyBrandsList);
	$('#brand-search-input').live('keyup.brandupdate', $.debounce(updateBrandsSearchResults, 300));
	$('#brands').live('vmousemove', blurSearchInput);
	$('#brand-search-form').submit(function(event) { blurSearchInput(event); return false; });
}

function blurSearchInput(event)
{
	$('#brand-search-input, .brandsearchinput').trigger('blur');
}

function updateBrandsSearchResults(event)
{
	event.preventDefault();
	console.log('updating search results...', $(this).val(), event.keyCode);
	
	if($.inArray(event.keyCode, allowedKeyCodes) === -1)
	{
		return false;
	}
	else if($.trim($(this).val()) == '')
	{
		emptyBrandsList();
		return;
	}
	
	//first get some results
	getFromAPI('search/brand/'+$(this).val(), function(response)
	{
		console.log($.parseJSON(response.responseText));
		populateBrandsList(response);
	});
}

function emptyBrandsList()
{
	$('.brandslistview:visible li.brand:not(.template)').remove();
}

function populateBrandsList(response)
{
	var brandData = $.parseJSON(response.responseText);

	if(brandData.length == 0)
		return;
		
	//first sort the data to be alphabetical because jQuery Mobile doesn't do that for us
	brandData.sort(sort_by('brandname', true, function(a){return a.toUpperCase()}));
	
	var brandslist = $('.brandslistview:visible');
	console.log($('.brandslistview:visible'));
	var listitem = $('.brand.template').first().clone();
	
	emptyBrandsList();
		
	for(i = 0; i < brandData.length; i++)
	{
		var newBrand = listitem.clone().removeClass('template');
		newBrand.attr('data-filtertext', brandData[i].brandname);
		newBrand.find('.brandname').html(brandData[i].brandname);
		newBrand.find('.brandrank-percentage').attr('data-score', brandData[i].score);		
		newBrand.find('.brandrank-percentage').attr('data-score-total', brandData[i].score_total);		
		newBrand.find('.brandpage').attr('href', 'singlebrand.php?bid='+brandData[i].id+'&sectorid='+brandData[i].sectorId+'&active=search');
		newBrand.appendTo(brandslist).show();
	}
		
	console.log('refreshing listview...');
	brandslist.listview('refresh');
	
	processBrandRankings();	
}


function processBrandRankings()
{
	console.log('going to process brand rankings...');
	var brandranks = $('.brandrank');
	
	brandranks.each(function(index, rank)
	{
		rank = $(rank);
		rank.find('.brandrank-percentage').attr('class', 'brandrank-percentage');
		rank.find('.brandrank-grade').attr('class', 'brandrank-grade');
		var score = rank.find('.brandrank-percentage').data('score');
		var scoreTotal = rank.find('.brandrank-percentage').data('score-total');
		//console.log(score, scoreTotal);
		var percentage = calculatePercentage(score, scoreTotal);
		console.log('percentage '+percentage);
		var grade = 'E';
		 
		if(percentage < 15)
			grade = 'E';
		else if(percentage < 35)
			grade = 'D';
		else if(percentage < 55)
			grade = 'C';
		else if(percentage < 75)
			grade = 'B';
		else if(percentage <= 100)	
			grade = 'A';
		
		rank.find('.brandrank-percentage').css('width', Math.max(1, Math.min(87, percentage))+'%').addClass('brandrank-rankbgcolor-'+grade);
		rank.find('.brandrank-grade').addClass('brandrank-rankcolor-'+grade).text(grade);
	});
}

function getFromAPI(command, callback)
{
	$.get('rankabrandproxy.php', { command: command, lang: API_language }).complete(callback);
}

function getAllBrands(callback)
{
	//check cache
	$.get('cache/brands.json').complete(function(response)
	{
		if(response.status != 200)
		{
			var results = getFromAPI('search/brand/', callback);
		}
		else
		{
			response.fromCache = true;
			callback.call(response);
		}
	})
}

function getAllSectors(callback)
{
	var results = getFromAPI('sectors', callback);
}

function getSubsectors(parent, callback)
{
	var results = getFromAPI('sectors/parent/'+parent, callback);
}

function calculatePercentage(score, score_total)
{
	return Math.round((score / score_total) * 100);
}

var sort_by = function(field, reverse, primer){

   var key = function (x) {return primer ? primer(x[field]) : x[field]};

   return function (a,b) {
       var A = key(a), B = key(b);
       return ((A < B) ? -1 :
               (A > B) ? +1 : 0) * [-1,1][+!!reverse];                  
   }
}