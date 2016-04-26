# ritetag-colors
Colorize hashtags


## Servers example setup

### Laravel 5
1. copy ritetagApiLaravel folder to your www | htdocs.
2. write your tokens in config/ritetag.php.
3. edit route of "/api" to the suitable url you want.
4. route action is api@index , if you change that go and edit api.php controller as well. 
5. write that url to javascript as usage example shows.

## usage example

you should add class to your article or div called "ritecolor" like this 
```html
<article class="ritecolor">

</article>
```
then you require the js file , and call the init function after adding you keys  
```html
<script src="/dist/ritetag-colors.js"></script>
<script>
window.onload = function(){
	var rite = ritetagcolors;
	//your api url , see server examples
	rite.api = "http://localhost/ritetagApiPHP/";		
	rite.init();
};
</script>
```

check the full example in [index.html](https://github.com/Xloka/ritetag-colors/blob/master/index.html)
