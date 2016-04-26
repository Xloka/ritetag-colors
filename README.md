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
	//your api url , see server examples
	rite.api = "http://localhost/ritetagApiPHP/";		
	rite.init();
};
</script>
```

check the full example in [index.html](https://github.com/Xloka/ritetag-colors/blob/master/index.html)
