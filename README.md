# ritetag-colors
Colorize hashtags check [demo](http://hackforward.ninja/ritetag-colors/index.html)
![](https://www.dropbox.com/s/1s89vys5zkracu8/f.png?raw=1)

## Installion 

**Download**
check all releases : [here](https://github.com/Xloka/ritetag-colors/releases)


**Bower**

```
bower install ritetag-colors
```


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
	rite.client = "your client id";		
	rite.init();
};
</script>
```

check the full example in [index.html](https://github.com/Xloka/ritetag-colors/blob/master/index.html)


