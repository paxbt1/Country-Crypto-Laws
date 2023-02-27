**We have articles covering Crypto news involving Countries, in which they keep changing their Crypto laws from Liberal to Restrictive and vice versa.**
**We want to keep the readers up to date with these Laws even when the article was written some time ago, and we don't want to revise all of our dozens of thousands of them, and then try to keep track of the updated laws.**
	
# Solution:
1. We need to Create a Custom Post Type called: Countries' Crypto Laws.
2. These Custom Post Types should be included/displayed at the bottom of articles.
3. A certain Custom Post Type should only appear, if the article is speaking about the same Country linked to the Custom Post Type. (For example: an Article speaking about the US enacting new laws as an aftermath of the FTX collapse, should only show the Custom Post Type of "Countries' Laws" assigned to the US, and also only when that article has Triggered this action by a Hook, Shortcode, or any other suggestion)
	
## Task requirements:
	Create Custom Post Type for Countries' Laws.
	Create a Taxonomy for Continents (Africa, Americas, Europe...etc)
	Continents must be registered once and never need to be added one more time.
	Choose how you would like to link the Post Type to the Taxonomy. (All suggestions are accepted, as this will be only used later for filtering, like counting metrics of the laws per continents...etc, so the only scope in the Task is to allow a later filtering by Continent, the task doesn't need anything more than linking the Post Type to a Taxonomy)
	Add a mechanism to link the created Custom Post Type to a Country. (Each country can be linked to a Single Custom Post Type Only, so it must be Unique)
	Create a Trigger mechanism to Display the Custom Post Type at the Bottom of any Article that calls for it.
	 The Countries' List must be up to date all the Time, hence we want to use REST to load it from https://restcountries.com/ , use v3 API.
	We want to make the Custom Post Type editor fast, so REST must be used within the backend code in PHP and not JS that loads after the page is rendered.
	We use GuzzleHTTP to make our REST requests from PHP.
	
## Guidelines:
	The Custom Post Types must be using Gutenberg for editing/adding new Posts, and not the legacy WYSIWYG editor, it should also allow the use of Gutenberg Blocks.
	We suggest the use of MetaBox for Selecting a given Country to be linked to the Post.
	We suggest to use the Country Name to be shown in the MetaBox drop down menu, while the value should be that of the CCA2 code, i.e. US for United States, BY for Belarus, UA for Ukraine...etc
	All options are accepted for linking Taxonomies.
	We suggest to create a Shortcode that accepts one argument that would be the CCA2 code, which an Editor can use at the bottom of their article to show the Country's Laws, i.e. [country-laws cca2="DZ"]
	If there are no Post assigned to the country, it should show nothing.
	Most importantly, the shortcode should only Display the Content of the Custom Post Type itself, and not include a full page to re-display the Header, Footer, Sidebars...etc
	For linking countries, we suggest the use of wp_options over the article meta info, but it's up to the developer.
	
## Coding Practices we'd like to see implemented:
	The use of Composer to manage the dependencies.
	The use of PSR-4 for Autoload and Namespaces.
	The use of Namespaces to avoid any future or current naming conflicts.
	All the PHP files should be Strictly Typed, and should include this line at their beginnings: declare(strict_types=1);
	If a plugin doesn't use any default mechanism like registering Styles, Languages, Scripts...etc then they should not be added as empty Stumbs.
	The use of 'camelCase' in Methods/Variables' names.
	All methods and/or arguments must have a predefined Type.
	We use PHP 8.1.
