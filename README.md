# ritetag-colors
Colorize hashtags


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
	rite.CONSUMER_KEY = 'Consumer Key';
	rite.CONSUMER_SECRET = 'Consumer Secret';
	rite.OAUTH_TOKEN = 'Token';
	rite.OAUTH_TOKEN_SECRET = 'Token Secret';
	rite.init();
};
</script>
```
